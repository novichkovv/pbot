<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 09.06.2016
 * Time: 23:01
 */
class cron_class extends base
{
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
        foreach ($messages as $message) {
            $this->manageMessage($message);
        }
    }

    private function manageMessage($message)
    {
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
        if(!$sms && rand(0,3) == 1) {
            foreach ($globals as $v) {
                if($user_phrases[9][$v['id']]) {
                    continue;
                }
                $sms = $v['reply'];
                $delay = $v['delay'];
                $global = true;
                $this->model('user_phrases')->insert(['user_id' => $message['user_id'], 'phrase_id' => $v['id'], 'create_date' => date('Y-m-d H:i:s'), 'virtual_number' => $message['recipient']]);
                break;
            }
        }
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
            if(!in_array($message['phone'], [111,222,333,444,555,666,777,888,999])) {
                $this->api()->sendMessage($message['phone'], $message['sms'], ['from' => $message['recipient']]);
            }
        }
    }

    public function checkGlobals()
    {
        $today_users = $this->model('queues')->getTodayUsers();
        /*
         * Global plots
         */
        foreach ($this->model('campaigns')->getAll() as $campaign) {
            $to_keep = $this->model('queues')->getForGlobals($campaign['id'], $today_users[$campaign['id']]);
            $globals = $this->model('phrases')->getByFields(['status_id' => 9, 'campaign_id' => $campaign['id']], true, 'sort_order');
            foreach ($to_keep as $user_to_keep) {
                $user_phrases = $this->model('phrases')->getLastUserPhrases($user_to_keep['user_id'], $campaign['id'], $user_to_keep['recipient']);
                foreach ($globals as $global) {
                    if($user_phrases[9][$global['id']]) {
                        continue;
                    }
                    $tmp = $this->model('phrases')->getPhrasesWithStatusIn([2,8], $campaign['id']);
                    $macro = [];
                    foreach ($tmp as $v) {
                        $macro[$v['mask']] = $v['reply'];
                    }
                    $sms = strtr($global['reply'], $macro);
                    $res = array(
                        'sms' => $sms,
                        'phone' => $user_to_keep['phone'],
                        'user_id' => $user_to_keep['user_id'],
                        'send_time' => date('Y-m-d H:i:s'),
                        'message_id' => 0,
                        'global_plot' => 1,
                        'campaign_id' => $campaign['id']
                    );
                    $this->model('user_phrases')->insert(['user_id' => $user_to_keep['user_id'], 'phrase_id' => $global['id'], 'create_date' => date('Y-m-d H:i:s'), 'virtual_number' => $user_to_keep['recipient']]);
                    $this->putInQueue($res);
                    break;
                }
            }

            /*
             * keep alive
             */
            $keeps = $this->model('phrases')->getByField('status_id', 10, true);
            foreach ($keeps as $keep) {
                $to_keep = $this->model('queues')->getToKeepAlive($keep['delay'], $campaign['id'], $today_users[$campaign['id']]);
                foreach ($to_keep as $user_to_keep) {
                    $user_phrases = $this->model('phrases')->getLastUserPhrases($user_to_keep['user_id'], $campaign['id'], $user_to_keep['recipient']);
                    $stop = false;
                    if($user_phrases[10]) {
                        foreach ($user_phrases[10] as $kept) {
                            if($kept['delay'] == $keep['delay']) {
                                $stop = true;
                            }
                        }
                    }
                    if($stop) {
                        continue;
                    }
                    $tmp = $this->model('phrases')->getPhrasesWithStatusIn([2,8], $campaign['id']);
                    $macro = [];
                    foreach ($tmp as $v) {
                        $macro[$v['mask']] = $v['reply'];
                    }
                    $sms = strtr($keep['reply'], $macro);
                    $res = array(
                        'sms' => $sms,
                        'phone' => $user_to_keep['phone'],
                        'user_id' => $user_to_keep['user_id'],
                        'send_time' => date('Y-m-d H:i:s'),
                        'message_id' => 0,
                        'global_plot' => 1,
                        'campaign_id' => $campaign['id']
                    );
                    $this->model('user_phrases')->insert(['user_id' => $user_to_keep['user_id'], 'phrase_id' => $keep['id'], 'create_date' => date('Y-m-d H:i:s'), 'virtual_number' => $user_to_keep['recipient']]);
                    $this->putInQueue($res);
                }
            }
        }


    }
}