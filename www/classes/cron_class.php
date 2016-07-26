<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 09.06.2016
 * Time: 23:01
 */
class cron_class extends base
{
    private $blacklist = [];

    public function __construct()
    {
        if(!$tmp = registry::get('system_settings')['global_delay']) {
            $tmp = '20-30';
        }
        $arr = explode('-', $tmp);
        $delay = rand($arr[0], $arr[1]);
        if(!$delay) {
            $delay = 30;
        }
        define('GLOBAL_DELAY', $delay);
        if(!$tmp = registry::get('system_settings')['delay']) {
            $tmp = '20-30';
        }

        $arr = explode('-', $tmp);
        $delay = rand($arr[0], $arr[1]);
        if(!$delay) {
            $delay = 30;
        }
        define('MIN_DELAY', $delay); //in seconds
        $blacklist = [];
        foreach ($this->model('blacklist')->getAll() as $v) {
            $blacklist[$v['user_id']][$v['phone']] = true;
        }
        $this->blacklist = $blacklist;

    }

    public function init()
    {
        $this->readMessages();
    }

    public function readMessages()
    {
        /*
         * Statuses
         * 0 - received
         * 1 - in queue
         * 2 - sent
         * 3 -
         * 4 - concat parts
         */
        $tmp = $this->model('messages')->getUnclosedMessages();
        $messages = [];
        $concat = [];
        foreach ($tmp as $k => $v) {
            if(!$v['concat']) {
                $messages[] = array(
                    'time' => strtotime($v['push_date']),
                    'phone' => $v['phone'],
                    'user_id' => $v['user_id'],
                    'text' => $v['content'],
                    'status' => $v['message_status'],
                    'id' => $v['id'],
                    'recipient' => $v['recipient'],
                    'campaign_id' => $v['campaign_id']
                );
            } else {
                $concat[$v['concat']]['parts'][$v['concat_count']]['content'] = $v['content'];
                $concat[$v['concat']]['parts'][$v['concat_count']]['id'] = $v['id'];
                $concat[$v['concat']]['total'] = $v['concat_total'];
                if(count($concat[$v['concat']]['parts']) == $v['concat_total']) {
                    ksort($concat[$v['concat']]['parts']);
                    $parts = [];
                    foreach ($concat[$v['concat']]['parts'] as $part) {
                        $parts[] = $part['content'];
                    }
                    $last = array_pop($concat[$v['concat']]['parts']);
                    foreach ($concat[$v['concat']]['parts'] as $part) {
                        $row = [];
                        $row['id'] = $part['id'];
                        $row['message_status'] = 4;
                        $this->model('messages')->insert($row);
                    }

                    $messages[] = array(
                        'time' => strtotime($v['push_date']),
                        'phone' => $v['phone'],
                        'user_id' => $v['user_id'],
                        'text' => implode('', $parts),
                        'status' => $v['message_status'],
                        'id' => $last['id'],
                        'recipient' => $v['recipient'],
                        'campaign_id' => $v['campaign_id']
                    );


                }
            }
        }
        $m = [];
        foreach ($messages as $message) {
            $m[$message['user_id'] . $message['recipient']][] = $message;
        }
        foreach ($m as $message) {
            if(count($message) > 1) {
                if(count($message) > 2) {
                    foreach ($message as $k => $v) {
                        $check[strtotime($v['push_date'])] = $k;
                    }
                    ksort($check);
                    $index = array_shift($check);
                    $row = [];
                    $row['id'] = $message[$index];
                    $row['message_status'] = 1;
                    $this->model('messages')->insert($row);
                    unset($message[$index]);
                }

                $res = [
                    'phone' => $message[0]['phone'],
                    'user_id' => $message[0]['user_id'],
                    'status' => $message[0]['message_status'],
                    'id' => $message[0]['id'],
                    'recipient' => $message[0]['recipient'],
                    'campaign_id' => $message[0]['campaign_id']
                ];
                $res['text'] = '';
                foreach ($message as $parts) {
                    $res['text'] .= $parts['text'] . ' ';
                    if(!$res['time'] || $res['time'] < $parts['time']) {
                        $res['time'] = $parts['time'];
                    }
                }
            } else {
                $res = $message[array_keys($message)[0]];
            }
            $this->manageMessage($res);
        }
    }

    private function manageMessage($message)
    {
//        print_r($message);
//        exit;
        if($this->model('queues')->getByFields(['user_id' => $message['user_id'], 'sent' => 0, 'campaign_id' => $message['campaign_id'], 'recipient' => $message['recipient']])) {
            $this->model('messages')->markOtherMessages($message['user_id'], $message['campaign_id'], $message['recipient']);
            return;
        }
        $user_phrases = $this->model('phrases')->getLastUserPhrases($message['user_id'], $message['campaign_id'], $message['recipient']);
        $phrases = $this->model('phrases')->getByField('campaign_id', $message['campaign_id'], true, 'sort_order');
        $highest_wt = [];
        $macro = [];
        $once = [];
        $wildcard = [];
        $high_wt = [];
        $normal_wt = [];
        $globals = [];
        foreach ($phrases as $v) {
            switch($v['status_id']) {
                case "1":
                    $welcome = $v;
                    break;
                case "3":
                    $once[] = $v;
                    break;
                case "4":
                    $highest_wt[] = $v;
                    break;
                case "5":
                    $high_wt[] = $v;
                    break;
                case "6":
                    $normal_wt[] = $v;
                    break;
                case "2":
                case "8":
                    $macro[$v['mask']] = $v['reply'];
                    break;
                case "9":
                    $globals[] = $v;
                    break;
                case "11":
                    $wildcard[] = $v;
                    break;
            }
        }
        ksort($once);
        ksort($highest_wt);
        ksort($high_wt);
        ksort($normal_wt);
        ksort($wildcard);
        ksort($globals);
        $sms = '';
        $delay = MIN_DELAY;
        $global = false;
        if(!$user_phrases && isset($welcome)) {
            $sms = $welcome['reply'];
            $delay = $welcome['delay'];
            $this->model('user_phrases')->insert(['user_id' => $message['user_id'], 'phrase_id' => $welcome['id'], 'create_date' => date('Y-m-d H:i:s'), 'virtual_number' => $message['recipient']]);
        }
        if(!$sms) {
            foreach ($highest_wt as $v) {
                if(@preg_match("/" . $v['mask'] . "/", $message['text'], $matches)) {
                    $sms = $v['reply'];
                    $delay = $v['delay'];
                    $match_word = $matches[0];
                    $this->model('user_phrases')->insert(['user_id' => $message['user_id'], 'phrase_id' => $v['id'], 'create_date' => date('Y-m-d H:i:s'), 'virtual_number' => $message['recipient']]);
                    break;
                }
            }
        }
        if(!$sms) {
            foreach ($high_wt as $v) {
                if(@preg_match("/" . $v['mask'] . "/", $message['text'], $matches)) {
                    $match_word = $matches[0];
                    $sms = $v['reply'];
                    $delay = $v['delay'];
                    $this->model('user_phrases')->insert(['user_id' => $message['user_id'], 'phrase_id' => $v['id'], 'create_date' => date('Y-m-d H:i:s'), 'virtual_number' => $message['recipient']]);
                    break;
                }
            }
        }
//        if(!$sms && rand(0,3) == 1) {
//            foreach ($globals as $v) {
//                if($user_phrases[9][$v['id']]) {
//                    continue;
//                }
//                $sms = $v['reply'];
//                $delay = $v['delay'];
//                $global = true;
//                $this->model('user_phrases')->insert(['user_id' => $message['user_id'], 'phrase_id' => $v['id'], 'create_date' => date('Y-m-d H:i:s'), 'virtual_number' => $message['recipient']]);
//                break;
//            }
//        }
        if(!$sms) {
            foreach ($normal_wt as $v) {
//                if($user_phrases[6][$v['id']]) {
//                    continue;
//                }
                if(@preg_match("/" . $v['mask'] . "/", $message['text'], $matches)) {
                    $match_word = $matches[0];
                    $sms = $v['reply'];
                    $delay = $v['delay'];
                    $this->model('user_phrases')->insert(['user_id' => $message['user_id'], 'phrase_id' => $v['id'], 'create_date' => date('Y-m-d H:i:s'), 'virtual_number' => $message['recipient']]);
                    break;
                }
            }
        }
        if(!$sms) {
            foreach ($once as $v) {
                if($user_phrases[3][$v['id']]) {
                    continue;
                }
                if(@preg_match("/" . $v['mask'] . "/i", $message['text'], $matches)) {
                    $sms = $v['reply'];
                    $delay = $v['delay'];
                    $match_word = $matches[0];
                    $this->model('user_phrases')->insert(['user_id' => $message['user_id'], 'phrase_id' => $v['id'], 'create_date' => date('Y-m-d H:i:s'), 'virtual_number' => $message['recipient']]);
                    break;
                }
            }
        }
        if(!$sms) {
            foreach ($wildcard as $v) {
                if($user_phrases[11][$v['id']]) {
                    continue;
                }
                $sms = $v['reply'];
                $delay = $v['delay'];
                $this->model('user_phrases')->insert(['user_id' => $message['user_id'], 'phrase_id' => $v['id'], 'create_date' => date('Y-m-d H:i:s'), 'virtual_number' => $message['recipient']]);
                break;
            }
        }
        $sms = strtr($sms, $macro);
        if(!$delay) {
            $delay = MIN_DELAY;
        }

        if(false !== strpos($sms, '%GEO%')) {
            $state = $this->model('state_codes')->getByField('state_code', substr($message['phone'], 1, 3))['state'];
            if(!$state) {
                $state = "I'm close to you";
            }
            $sms = str_replace('%GEO%', $state, $sms);
        }
        if(false !== strpos($sms, '%COUNTY%')) {
            $county = $this->model('county_codes')->getByField('county_code', substr($message['phone'], 1, 3))['county'];
            if (!$county) {
                $county = $this->model('state_codes')->getByField('state_code', substr($message['phone'], 1, 3))['state'];
            }
            if(!$county) {
                $county = "I'm close to you";
            }
            $sms = str_replace('%COUNTY%', $county, $sms);
        }
        @preg_match_all("/\{[^\}]*\}/", $sms, $matches);
        if($matches[0]) {
            foreach ($matches[0] as $match) {
                $m = strtr($match, array('{' => '', '}' => ''));
                $arr = explode('|', $m);
                foreach ($arr as $k => $v) {
                    if(!empty($match_word) && false !== strpos($v, $match_word) && count($arr) > 1) {
                        unset($arr[$k]);
                    }
                }
                $choice = $arr[array_rand($arr)];
                $sms = str_replace($match, $choice, $sms);
            }
        }
        $res = array(
            'sms' => $sms,
            'phone' => $message['phone'],
            'user_id' => $message['user_id'],
            'send_time' => date('Y-m-d H:i:s', $message['time'] + $delay),
            'message_id' => $message['id'],
            'global_plot' => $global ? 1 : 0,
            'recipient' => $message['recipient'],
            'campaign_id' => $message['campaign_id']
        );
        $this->putInQueue($res);
    }

    public function putInQueue(array $message)
    {
        print_r($message);
        if($message['sms']) {
            if ($message['message_id']) {
                $row = [];
                $row['message_status'] = 1;
                $row['id'] = $message['message_id'];
                $this->model('messages')->insert($row);
            }
            $message['create_date'] = date('Y-m-d H:i:s');
            $this->model('queues')->insert($message);
        }
    }

    public function checkQueue()
    {
        $messages = $this->model('queues')->getMessagesToSend();
        foreach ($messages as $message) {
            $this->sendMessage($message);
        }
    }

    private function sendMessage($message)
    {
        if($message['sms']) {
            if ($message['message_id']) {
                $row = [];
                $row['message_status'] = 2;
                $row['id'] = $message['message_id'];
                $this->model('messages')->insert($row);
            }
            $message['sent'] = 1;
            $this->model('queues')->insert($message);
            if(!in_array($message['phone'], [111,222,333,444,555,666,777,888,999]) && DEVELOPMENT_MODE == false) {
                $this->api()->sendMessage($message['phone'], $message['sms'], ['from' => $message['recipient']]);
            }
        }
    }

    public function checkGlobals()
    {
        $count_1 = 0;
        $count_2 = 0;
        $today_users = $this->model('queues')->getTodayUsers();
        $to_keep = $this->model('queues')->getForGlobals($today_users);
        $globals = [];
        foreach ($this->model('phrases')->getByFields(['status_id' => 9], true, 'sort_order') as $v) {
            $globals[$v['campaign_id']][] = $v;
        }
        foreach ($to_keep as $user_to_keep) {
            $count_1 ++;
            if ($user_to_keep['global_plot'] >= 1 || time() - strtotime($user_to_keep['send_time']) < GLOBAL_DELAY  || time() - strtotime($user_to_keep['send_time']) > GLOBAL_DELAY + 5*60 || $user_to_keep['sent'] == 0) {
                continue;
            }
            $count_2 ++;
            $user_phrases = $this->model('phrases')->getLastUserPhrases($user_to_keep['user_id'], $user_to_keep['campaign_id'], $user_to_keep['recipient']);
            if(!$globals[$user_to_keep['campaign_id']]) {
                continue;
            }
            foreach ($globals[$user_to_keep['campaign_id']] as $global) {
                if ($user_phrases[9][$global['id']]) {
                    continue;
                }
                $tmp = $this->model('phrases')->getPhrasesWithStatusIn([2, 8], $user_to_keep['campaign_id']);
                $macro = [];
                foreach ($tmp as $v) {
                    $macro[$v['mask']] = $v['reply'];
                }
                $sms = strtr($global['reply'], $macro);
                @preg_match_all("/\{[^\}]*\}/", $sms, $matches);
                if($matches[0]) {
                    foreach ($matches[0] as $match) {
                        $m = strtr($match, array('{' => '', '}' => ''));
                        $arr = explode('|', $m);
                        foreach ($arr as $k => $v) {
                            if(!empty($match_word) && false !== strpos($v, $match_word) && count($arr) > 1) {
                                unset($arr[$k]);
                            }
                        }
                        $choice = $arr[array_rand($arr)];
                        $sms = str_replace($match, $choice, $sms);
                    }
                }
                if(false !== strpos($sms, '%GEO%')) {
                    $state = $this->model('state_codes')->getByField('state_code', substr($user_to_keep['phone'], 1, 3))['state'];
                    if(!$state) {
                        $state = "I'm close to you";
                    }
                    $sms = str_replace('%GEO%', $state, $sms);
                }
                if(false !== strpos($sms, '%COUNTY%')) {
                    $county = $this->model('county_codes')->getByField('county_code', substr($user_to_keep['phone'], 1, 3))['county'];
                    if (!$county) {
                        $county = $this->model('state_codes')->getByField('state_code', substr($user_to_keep['phone'], 1, 3))['state'];
                    }
                    if(!$county) {
                        $county = "I'm close to you";
                    }
                    $sms = str_replace('%COUNTY%', $county, $sms);
                }
                $res = array(
                    'sms' => $sms,
                    'phone' => $user_to_keep['phone'],
                    'user_id' => $user_to_keep['user_id'],
                    'send_time' => date('Y-m-d H:i:s'),
                    'message_id' => 0,
                    'recipient' => $user_to_keep['recipient'],
                    'global_plot' => 1,
                    'campaign_id' => $user_to_keep['campaign_id']
                );
                $this->model('user_phrases')->insert(['user_id' => $user_to_keep['user_id'], 'phrase_id' => $global['id'], 'create_date' => date('Y-m-d H:i:s'), 'virtual_number' => $user_to_keep['recipient']]);
                if(!$this->blacklist[$res['user_id']][$res['recipient']]) {
                    $this->putInQueue($res);
                }
                break;
            }
        }
        $keeps = [];
        foreach ($this->model('phrases')->getByField('status_id', 10, true) as $v) {
            $keeps[$v['campaign_id']][] = $v;
        }

        foreach ($to_keep as $user_to_keep) {
            /* switch */
            $first_message = $this->model('messages')->getByFields(['recipient' => $user_to_keep['recipient'], 'user_id' => $user_to_keep['user_id']], false, 'push_date', 1);
            if($first_message && time() - registry::get('system_settings')['switch_days']*24*3600 > strtotime($first_message['push_date'])) {
                $campaign = $this->model('virtual_numbers')->getByField('phone', $user_to_keep['recipient'])['campaign_id'];
                if(!$campaign) {
                    $campaign = $this->model('campaigns')->getAll()[1]['id'];
                }
                $check = false;
                foreach ($this->model('campaigns')->getAll('sort_order') as $v) {
                    if($check) {
                        $new_campaign = $v;
                        break;
                    }
                    if($v['id'] == $campaign) {
                        $check = true;
                    }
                }
                if(!$new_campaign['id']) {
                    $new_campaign = $this->model('campaigns')->getAll('sort_order', 1)[0];
                }
                $numbers = $this->model('virtual_numbers')->getByField('campaign_id', $new_campaign['id'], true);
                if($numbers) {
                    $new_number = $numbers[rand(0, count($numbers) - 1)]['phone'];
//                        $rows = [];
//                        $date = date('Y-m-d H:i:s');
//                        foreach ($this->model('phrases')->getUserPhrasesByStatus($user_to_keep['user_id'], $user_to_keep['recipient']) as $phrase) {
//                            foreach ($this->model('phrases')->getByFields(['status_id' => $phrase['status_id'], 'campaign_id' => $new_campaign['id']], true, 'sort_order, id', $phrase['count']) as $v) {
//                                $rows[] = [
//                                    'phrase_id' => $v['id'],
//                                    'virtual_number' => $new_number,
//                                    'create_date' => $date,
//                                    'user_id' => $user_to_keep['user_id']
//                                ];
//                            }
//                        }
//                        if($rows) {
//                            $this->model('user_phrases')->insertRows($rows);
//                        }
                    $user_to_keep['recipient'] = $new_number;
                    $user_to_keep['campaign_id'] = $new_campaign['id'];
                }
            }
            /** switch */
            $user_phrases = $this->model('phrases')->getLastUserPhrases($user_to_keep['user_id'], $user_to_keep['campaign_id'], $user_to_keep['recipient']);
            if(!$keeps[$user_to_keep['campaign_id']]) {
                continue;
            }

            foreach ($keeps[$user_to_keep['campaign_id']] as $phrase) {
                if ($user_phrases[10][$phrase['id']] || (!$user_phrases && !$new_campaign )) {
                    continue;
                }

                if(time() - strtotime($user_to_keep['send_time']) >= $phrase['delay']) {
                    $tmp = $this->model('phrases')->getPhrasesWithStatusIn([2, 8], $user_to_keep['campaign_id']);
                    $macro = [];
                    foreach ($tmp as $v) {
                        $macro[$v['mask']] = $v['reply'];
                    }

                    $sms = strtr($phrase['reply'], $macro);
                    if(false !== strpos($sms, '%GEO%')) {
                        $state = $this->model('state_codes')->getByField('state_code', substr($user_to_keep['phone'], 1, 3))['state'];
                        if(!$state) {
                            $state = "I'm close to you";
                        }
                        $sms = str_replace('%GEO%', $state, $sms);
                    }
                    if(false !== strpos($sms, '%COUNTY%')) {
                        $county = $this->model('county_codes')->getByField('county_code', substr($user_to_keep['phone'], 1, 3))['county'];
                        if (!$county) {
                            $county = $this->model('state_codes')->getByField('state_code', substr($user_to_keep['phone'], 1, 3))['state'];
                        }
                        if(!$county) {
                            $county = "I'm close to you";
                        }
                        $sms = str_replace('%COUNTY%', $county, $sms);
                    }
                    @preg_match_all("/\{[^\}]*\}/", $sms, $matches);
                    if($matches[0]) {
                        foreach ($matches[0] as $match) {
                            $m = strtr($match, array('{' => '', '}' => ''));
                            $arr = explode('|', $m);
                            foreach ($arr as $k => $v) {
                                if(!empty($match_word) && false !== strpos($v, $match_word) && count($arr) > 1) {
                                    unset($arr[$k]);
                                }
                            }
                            $choice = $arr[array_rand($arr)];
                            $sms = str_replace($match, $choice, $sms);
                        }
                    }
                    $res = array(
                        'sms' => $sms,
                        'phone' => $user_to_keep['phone'],
                        'user_id' => $user_to_keep['user_id'],
                        'send_time' => date('Y-m-d H:i:s'),
                        'message_id' => 0,
                        'recipient' => $user_to_keep['recipient'],
                        'global_plot' => 2,
                        'campaign_id' => $user_to_keep['campaign_id']
                    );
                    $this->model('user_phrases')->insert(['user_id' => $user_to_keep['user_id'], 'phrase_id' => $phrase['id'], 'create_date' => date('Y-m-d H:i:s'), 'virtual_number' => $user_to_keep['recipient']]);
                    if(!$this->blacklist[$res['user_id']][$res['recipient']]) {
                        $this->putInQueue($res);
                    }
                    break;
                }
            }
        }
//        $this->writeLog('test', 'c1 - ' . $count_1);
//        $this->writeLog('test', 'c2 - ' . $count_2);
    }

    public function cleanUp()
    {
        $this->model('messages')->cleanOldMessages();
        $this->model('queues')->cleanOldQueues();
        $this->model('phrases')->cleanOldUserPhrases();
    }
}