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
//        echo preg_match("/(hey|hello)/i", "Hey There");
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
                    'id' => $v['id']
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
                        'id' => $last['id']
                    );


                }
            }
        }
        foreach ($messages as $message) {
            $this->manageMessage($message);
        }
//        print_r($messages);
    }

    private function manageMessage($message)
    {
        $res = [];
        $phrases = $this->model('phrases')->getAll();
        $highest_wt = [];
        $macro = [];
        $once = [];
        $wildcard = [];
        foreach ($phrases as $v) {
            switch($v['status_id']) {
                case "3":
                    $once[] = $v;
                    break;
                case "4":
                    $highest_wt[] = $v;
                    break;
                case "2":
                case "8":
                    $macro[$v['mask']] = $v['reply'];
                    break;
                case "11":
                    $wildcard[] = $v;
            }
        }
        $sms = '';
        $delay = MIN_DELAY;
        foreach ($highest_wt as $v) {
            if(preg_match("/" . $v['mask'] . "/", $message['text'])) {
                $sms = $v['reply'];
                preg_match("/\{[^\}]*\}/", $sms, $matches);
                if($matches) {
                    foreach ($matches as $match) {
                        $m = strtr($match, array('{' => '', '}' => ''));
                        $arr = explode('|', $m);
                        $choice = $arr[rand(0, count($arr) - 1)];
                        $sms = str_replace($match, $choice, $sms);
                    }
                }
                $delay = $v['delay'];
            }
        }
        if(!$sms) {
            foreach ($once as $v) {
                if(preg_match("/" . $v['mask'] . "/i", $message['text'])) {
                    $sms = $v['reply'];
                    preg_match("/\{[^\}]*\}/", $sms, $matches);
                    if($matches) {
                        foreach ($matches as $match) {
                            $m = strtr($match, array('{' => '', '}' => ''));
                            $arr = explode('|', $m);
                            $choice = $arr[rand(0, count($arr) - 1)];
                            $sms = str_replace($match, $choice, $sms);
                        }
                    }
                    $delay = $v['delay'];
                }
            }
        }
        if(!$sms) {
            $sms = $wildcard[0]['reply'];
        }
        $sms = strtr($sms, $macro);
        $res = array(
            'sms' => $sms,
            'phone' => $message['phone'],
            'user_id' => $message['user_id'],
            'send_time' => date('Y-m-d H:i:s', $message['time'] + $delay),
            'message_id' => $message['id']
        );

        $this->putInQueue($res);
    }

    private function putInQueue(array $message)
    {
        $row = [];
        $row['message_status'] = 1;
        $row['id'] = $message['message_id'];
        $this->model('messages')->insert($row);
        $message['create_date'] = date('Y-m-d H:i:s');
        $this->model('queues')->insert($message);
    }

    public function checkQueue()
    {
        $messages = $this->model('queues')->getMessagesToSend();
        print_r($messages);
        foreach ($messages as $message) {
            $this->sendMessage($message);
        }
    }

    private function sendMessage($message)
    {
        print_r($message);
        $row = [];
        $row['message_status'] = 2;
        $row['id'] = $message['message_id'];
        $this->model('messages')->insert($row);
        $message['sent'] = 1;
        $this->model('queues')->insert($message);
    }
}