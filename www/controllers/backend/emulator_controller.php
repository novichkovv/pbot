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
        $this->render('users', $this->model('users')->getAll());
        $user = $this->model('users')->getById(1);
        if($_GET['user_id']) {
            $user = $this->model('users')->getById($_GET['user_id']);
        }

        $campaigns = $this->model('campaigns')->getAll();
        $this->render('campaigns', $campaigns);
        if(!$_GET['campaign']) {
            if($_SESSION['campaign']) {
                $campaign = $this->model('campaigns')->getById($_SESSION['campaign']);
            } else {
                $campaign = $campaigns[0];
            }
        } else {
            $campaign = $this->model('campaigns')->getById($_GET['campaign']);
        }
        $this->getMessages($user, $campaign);
        $this->render('user', $user);
        $this->render('current_campaign', $campaign);
        $this->view('index' . DS . 'emulator');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "update_messages":
                $user = $this->model('users')->getById($_POST['user_id']);
                $campaign = $this->model('campaigns')->getById($_POST['campaign_id']);
                $this->getMessages($user, $campaign);
                $template = $this->fetch('index' . DS . 'ajax' . DS . 'chats');
                echo json_encode(array('status' => 1, 'template' => $template, 'time' => date('Y-m-d H:i:s')));
                require_once(ROOT_DIR . 'cron.php');
                exit;
                break;

            case "clear_chat":
                if(empty($_POST['user_id'])) {
                    exit;
                }
                $this->model('user_phrases')->delete('user_id', $_POST['user_id']);
                $this->model('messages')->delete('user_id', $_POST['user_id']);
                $this->model('queues')->delete('user_id', $_POST['user_id']);
                exit;
                break;
        }
    }

    private function getMessages($user, $campaign)
    {
        $tmp = $this->model('messages')->getByFields(['user_id' => $user['id'], 'campaign_id' => $campaign['id']], true, 'push_date DESC', 100);
        $outcoming = $this->model('queues')->getByFields(array('user_id' => $user['id'], 'sent' => 1,  'campaign_id' => $campaign['id']), true, 'send_time DESC', 6);
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