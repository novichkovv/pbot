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
        $this->render('breadcrumbs', array(
            array('name' => 'Dashboard')
        ));
        $this->view('index' . DS . 'index');
    }

    public function index_na()
    {
        $this->addStyle('backend/theme/login_form');
        $this->view_only('common' . DS . 'system_header');
        $this->view_only('index' . DS . 'login_form');
        $this->view_only('common' . DS . 'system_footer');
    }
}