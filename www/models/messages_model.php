<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 09.06.2016
 * Time: 23:08
 */
class messages_model extends model
{
    public function getUnclosedMessages()
    {
        $stm = $this->pdo->prepare('
            SELECT
                m.*,
                u.phone
            FROM
                messages m
                    JOIN
                users u ON u.id = m.user_id
            WHERE
                m.create_date > NOW() - INTERVAL 3 DAY
                    AND
                message_status IN (0,4)
        ');
        return $this->get_all($stm);
    }

    public function markOtherMessages($user_id, $campaign_id, $recipient)
    {
        $stm = $this->pdo->prepare('
            UPDATE messages SET message_status = 3 WHERE user_id = :user_id AND message_status = 0 AND IF(concat IS NOT NULL, concat_count = concat_total, 1) AND campaign_id = :campaign_id AND recipient = :recipient
        ');
        $stm->execute(['user_id' => $user_id, 'campaign_id' => $campaign_id, 'recipient' => $recipient]);
    }

    public function getLatestMessage()
    {
        $stm = $this->pdo->prepare('
            SELECT
                m.*, u.phone, c.campaign_name
            FROM
                messages m
                    JOIN
                users u ON u.id = m.user_id
                    JOIN
                campaigns c ON c.id = m.campaign_id
            WHERE
                IF(concat IS NOT NULL,
                    concat_count = concat_total,
                    1)
            ORDER BY push_date DESC
            LIMIT 1
        ');
        return $this->get_row($stm);
    }

    public function getNumberUsers($number)
    {
        $stm = $this->pdo->prepare('
            SELECT
                u.*
            FROM
                users u
                    JOIN
                messages m ON m.user_id = u.id
            WHERE
                recipient = :number
            GROUP BY user_id;
        ');
        $stm->getQuery(['number' => $number]);
        return $this->get_all($stm, array('number' => $number));
    }
}