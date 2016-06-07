<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 01.06.2016
 * Time: 18:25
 */
class upload_controller extends controller
{
    public function index()
    {
        if(isset($_POST['submit'])) {
            if(array_pop(explode('.', $_FILES['file']['name'])) != 'xlsx') {
                $this->render('error', 'Wrong file format');
            } elseif(!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", trim($_POST['date']))) {
                $this->render('error', 'Wrong date format');
            } else {
                if($xsl = tools_class::readXLS($_FILES['file']['tmp_name'])) {
                    $brand = '';
                    $model = '';
                    foreach ($xsl[0] as $k => $v) {
                        $row = [];
                        if($k < 3) {
                            continue;
                        }
                        if($v[0]) {
                            $brand = $v[0];
                        }
                        if($v[1]) {
                            $model = $v[1];
                        }
                        $row['brand'] = $brand;
                        $row['model'] = $model;
                        $row['production_year'] = $v[2];
                        $row['upload_date'] = $_POST['date'];
                        if($id = $this->model('prices')->getByFields($row)) {
                            $row['id'] = $id;
                        }
                        $row['msrp'] = (int) str_replace(',', '', $v[4]);//number_format((int) str_replace(',', '', $v[4]), 0, '.', ',');
                        $row['sale_price'] = (int) str_replace(',', '', $v[3]);//number_format((int) str_replace(',', '', $v[3]), 0, '.', ',');
                        $row['savings'] = $row['msrp'] - $row['sale_price'];
                        $row['savings_pc'] = $row['savings']/$row['msrp']*100;
                        $this->model('prices')->insert($row);
                        header('Location: ' . SITE_DIR . 'data/');
                    }
                }
            }
        }
        $this->render('breadcrumbs', array(
            array(
                'route' => SITE_DIR,
                'name' => 'Home'
            ),
            array(
                'name' => 'Upload'
            )
        ));
        $this->view('upload' . DS . 'index');
    }
}