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
            MAX(send_time) send_time, user_id
        FROM
            queues
        GROUP BY user_id HAVING  MAX(send_time) > NOW() - INTERVAL 9 DAY
        ');
        return $this->get_all($stm);
    }

    public function getFollowUpUsers()
    {
        $stm = $this->pdo->prepare('
        SELECT
            MAX(send_time) send_time, user_id
        FROM
            queues
        GROUP BY user_id HAVING  DATE(MAX(send_time)) = NOW() - INTERVAL 7 DAY
        ');
        $today_users =  $this->get_all($stm);
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


    public function getToKeepAlive($campaign_id, $today_users)
    {

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

    public function cleanOldQueues()
    {
        $field_names = [];
        foreach ($this->get_all($stm = $this->pdo->prepare('
            show columns from queues
        ')) as $fields) {
            if($fields['Field'] == 'id') {
                continue;
            }
            $field_names[] = '`' . $fields['Field'] . '`';
        }

        $stm = $this->pdo->prepare('
            SELECT ' . implode(',', $field_names) . ' FROM queues WHERE create_date < NOW() - INTERVAL 8 DAY
        ');
        $values = [];
        $all = $this->get_all($stm);
        if(!$all) {
            return;
        }
        foreach ($all as $message) {
            $vals = [];
            foreach ($message as $k => $v) {
                $vals[] = '"' . addslashes($v) . '"';
            }

            $values[] = '(' . implode(',', $vals) . ')';
        }
        $query = '
        INSERT INTO old_queues (' . implode(',', $field_names) . ') VALUES ' . implode(',', $values) . '
        ';
        $this->pdo->prepare($query)->execute();
        $stm = $this->pdo->prepare('
            DELETE FROM queues WHERE create_date < NOW() - INTERVAL 8 DAY
        ');
        $stm->execute();

    }

    public function getCountUserReplies()
    {
        $stm = $this->pdo->prepare('
            SELECT
                COUNT(id) qty, DATE(send_time) date, user_id
            FROM
                queues
            WHERE
                send_time < NOW()
                    AND send_time > NOW() - INTERVAL 8 DAY
            GROUP BY user_id
        ');
        $res = [];
        foreach ($this->get_all($stm) as $v) {
            $res[$v['date']][] = $v['qty'];
        }
        foreach ($res as $k => $v) {
            $res[$k] = array_sum($v)/count($v);
        }
        return $res;
    }

    public function getCountQueuesByCampaign()
    {
        $stm = $this->pdo->prepare('
            SELECT 
                COUNT(q.id) count, c.campaign_name
            FROM
                queues q
                    JOIN
                campaigns c ON c.id = q.campaign_id
            GROUP BY campaign_id
        ');
        return $this->get_all($stm);
    }
}