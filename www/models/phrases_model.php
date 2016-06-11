<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 01.06.2016
 * Time: 21:49
 */ 
class phrases_model extends model
{
    public function getPhrases()
    {
        $stm = $this->pdo->prepare('
            SELECT
                p.*,
                s.status_name
            FROM
                phrases p
                    JOIN
                statuses s ON s.id = p.status_id
            ORDER BY
                p.status_id, sort_order
        ');
        return $this->get_all($stm);
    }

    public function deletePhrases($ids)
    {
        $stm = $this->pdo->prepare('
            DELETE FROM phrases WHERE id IN (' . $ids . ')
        ');
        return $stm->execute();
    }

    public function getLastUserPhrases($user_id)
    {
        $stm = $this->pdo->prepare('
            SELECT
                p.*,
                up.create_date use_date
            FROM
                user_phrases up
                    JOIN
                phrases p ON p.id = up.phrase_id
            WHERE
                user_id = :user_id
                    AND
                NOW() - INTERVAL 1 DAY < up.create_date
        ');
        $tmp = $this->get_all($stm, array('user_id' => $user_id));
        $res = [];
        foreach ($tmp as $v) {
            $res[$v['status_id']][$v['id']] = $v;
        }
        return $res;
    }
}