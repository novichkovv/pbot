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
                p.id, sort_order
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
}