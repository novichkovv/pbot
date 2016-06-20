<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 01.06.2016
 * Time: 21:49
 */ 
class phrases_model extends model
{
    public function getPhrases($campaign_id)
    {
        $stm = $this->pdo->prepare('
            SELECT
                p.*,
                s.status_name
            FROM
                phrases p
                    JOIN
                statuses s ON s.id = p.status_id
            WHERE
                campaign_id = :campaign_id
            ORDER BY
                p.status_id, sort_order
        ');
        return $this->get_all($stm, ['campaign_id' => $campaign_id]);
    }

    public function deletePhrases($ids)
    {
        $stm = $this->pdo->prepare('
            DELETE FROM phrases WHERE id IN (' . $ids . ')
        ');
        return $stm->execute();
    }

    public function getLastUserPhrases($user_id, $campaign_id, $virtual_number)
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
                p.campaign_id = :campaign_id
                    AND
                up.virtual_number = :virtual_number
                    AND
                NOW() - INTERVAL 3 DAY < up.create_date
        ');
        $tmp = $this->get_all($stm, array('user_id' => $user_id, 'campaign_id' => $campaign_id, 'virtual_number' => $virtual_number));
        $res = [];
        foreach ($tmp as $v) {
            $res[$v['status_id']][$v['id']] = $v;
        }
        return $res;
    }

    public function getPhrasesWithStatusIn(array $ids, $campaign_id)
    {
        $stm = $this->pdo->prepare('
            SELECT * FROM phrases WHERE status_id IN (' . implode(',', $ids) . ') AND campaign_id = :campaign_id
        ');
        return $this->get_all($stm, array('campaign_id' => $campaign_id));
    }
}