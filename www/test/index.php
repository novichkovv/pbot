<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 31.05.2016
 * Time: 21:12
 */
require_once('config.php');
require_once(ROOT_DIR . 'controller.php');
$controller = new controller();
$controller->index();