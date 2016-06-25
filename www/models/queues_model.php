<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 10.06.2016
 * Time: 16:18
 */
class queues_model extends model
{
    public function getMessagesToSend()
    {
        $stm = $this->pdo->prepare('
            SELECT
                *
            FROM
                queues
            WHERE
                sent = 0
                    AND
                NOW() >= send_time
        ');
        return $this->get_all($stm);
    }

    public function getLastUserMessages($user_id)
    {
        $stm = $this->pdo->prepare('
            SELECT * FROM queues WHERE user_id = :user_id AND NOW() - INTERVAL 1 DAY < send_time
        ');
        return $this->get_all($stm, array('user_id' => $user_id));
    }

    public function getTodayUsers()
    {
//        $stm = $this->pdo->prepare('
//            SELECT
//                user_id,
//                campaign_id
//            FROM
//                queues
//            WHERE
//                create_date > NOW() - INTERVAL 1 DAY
//                    AND sent = 1
//            GROUP BY user_id
//        ');
        $stm = $this->pdo->prepare('
        SELECT
            MAX(send_time) send_time, user_id
        FROM
            queues
        GROUP BY user_id HAVING  MAX(send_time) > NOW() - INTERVAL 1 DAY
        ');
//        $res = [];
//        foreach ($this->get_all($stm) as $v) {
//            $res[$v['campaign_id']][] = $v['user_id'];
//        }
        return $this->get_all($stm);
    }

    public function getToKeepAlive($campaign_id, $today_users)
    {

//        if(!$today_users) {
//            return [];
//        }
//        $in = [];
//        foreach ($today_users as $v) {
//            $v['send_time'] = '"' . $v['send_time'] . '"';
//            $in[] = '(' .implode(',', $v) . ')';
//        }
//        $stm = $this->pdo->prepare('
//            SELECT
//                *
//            FROM
//                queues
//            WHERE
//                user_id  IN (send_time, user_id) IN (' . implode(',', $in) . ')
//            ');
//        return $this->get_all($stm, ['campaign_id' => $campaign_id])  ;
    }

    public function getForGlobals($today_users)
    {
        if(!$today_users) {
            return [];
        }
        $in = [];
        foreach ($today_users as $v) {
            $v['send_time'] = '"' . $v['send_time'] . '"';
            $in[] = '(' .implode(',', $v) . ')';
        }
        $stm = $this->pdo->prepare('
            SELECT
                *
            FROM queues
                WHERE (send_time, user_id) IN (' . implode(',', $in) . ')
        ');
        $res = $this->get_all($stm);

        return $res;
    }
}