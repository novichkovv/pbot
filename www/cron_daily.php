<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 25.06.2016
 * Time: 18:47
 */
require_once('config.php');
require_once(CORE_DIR . 'registry.php');
require_once(CORE_DIR . 'autoload.php');
$cron = new cron_class();
$cron->cleanUp();