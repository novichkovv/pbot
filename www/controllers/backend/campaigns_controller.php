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
            $campaign = [];
            if($_GET['id']) {
                $campaign['id'] = $_GET['id'];
            } else {
                $campaign['create_date'] = date('Y-m-d H:i:s');
                $campaign['system_user_id'] = registry::get('user')['id'];
            }
            $campaign['campaign_name'] = $_POST['campaign_name'];
//            $campaign['phone'] = '';
            $campaign['id'] = $this->model('campaigns')->insert($campaign);
            $row = [];
            $row['campaign_id'] = $campaign['id'];
            $this->model('virtual_numbers')->delete('campaign_id', $campaign['id']);
            if($_POST['phones']) {
                foreach ($_POST['phones'] as $phone) {
                    if(!$phone) {
                        continue;
                    }
                    if ($id = $this->model('virtual_numbers')->getByField('phone', $phone)) {
                        $row['id'] = $id['id'];
                    } else {
                        $row['create_date'] = date('Y-m-d H:i:s');
                    }
                    $row['phone'] = $phone;
                    $this->model('virtual_numbers')->insert($row);
                }
            }

            header("Location: " . SITE_DIR . "campaigns/");
            exit;
        }
        if($_GET['id']) {
            $this->render('campaign', $this->model('campaigns')->getById($_GET['id']));
            $this->render('phones', $this->model('virtual_numbers')->getByField('campaign_id', $_GET['id'], true));
        }
        $this->view('campaigns' . DS . 'add');
    }
}