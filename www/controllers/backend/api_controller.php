<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 08.06.2016
 * Time: 2:19
 */
class api_controller extends controller
{
    public function index()
    {
        $request = array_merge($_GET, $_POST);
        if (!isset($request['messageId']) OR !isset($request['status'])) {
            $this->write_log("INCOMING", 'This is not a delivery receipt');
            return;
        }

    }

    public function index_na()
    {
        $this->index();
    }
}