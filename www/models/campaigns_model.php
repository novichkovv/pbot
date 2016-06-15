<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 14.06.2016
 * Time: 19:52
 */
class campaigns_model extends model
{
    public function activateCampaign($campaign_id)
    {
        if(!$this->model('campaigns')->getById($campaign_id)) {
            return;
        }
        $stm = $this->pdo->prepare('
            UPDATE campaigns SET active = 0
        ');
        $stm->execute();
        $row = [];
        $row['id'] = $campaign_id;
        $row['active'] = 1;
        $this->model('campaigns')->insert($row);
    }

}