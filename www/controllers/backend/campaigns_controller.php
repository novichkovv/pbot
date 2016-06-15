<?php
/**
 * Created by PhpStorm.
 * campaign: asus1
 * Date: 08.06.2016
 * Time: 2:44
 */
class campaigns_controller extends controller
{
    public function index()
    {
        if(isset($_POST['delete_campaign_btn'])) {
            $this->model('campaigns')->deleteById($_POST['campaign_id']);
            header('Location: ' . SITE_DIR . 'campaigns/');
            exit;
        }
//        if(isset($_POST['activate_campaign_btn'])) {
//            $this->model('campaigns')->activateCampaign($_POST['campaign_id']);
//            header('Location: ' . SITE_DIR . 'campaigns/');
//            exit;
//        }
        $this->render('campaigns', $this->model('campaigns')->getAll());
        $this->view('campaigns' . DS . 'index');
    }

    public function add()
    {
        if(isset($_POST['save_campaign_btn'])) {
            $row = [];
            if($_GET['id']) {
                $row['id'] = $_GET['id'];
            } else {
                $row['create_date'] = date('Y-m-d H:i:s');
                $row['system_user_id'] = registry::get('user')['id'];
            }
            $row['campaign_name'] = $_POST['campaign_name'];
            $row['phone'] = $_POST['phone'];
            $this->model('campaigns')->insert($row);
            header("Location: " . SITE_DIR . "campaigns/");
            exit;
        }
        if($_GET['id']) {
            $this->render('campaign', $this->model('campaigns')->getById($_GET['id']));
        }
        $this->view('campaigns' . DS . 'add');
    }
}