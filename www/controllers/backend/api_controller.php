<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 08.06.2016
 * Time: 2:19
 */
class api_controller extends controller
{
    public function index()
    {
        require_once(ROOT_DIR . 'cron.php');
        $request = array_merge($_GET, $_POST);
        $this->writeLog('test', $request);
        if (!isset($request['to']) OR !isset($request['msisdn']) OR !isset($request['text'])) {
            $this->writeLog("INCOMING", 'This is not a delivery receipt');
            exit;
        }
        //print_r($request);
        $row = [];
        if(!$user = $this->model('users')->getByField('phone', $request['msisdn'])) {
            $user['phone'] = $request['msisdn'];
            $user['create_date'] = date('Y-m-d H:i:s');
            $user['id'] = $this->model('users')->insert($user);
        }
        //id, message_status, user_id, message_id, recipient, message_type, content, udh, concat, concat_count, concat_total, push_date, create_date, id, id
        $row['user_id'] = $user['id'];
        $row['message_id'] = $request['messageId'];
        $row['recipient'] = $request['to'];
        switch($request['type']) {
            case "text":
                $row['message_type'] = 1;
                $row['content'] = $request['text'];
                break;
            case "binary":
                $row['message_type'] = 2;
                $row['content'] = $request['data'];
                break;
            case "unicode":
                $row['message_type'] = 3;
                $row['content'] = $request['data'];
                break;
        }
        $row['udh'] = $request['udh'];
        if($request['concat']) {
            $row['concat'] = $request['concat-ref'];
            $row['concat_count'] = $request['concat-part'];
            $row['concat_total'] = $request['concat-total'];
        }
        $row['push_date'] = date('Y-m-d H:i:s', strtotime($request['message-timestamp']));
        $row['create_date'] = date('Y-m-d H:i:s');
        $this->model('messages')->markOtherMessages($user['id']);
        $this->model('messages')->insert($row);
        exit;
    }

    public function index_na()
    {
        $this->index();
    }
}