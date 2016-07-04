<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 29.06.2016
 * Time: 18:46
 */
class mass_controller extends controller
{
    public function index()
    {
        $this->render('numbers', $this->model('virtual_numbers')->getAll());
        $this->view('mass' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "send_mass":
                $date = date('Y-m-d H:i:s');
                if(is_numeric($_POST['sms']['delay'])) {
                    $delay = $_POST['sms']['delay'];
                } else {
                    $delay = 1;
                }
                $send_time = time() + $delay;
                $to_arr = explode(',', $_POST['sms']['to']);
                $count_numbers = count($_POST['sms']['from']);
                $count_phones = count($to_arr);
                $offset = round($count_phones/$count_numbers);
//                $numbers = [];
//                $this->model('virtual_numbers')->getByFieldIn('phone', $_POST['sms']['from'], true);
//                foreach ( as $v) {
//                    $numbers[$v['phone']] = $v;
//                }
                $users = [];
                foreach ($this->model('users')->getByFieldIn('phone', $to_arr, true) as $v) {
                    $users[$v['phone']] = $v;
                }
                foreach ($to_arr as $v) {
                    if(!$users[$v]) {
                        $users[$v]['id'] = $this->model('users')->insert([
                            'phone' => $v,
                            'create_date' => $date,
                        ]);
                        $users[$v]['phone'] = $v;
                    }
                }
                $queues = [];
//                print_r($to);
//                exit;
                $from = $this->model('virtual_numbers')->getByField('phone', $_POST['sms']['from'][0]);
                $i = 1;
                foreach ($to_arr as $k => $to) {
                    if($offset*$i == $k && isset($_POST['sms']['from'][$i])) {
                        $from = $this->model('virtual_numbers')->getByField('phone', $_POST['sms']['from'][$i]);
                        $i ++;
                    }
                    $to = trim($to);
                    if(is_numeric($to)) {
                        $user = $users[$to];
                        $queue = [];
                        $queue['recipient'] = $from['phone'];
                        $queue['phone'] = $user['phone'];
                        $queue['user_id'] = $user['id'];
                        $queue['campaign_id'] = $from['campaign_id'];
                        $queue['send_time'] = date('Y-m-d H:i:s', $send_time + $k*2);
                        $queue['sms'] = trim($_POST['sms']['sms']);
                        $queue['global_plot'] = 1;
                        $queue['create_date'] = $date;
                        $queues[] = $queue;
                    }
                }
//                print_r($queues);
//                exit;
//                foreach ($numbers as $from) {
//
//                }
                if($this->model('queues')->insertRows($queues)) {
                    echo json_encode(array('status' => 1));
                } else {
                    echo json_encode(array('status' => 2));
                }
                exit;
                break;
        }
    }
}