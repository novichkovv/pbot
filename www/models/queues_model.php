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
        $stm = $this->pdo->prepare('
            SELECT
                user_id,
                campaign_id
            FROM
                queues
            WHERE
                create_date > NOW() - INTERVAL 1 DAY
                    AND sent = 1
            GROUP BY user_id
        ');
        $res = [];
        foreach ($this->get_all($stm) as $v) {
            $res[$v['campaign_id']][] = $v['user_id'];
        }
        return $res;
    }

    public function getToKeepAlive($delay, $campaign_id, $today_users)
    {
        $res = [];
        if(!$today_users) {
            return false;
        }
        foreach ($today_users as $user_id) {
            $stm = $this->pdo->prepare('
            SELECT
                *
            FROM
                queues
            WHERE
                user_id = "' . $user_id . '"
                        AND send_time < NOW() - INTERVAL "' . $delay . '"  AND campaign_id = :campaign_id SECOND
            ORDER BY send_time DESC
            LIMIT 1
            ');
            $res[$user_id] = $this->get_row($stm, ['campaign_id' => $campaign_id])  ;
        }

//        $stm = $this->pdo->prepare('
//            SELECT
//                *
//            FROM
//                queues q
//            WHERE
//                sent = 1
//                  AND campaign_id = :campaign_id
//                    AND send_time < NOW() - INTERVAL :delay SECOND
//                    AND q.send_time > (SELECT
//                        send_time
//                    FROM
//                        queues q1
//                    WHERE q1.user_id = q.user_id
//                    AND campaign_id = :campaign_id
//                    ORDER BY send_time DESC
//                    LIMIT 1 , 1)
//        ');
//        $res = [];
//        $tmp = $this->get_all($stm, ['delay' => $delay, 'campaign_id' => $campaign_id]);
//        foreach ($tmp as $v) {
//            $res[$v['user_id']] = $v;
//        }

        return $res;
    }

    public function getForGlobals($campaign_id, $today_users)
    {
        if(!$today_users) {
            return false;
        }
        $res = [];
        foreach ($today_users as $user_id) {
            $stm = $this->pdo->prepare('
                SELECT
                    *
                FROM
                    queues q
                WHERE
                    sent = 1
                        AND campaign_id = :campaign_id
                        AND send_time < NOW() - INTERVAL ' . GLOBAL_DELAY . ' SECOND
                        AND q.global_plot = 0
                        AND user_id = :user_id
                ORDER BY
                    send_time DESC
                LIMIT 1
            ');
            $res[$user_id] = $this->get_row($stm, ['campaign_id' => $campaign_id, 'user_id' => $user_id]);
        }
        return $res;
    }
}