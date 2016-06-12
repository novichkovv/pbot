<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 12.06.2016
 * Time: 21:30
 */
require_once('config.php');
require_once(CORE_DIR . 'registry.php');
require_once(CORE_DIR . 'autoload.php');
$api = new api_class();
$api->sendMessage('79263335708', 'Hello');