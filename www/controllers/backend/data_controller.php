<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 01.06.2016
 * Time: 20:26
 */
class data_controller extends controller
{
    public function index()
    {
        if(isset($_POST['download'])) {

            $params = $this->getQueryParams();
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
            $row = $this->model('default')->getFromParams($params);
            $csv = 'Year;Make;Model;MSRP;Sale Price;Savings off MSRP;% Savings;Upload Date' ."\n";
            foreach ($row as $k => $v) {
                $line_arr = [];
                $line_arr[] = '"' . $v['production_year'] . '"';
                $line_arr[] = '"' . $v['brand'] . '"';
                $line_arr[] = '"' . $v['model'] . '"';
                $line_arr[] = '"' . $v['CONCAT("$",msrp)'] . '"';
                $line_arr[] = '"' . $v['CONCAT("$",sale_price)'] . '"';
                $line_arr[] = '"' . $v['CONCAT("$",savings)'] . '"';
                $line_arr[] = '"' . $v['CONCAT(savings_pc, "%")'] . '"';
                $line_arr[] = '"' . $v['upload_date'] . '"';
                $csv .= implode(';', $line_arr) . "\n";
            }

            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header("Content-Disposition: attachment;filename=export.csv");
            header("Content-Transfer-Encoding: binary");
            echo $csv;
            exit;
        }
        $this->render('breadcrumbs', array(
            array(
                'route' => SITE_DIR,
                'name' => 'Home'
            ),
            array(
                'name' => 'Data'
            )
        ));
        $this->render('dates', $this->model('prices')->getGroupedDates());
        $this->view('data' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_prices":
                echo json_encode($this->getDataTable($this->getQueryParams(), false, true));
                exit;
                break;
        }
    }

    private function getQueryParams()
    {
        $params = [];
        $params['select'] = array(
            'production_year',
            'brand',
            'model',
            'CONCAT("$",msrp)',
            'CONCAT("$",sale_price)',
            'CONCAT("$",savings)',
            'CONCAT(savings_pc, "%")',
            'upload_date'
        );
        $params['order'] = 'upload_date DESC';
        $params['table'] = 'prices';
        return $params;
    }
}