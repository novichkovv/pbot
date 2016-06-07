<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 01.06.2016
 * Time: 21:49
 */ 
class prices_model extends model
{
    public function getGroupedDates()
    {
        $stm = $this->pdo->prepare('
            SELECT
                upload_date
            FROM
                prices
            GROUP BY
                upload_date
            ORDER BY
                upload_date DESC
        ');
        return $this->get_all($stm);
    }
}