<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 08.06.2016
 * Time: 2:44
 */
class system_users_controller extends controller
{
    public function index()
    {
        if(isset($_POST['delete_user_btn'])) {
            $this->model('system_users')->deleteById($_POST['user_id']);
            header('Location: ' . SITE_DIR . 'system_users/');
        }
        $this->render('settings', registry::get('system_settings'));
        $this->render('users', $this->model('system_users')->getAll());
        $this->view('system_users' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "save_settings":
                $settings = registry::get('system_settings');
                foreach ($_POST['settings'] as $key => $value) {
                    $setting = $this->model('system_settings')->getByField('setting_key', $key);
                    $setting['setting_key'] = $key;
                    $setting['setting_value'] = $value;
                    $this->model('system_settings')->insert($setting);
                    $settings[$key] = $value;
                }
                registry::remove('system_settings');
                registry::set('system_settings', $settings);
                exit;
                break;
        }
    }

    public function add()
    {

        if(isset($_POST['save_user_btn'])) {
            $row = [];
            if($_GET['id']) {
                $row['id'] = $_GET['id'];
            } else {
                $row['create_date'] = date('Y-m-d H:i:s');
            }
            $row['user_name'] = $_POST['user_name'];
            if($_POST['user_password']) {
                $row['user_password'] = md5($_POST['user_password']);
            }
            if($this->model('system_users')->getByField('user_name', $row['user_name'])) {
                $this->render('user_name_error', 'User with this name already exists');
                $this->render('password', $_POST['user_password']);
            } else {
                $this->model('system_users')->insert($row);
                header("Location: " . SITE_DIR . "system_users/");
                exit;
            }
        }
        if($_GET['id']) {
            $this->render('user', $this->model('system_users')->getById($_GET['id']));
        }
        $this->view('system_users' . DS . 'add');
    }
}