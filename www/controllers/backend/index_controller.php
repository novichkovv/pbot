<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 29.08.2015
 * Time: 0:10
 */
class index_controller extends controller
{
    public function index()
    {
        if(isset($_POST['log_out'])) {
            $this->logOut();
            header('Location: ' . SITE_DIR);
            exit;
        }
        if(isset($_POST['delete_phrase_btn'])) {
            $this->model('phrases')->deletePhrases($_POST['phrases_to_delete']);
            header('Location: ' . SITE_DIR);
        }
        $this->render('breadcrumbs', array(
            array('name' => 'Dashboard')
        ));

        if(isset($_GET['campaign_id'])) {
            $_SESSION['campaign'] = $_GET['campaign_id'];
            header('Location: ' . SITE_DIR);
        }

        if(isset($_POST['clone_btn'])) {
            $rows = [];
            foreach ($this->model('phrases')->getByField('campaign_id', $_POST['clone_campaign_id'], true) as $phrase) {
                unset($phrase['id']);
                $phrase['create_date'] = date('Y-m-d H:i:s');
                $phrase['campaign_id'] = $_SESSION['campaign'];
                $rows[] = $phrase;
            }
            $this->model('phrases')->insertRows($rows);
            header('Location: ' . SITE_DIR);
        }

        $campaigns = $this->model('campaigns')->getByField('system_user_id', registry::get('user')['id'], true);
        if(isset($_SESSION['campaign'])) {
            $this->render('phrases', $this->model('phrases')->getPhrases($_SESSION['campaign']));
        } elseif($campaigns) {
            $this->render('phrases', $this->model('phrases')->getPhrases($campaigns[0]['id']));
            $_SESSION['campaign'] = $campaigns[0]['id'];
        } else {
            $this->render('no_campaigns', true);
        }
        $this->render('campaign_id', $_SESSION['campaign']);
        $this->render('campaigns', $campaigns);
        $this->render('statuses', $this->model('statuses')->getAll());
        $this->view('index' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "save_phrase":
                $row = $_POST['phrase'];
                if (!$row['id']) {
                    $row['create_date'] = date('Y-m-d H:i:s');
                }
                $row['id'] = $this->model('phrases')->insert($row);
                $row['status_name'] = $this->model('statuses')->getById($row['status_id'])['status_name'];
                $this->render('phrase', $row);
                $template = $this->fetch('index' . DS . 'ajax' . DS . 'phrase');
                $res = array('status' => 1, 'template' => $template);
                if($_POST['phrase']['id']) {
                    $res['edited'] = $_POST['phrase']['id'];
                }
                echo json_encode($res);
                exit;
                break;

            case "clone_phrase":
                $phrase = $this->model('phrases')->getById($_POST['id']);
                unset($phrase['id']);
                $phrase['create_date'] = date('Y-m-d H:i:s');
                $phrase['id'] = $this->model('phrases')->insert($phrase);
                $phrase['status_name'] = $this->model('statuses')->getById($phrase['status_id'])['status_name'];
                $this->render('phrase', $phrase);
                $template = $this->fetch('index' . DS . 'ajax' . DS . 'phrase');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;

            case "edit_phrase":
                $phrase = $this->model('phrases')->getById($_POST['id']);
                $this->render('phrase', $phrase);
                $this->render('statuses', $this->model('statuses')->getAll());
                $template = $this->fetch('index' . DS . 'ajax' . DS . 'phrase_form');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;

//            case "remove_phrase":
//                foreach ($phra as $) {
//
//                }
//
//                exit;
//                break;
        }
    }

    public function index_na()
    {
        $this->addStyle('backend/theme/login_form');
        $this->view_only('common' . DS . 'system_header');
        $this->view_only('index' . DS . 'login_form');
        $this->view_only('common' . DS . 'system_footer');
    }
}