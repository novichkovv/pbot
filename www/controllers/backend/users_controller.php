<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 16.06.2016
 * Time: 20:02
 */
class users_controller extends controller
{
    public function index()
    {
        $this->view('users' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "users_table":
                $params = $this->usersTableParams();
                echo json_encode($this->getDataTable($params));
                exit;
                break;
        }
    }

    private function usersTableParams()
    {
        $params = [];
        $params['table'] = 'users u';
        $params['select'] = [
            'u.phone',
            'u.create_date',
            'COUNT(m.id)',
            'MAX(push_date)'
        ];
        $params['join']['messages'] = [
            'on' => 'm.user_id = u.id AND IF(m.concat, m.concat_count = 1, 1)',
            'as' => 'm'
        ];
        $params['group'] = 'user_id';
        $params['order'] = 'u.id DESC';
        return $params;
    }
}