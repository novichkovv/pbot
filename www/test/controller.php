<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 31.05.2016
 * Time: 21:12
 */
class controller
{
    public function index()
    {
        if($_FILES) {
//            print_r($_FILES);
            $csv = 'Year;Make;Model;MSRP;Sale Price;Savings off MSRP;% Savings' ."\n";
            if($xsl = $this->readXLS($_FILES['file']['tmp_name'])) {
                $brand = '';
                $model = '';
                foreach ($xsl[0] as $k => $row) {
                    if($k < 3) {
                        continue;
                    }
                    if($row[0]) {
                        $brand = $row[0];
                    }
                    if($row[1]) {
                        $model = $row[1];
                    }
                    $msrp = number_format((int) str_replace(',', '', $row[4]), 0, '.', ',');
                    $sale_price = number_format((int) str_replace(',', '', $row[3]), 0, '.', ',');
                    $savings = number_format((int) str_replace(',', '', $row[5]), 0, '.', ',');
                    $msrp_nf = str_replace(',', '', $row[4]);
                    $savings_nf = str_replace(',', '', $row[5]);
                    $csv .= '"' . $row[2] . '";"' . $brand . '";"' . $model . '";"$' . $msrp . '";"$' . $sale_price . '";"$' . $savings . '";"' . number_format((floor($savings_nf/$msrp_nf*10000)/100), 2) . "%\"\n";
                }
            }
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header("Content-Disposition: attachment;filename=export.csv");
            header("Content-Transfer-Encoding: binary");
            echo $csv;
            exit;
        }
        if(isset($_POST['submit'])) {
            if($_FILES) {
                $csv = 'Year;Make;Model;MSRP;Sale Price;Savings off MSRP;% Savings' ."\n";
                if($xsl = $this->readXLS($_FILES['file']['tmp_name'])) {
                    $brand = '';
                    $model = '';
                    foreach ($xsl[0] as $k => $row) {
                        if($k < 3) {
                            continue;
                        }
                        if($row[0]) {
                            $brand = $row[0];
                        }
                        if($row[1]) {
                            $model = $row[1];
                        }
                        $msrp = number_format((int) str_replace(',', '', $row[4]), 0, '.', ',');
                        $sale_price = number_format((int) str_replace(',', '', $row[3]), 0, '.', ',');
                        $savings = number_format((int) str_replace(',', '', $row[5]), 0, '.', ',');
                        $msrp_nf = str_replace(',', '', $row[4]);
                        $savings_nf = str_replace(',', '', $row[5]);
                        $csv .= '"' . $row[2] . '";"' . $brand . '";"' . $model . '";"$' . $msrp . '";"$' . $sale_price . '";"$' . $savings . '";"' . number_format((floor($savings_nf/$msrp_nf*10000)/100), 2) . "%\"\n";
                    }
                }
                header("Content-Type: application/force-download");
                header("Content-Type: application/octet-stream");
                header("Content-Type: application/download");
                header("Content-Disposition: attachment;filename=export.csv");
                header("Content-Transfer-Encoding: binary");
                echo $csv;
                exit;
            }
        }
        require_once(ROOT_DIR . 'template.php');
    }

    public function readXLS($file)
    {
        require_once 'PHPExcel' . DS . 'PHPExcel.php';
        $pExcel = PHPExcel_IOFactory::load($file);
        $tables = [];
        foreach ($pExcel->getWorksheetIterator() as $worksheet) {
            $tables[] = $worksheet->toArray();
        }
        return $tables;
    }
}