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
        if (!isset($request['to']) OR !isset($request['msisdn']) OR !isset($request['text'])) {
            $this->writeLog("INCOMING", 'This is not a delivery receipt');
            exit;
        }
        $row = [];
        if(!$user = $this->model('users')->getByField('phone', $request['msisdn'])) {
            $user['phone'] = $request['msisdn'];
            $user['create_date'] = date('Y-m-d H:i:s');
            $user['id'] = $this->model('users')->insert($user);
        } elseif(registry::get('system_settings')['switch_days']) {
            $first_message = $this->model('messages')->getByFields(['recipient' => $request['to'], 'user_id' => $user['id']], false, 'push_date', 1);
            if($first_message && time() - registry::get('system_settings')['switch_days']*24*3600 > strtotime($first_message['push_date'])) {
                $campaign = $this->model('virtual_numbers')->getByField('phone', $request['to'])['campaign_id'];
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
                    $rows = [];
                    $date = date('Y-m-d H:i:s');
                    foreach ($this->model('phrases')->getUserPhrasesByStatus($user['id'], $request['to']) as $phrase) {
                        foreach ($this->model('phrases')->getByFields(['status_id' => $phrase['status_id'], 'campaign_id' => $new_campaign['id']], true, 'sort_order, id', $phrase['count']) as $v) {
                            $rows[] = [
                                'phrase_id' => $v['id'],
                                'virtual_number' => $new_number,
                                'create_date' => $date,
                                'user_id' => $user['id']
                            ];
                        }
                    }
                    if($rows) {
                        $this->model('user_phrases')->insertRows($rows);
                    }
                    $request['to'] = $new_number;
                } else {
                    echo 'no numbers';
                }

            }
            if($this->model('blacklist')->getByFields(['user_id' => $user['id'], 'phone' => $request['to']])['id']) {
                return;
            }
            if($this->model('messages')->checkSpam($user['id'], $request['to'])) {
                if(!in_array($user['phone'], [111,222,333,444,555,666,777,888,999])) {
                    $this->model('blacklist')->insert([
                        'user_id' => $user['id'],
                        'phone' => $request['to']
                    ]);
                    return;
                }
            }
        }
        $id = $this->model('virtual_numbers')->getByField('phone', $request['to'])['campaign_id'];
        if(!$id) {
            $id = 1;
        }
        $active_campaign = $this->model('campaigns')->getById($id);
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
        $row['campaign_id'] = $active_campaign['id'];
        $row['push_date'] = date('Y-m-d H:i:s', strtotime($request['message-timestamp']));
        $row['create_date'] = date('Y-m-d H:i:s');
        $this->model('messages')->markOtherMessages($user['id'], $active_campaign['id'], $user['phone']);
        $this->model('messages')->insert($row);
        exit;
    }

    public function index_na()
    {
        $this->index();
    }
}