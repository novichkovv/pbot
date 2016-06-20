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
        $this->render('breadcrumbs', array(
            array('name' => 'Home', 'route' => SITE_DIR),
            array('name' => 'Messenger')
        ));

        $campaigns = $this->model('campaigns')->getAll();
        $this->render('campaigns', $campaigns);
        if(!$_GET['campaign']) {
            if($_SESSION['campaign']) {
                $campaign = $this->model('campaigns')->getById($_SESSION['campaign']);
            } else {
                $campaign = $campaigns[0];
                $_SESSION['campaign'] = $campaigns[0]['id'];
            }
        } else {
            $campaign = $this->model('campaigns')->getById($_GET['campaign']);
            $_SESSION['campaign'] = $campaign['id'];
        }
        $this->render('campaign', $campaign);

        $phones = $this->model('virtual_numbers')->getByField('campaign_id', $campaign['id'], true);
        $this->render('phones', $phones);
        $number_id = false;
        if($_GET['number_id']) {
            foreach ($phones as $phone) {
                if($_GET['number_id'] == $phone['phone']) {
                    $number_id = $phone['phone'];
                }
            }
        }
        if(!$number_id) {
            $number_id = $phones[0]['phone'];
        }
        $this->render('number_id', $number_id);
        $users = $this->model('messages')->getNumberUsers($number_id);
        $this->render('users', $users);
        if($_GET['user_id']) {
            $user = $this->model('users')->getById($_GET['user_id']);
        } else {
            $user = $users[0];
        }
        $latest = $this->getLatest();
        $this->render('latest', $latest);
        $this->getMessages($user, $campaign, $number_id);
        $this->render('user', $user);
        $this->render('current_campaign', $campaign);
        $this->view('index' . DS . 'emulator');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "prevent_override":
                foreach ($this->model('queues')->getByFields([
                    'user_id' => $_POST['user_id'],
                    'campaign_id' => $_POST['campaign_id'],
                    'recipient' => $_POST['recipient'],
                    'sent' => 0
                ], true) as $queue) {
                    $queue['sent'] = 2;
                    $this->model('queues')->insert($queue);
                    if($queue['message_id']) {
                        $row = [];
                        $row['id'] = $queue['message_id'];
                        $row['message_status'] = 2;
                        $this->model('messages')->insert($row);
                    }
                }
                exit;
                break;

            case "override":
                $message = $_POST['override'];
                $user = $this->model('users')->getById($message['user_id']);
                $message['phone'] = $user['phone'];
                $message['send_time'] = date('Y-m-d H:i:s');
                $message['global_plot'] = 1;
                $cron = new cron_class();
                $cron->putInQueue($message);
                exit;
                break;

            case "update_last_message":
                $latest = $this->getLatest();
                $this->render('latest', $latest);
                $template = $this->fetch('index' . DS . 'ajax' . DS . 'last_message');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;

            case "update_messages":
                $user = $this->model('users')->getById($_POST['user_id']);
                $campaign = $this->model('campaigns')->getById($_POST['campaign_id']);
                $this->getMessages($user, $campaign, $_POST['phone']);
                $template = $this->fetch('index' . DS . 'ajax' . DS . 'chats');
                echo json_encode(array('status' => 1, 'template' => $template, 'time' => date('Y-m-d H:i:s')));
                require_once(ROOT_DIR . 'cron.php');
                exit;
                break;

            case "clear_chat":
                $this->model('messages')->deleteByFields([
                    'user_id' => $_POST['user_id'],
                    'recipient' => $_POST['number'],
                    'campaign_id' => $_POST['campaign_id']
                ]);
                $this->model('queues')->deleteByFields([
                    'user_id' => $_POST['user_id'],
                    'recipient' => $_POST['number'],
                    'campaign_id' => $_POST['campaign_id']
                ]);
                $this->model('user_phrases')->deleteByFields([
                    'user_id' => $_POST['user_id'],
                    'virtual_number' => $_POST['number']
                ]);
                exit;
                break;
        }
    }

    private function getLatest()
    {
        $latest = $this->model('messages')->getLatestMessage();
        $sms = $latest['content'];
        if($latest['concat']) {
            $sms = '';
            foreach ($this->model('messages')->getByField('concat', $latest['concat'], true, 'concat_count') as $message) {
                $sms .= $message['content'];
            }
        }
        $latest['content'] = $sms;
        return $latest;
    }

    private function getMessages($user, $campaign, $number_id)
    {
//        echo $user['id']."\n";
//        echo $campaign['id']."\n";
//        echo $number_id;
//        exit;
//        print_r($user);
//        print_r($campaign);
//        echo $number_id;
//        exit;
        $tmp = $this->model('messages')->getByFields(['user_id' => $user['id'], 'campaign_id' => $campaign['id'], 'recipient' => $number_id], true, 'push_date DESC', 100);
        $outcoming = $this->model('queues')->getByFields(array('user_id' => $user['id'], 'sent' => 1,  'campaign_id' => $campaign['id'], 'recipient' => $number_id), true, 'send_time DESC', 6);
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