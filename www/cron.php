<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 09.06.2016
 * Time: 23:00
 */
$mtime = microtime();		//Считываем текущее время
$mtime = explode(" ",$mtime);	//Разделяем секунды и миллисекунды
// Составляем одно число из секунд и миллисекунд
// и записываем стартовое время в переменную
$tstart = $mtime[1] + $mtime[0];

require_once('config.php');
require_once(CORE_DIR . 'registry.php');
require_once(CORE_DIR . 'autoload.php');
$cron = new cron_class();
$cron->init();
$cron->checkQueue();
//$cron->checkGlobals();
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$totaltime = ($mtime - $tstart);
$cron->writeLog('TIME_LOG', $totaltime);
$cron->writeLog('MEMORY_LOG', (memory_get_peak_usage(true)/1048576) . 'Mb');
$cron->writeLog('MEMORY_LOG', (memory_get_usage (true)/1048576) . 'Mb');
$cron->writeLog('MYSQL_COUNT', registry::get('count'));