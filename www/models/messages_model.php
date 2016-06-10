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
}