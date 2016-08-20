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
        $res = [];
        $stats = $this->model('messages')->getCountUserMessages();
        for($i = time() - 8*24*3600; $i <= time(); $i += 24*3600) {
            $date = date('Y-m-d', $i);
            if($stats[$date]) {
                $res[] = '"' . date('Y,m,d', strtotime($date)) . '" : "' . $stats[$date] . '"';
            } else {
                $res[] = '"' . date('Y,m,d', strtotime($date)) . '" : "0"';
            }
        }
        $graph[] = '{' . implode(',', $res) . '}';
        $res = [];
        $stats = $this->model('queues')->getCountUserReplies();
        for($i = time() - 8*24*3600; $i <= time(); $i += 24*3600) {
            $date = date('Y-m-d', $i);
            if($stats[$date]) {
                $res[] = '"' . date('Y,m,d', strtotime($date)) . '" : "' . $stats[$date] . '"';
            } else {
                $res[] = '"' . date('Y,m,d', strtotime($date)) . '" : "0"';
            }
        }
        $graph[] = '{' . implode(',', $res) . '}';
        $this->render('graph', $graph);
        $this->render('messages_by_campaign', $this->model('messages')->getCountMessagesByCampaign());
        $this->render('queues_by_campaign', $this->model('queues')->getCountQueuesByCampaign());
        $this->render('campaigns', $this->model('campaigns')->getAll());
        if(isset($_POST['download_btn'])) {
            $params = $this->usersTableParams($_POST['download']);
            if(is_array($_POST['params'])) {
                foreach($_POST['params'] as $k=>$v)
                {
                    $params['where'][$k] = array(
                        'sign' => $v['sign'],
                        'value' => $v['value'],
                    );
                    if($v['sign'] == 'IN') {
                        $params['where'][$k]['noquotes'] = true;
                    }
                }
            }
            $params['limits'] = isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'].','.$_REQUEST['iDisplayLength'] : '';
            $params['order'] = $_REQUEST['iSortCol_0'] ? $params['select'][$_REQUEST['iSortCol_0']] . ($_REQUEST['sSortDir_0'] ? ' ' . $_REQUEST['sSortDir_0'] : $params['order']) : $params['order'];
            $xls = $this->createReport($params);
            header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
            header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
            header ( "Cache-Control: no-cache, must-revalidate" );
            header ( "Pragma: no-cache" );
            header ( "Content-type: application/vnd.ms-excel; charset=utf-8" );
            header ( "Content-Disposition: attachment; filename=users.xls" );
            $objWriter = new PHPExcel_Writer_Excel5($xls);
            $objWriter->save('php://output');
            exit;
        }
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

            case "whitelist":
                $this->model('users')->insert([
                    'id' => $_POST['id'],
                    'blocked' => 0
                ]);
                exit;
                break;

            case "blacklist":
                $this->model('users')->insert([
                    'id' => $_POST['id'],
                    'blocked' => 1
                ]);
                exit;
                break;

            case "user_switches":
                $params = [];
                $params['table'] = 'user_switches s';
                $params['select'] = [
                    'c.campaign_name',
                    's.recipient',
                    'DATE(s.switch_date)',
                    'CONCAT("<a href=\"' . SITE_DIR . 'emulator?user_id=", s.user_id, "&campaign_id=", s.campaign_id, "&number_id=", s.recipient, "\"><i class=\"fa fa-envelope\"></i> </a>")'
                ];
                $params['join']['campaigns'] = [
                    'on' => 'c.id = s.campaign_id',
                    'as' => 'c'
                ];
                $params['order'] = 's.switch_date desc';
                echo json_encode($this->getDataTable($params));
                exit;
                break;
        }
    }

    public function blacklist()
    {
        $this->render('users', $this->model('users')->getAll());
        $this->render('numbers', $this->model('virtual_numbers')->getAll());
        $this->view('users' . DS . 'blacklist');
    }

    public function blacklist_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_blacklist":
                $params = [];
                $params['table'] = 'blacklist b';
                $params['select'] = [
                    'u.phone',
                    'b.phone',
                    'CONCAT("<a href=\"#whitelist_modal\" data-toggle=\"modal\" class=\"btn btn-outline green whitelist\" data-id=\"", b.id, "\">Whitelist</a>")'
                ];
                $params['join']['users'] = [
                    'as' => 'u',
                    'on' => 'u.id = b.user_id'
                ];
                echo json_encode($this->getDataTable($params));
                exit;
                break;

            case "whitelist":
                $this->model('blacklist')->deleteById($_POST['id']);
                exit;
                break;

            case "blacklist":
                $rows = [];
                if(!$user = $this->model('users')->getByField('phone', $_POST['user_number'])) {
                    $user = [];
                    $user['phone'] = $_POST['user_number'];
                    $user['create_date'] = date('Y-m-d H:i:s');
                    $user['id'] = $this->model('users')->insert($user);
                }
                foreach ($_POST['numbers'] as $number) {
                    $row = [];
                    $row['user_id'] = $user['id'];
                    $row['phone'] = $number;
                    $rows[] = $row;
                }
                if($rows) {
                    $this->model('blacklist')->insertRows($rows);
                }

                exit;

            case "search_user":
                echo json_encode($this->model('users')->findByField('phone', $_GET['q'], array('phone id', 'phone text')));
                exit;
                break;

            case "search_number":
                echo json_encode($this->model('virtual_numbers')->findByField('phone', $_GET['q'], array('phone id', 'phone text')));
                exit;
                break;
        }
    }

    private function usersTableParams()
    {
        $params = [];
        $params['table'] = 'users u';
        $params['select'] = [
            'u.phone repUser_Phone',
            'u.create_date repCreate_Date',
            'COUNT(m.id) repMessages_Sent',
            'MAX(push_date) - INTERVAL 8 HOUR repLast_Message'
        ];
        $params['join']['messages'] = [
            'on' => 'm.user_id = u.id AND IF(m.concat, m.concat_count = 1, 1)',
            'as' => 'm'
        ];
        $params['group'] = 'user_id';
        $params['order'] = 'u.id DESC';
        return $params;
    }

    private function createReport($params)
    {
        $line_arr = [];
        $th = [];
        foreach ($this->model('default')->getFromParams($params) as $k => $row) {
            if($k == 0) {
                foreach ($row as $key => $val) {
                    if(strpos($key, 'rep') !== 0) {
                        continue;
                    }
                    $th[] = strtr($key, array(
                        '_' => ' ',
                        'rep' => ''
                    ));
                }
            }
            foreach ($row as $key => $val) {
                if(strpos($key, 'rep') !== 0) {
                    continue;
                }
                $line_arr[$k][] = $val; //utf8_encode($decoded = utf8_decode($val)) === $val ? $decoded : iconv("utf8", "cp1251", $val);
            }
        }
        array_unshift($line_arr, $th);
        $xls = $this->tools()->excel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        foreach ($line_arr as $row_index => $row) {
            $letter = 'A';
            $number = $row_index + 1;
            foreach ($row as $val) {
                if(is_numeric($val)) {
                    $val = (string) $val;
                }
                $sheet->setCellValue($letter . $number, $val);
                $letter ++;
            }
        }
        return $xls;
    }
}