<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 09.06.2016
 * Time: 12:14
 */
class emulator_controller extends controller
{
    public function index()
    {
        $this->render('users', $this->model('users')->getAll());
        $this->getMessages();
        $this->view('index' . DS . 'emulator');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "send_message":
                $params = $_POST['message'];
                $url = '/api/?' . http_build_query($params);
                $ch = curl_init();
                curl_setopt ($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec ($ch);
                curl_close($ch);
                var_dump($result);
                exit;
                break;

            case "update_messages":
                $this->getMessages();
                $template = $this->fetch('index' . DS . 'ajax' . DS . 'chats');
                echo json_encode(array('status' => 1, 'template' => $template, 'time' => date('Y-m-d H:i:s')));
                exit;
                break;
        }
    }

    private function getMessages()
    {
        $user = $this->model('users')->getById(1);
        if($_POST['user_id']) {
            $user = $this->model('users')->getById($_POST['user_id']);
        }
        $tmp = $this->model('messages')->getByField('user_id', $user['id'], true, 'push_date DESC', 12);
        $outcoming = $this->model('queues')->getByFields(array('user_id' => $user['id'], 'sent' => 1), true, 'send_time DESC', 6);
        $messages = [];
        $incoming = [];
        $concat = [];
        foreach ($tmp as $k => $v) {
            if(!$v['concat']) {
                $incoming[] = array(
                    'time' => strtotime($v['push_date']),
                    'phone' => $user['phone'],
                    'user_id' => $v['user_id'],
                    'text' => $v['content'],
                    'status' => $v['message_status']
                );
            } else {
                $concat[$v['concat']]['parts'][$v['concat_count']] = $v['content'];
                $concat[$v['concat']]['total'] = $v['concat_total'];
                if(count($concat[$v['concat']]['parts']) == $v['concat_total']) {
                    ksort($concat[$v['concat']]['parts']);
                    $parts = [];
                    foreach ($concat[$v['concat']]['parts'] as $part) {
                        $parts[] = $part;
                    }
                    $incoming[] = array(
                        'time' => strtotime($v['push_date']),
                        'phone' => $user['phone'],
                        'user_id' => $v['user_id'],
                        'text' => implode('', $parts),
                        'status' => $v['message_status']
                    );
                }
            }
        }
        foreach ($incoming as $mess) {
            if($messages[$mess['time']]) {
                $key = $mess['time'] + 1;
                if($messages[$key]) {
                    $key+= 1;
                    if($messages[$key]) {
                        $key+= 1;
                        if($messages[$key]) {
                            $key+= 1;
                            if($messages[$key]) {
                                $key+= 1;
                                if($messages[$key]) {
                                    $key+= 1;
                                    if($messages[$key]) {
                                        $key+= 1;
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $key = $mess['time'];
            }
            $messages[$key] = array(
                'phone' => $user['phone'],
                'text' => $mess['text'],
                'incoming' => true,
                'time' => date('H:i:s', $mess['time'])
            );
        }
        foreach ($outcoming as $mess) {
            if($messages[strtotime($mess['send_time'])]) {
                $key = strtotime($mess['send_time']) + 1;
                if($messages[$key]) {
                    $key+= 1;
                    if($messages[$key]) {
                        $key+= 1;
                        if($messages[$key]) {
                            $key+= 1;
                            if($messages[$key]) {
                                $key+= 1;
                                if($messages[$key]) {
                                    $key+= 1;
                                    if($messages[$key]) {
                                        $key+= 1;
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $key = strtotime($mess['send_time']);
            }
            $messages[$key] = array(
                'text' => $mess['sms'],
                'incoming' => false,
                'time' => date('H:i:s', strtotime($mess['send_time']))
            );
        }
        ksort($messages);
        $this->render('messages', $messages);
    }
}