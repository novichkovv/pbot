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

    public function getToKeepAlive($delay, $campaign_id)
    {
        $stm = $this->pdo->prepare('
            SELECT
                *
            FROM
                queues q
            WHERE
                sent = 1
                  AND campaign_id = :campaign_id
                    AND send_time < NOW() - INTERVAL :delay SECOND
                    AND q.send_time > (SELECT
                        send_time
                    FROM
                        queues q1
                    WHERE q1.user_id = q.user_id
                    AND campaign_id = :campaign_id
                    ORDER BY send_time DESC
                    LIMIT 1 , 1)
        ');
        $res = [];
        $tmp = $this->get_all($stm, ['delay' => $delay, 'campaign_id' => $campaign_id]);
        foreach ($tmp as $v) {
            $res[$v['user_id']] = $v;
        }

        return $res;
    }

    public function getForGlobals($campaign_id)
    {
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
                    AND q.send_time > (SELECT
                        send_time
                    FROM
                        queues q1
                    WHERE
                        q1.user_id = q.user_id AND campaign_id = :campaign_id
                    ORDER BY send_time DESC
                    LIMIT 1 , 1)
        ');
        return $this->get_all($stm, ['campaign_id' => $campaign_id]);
    }
}