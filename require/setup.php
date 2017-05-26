<?php
$T['webroot'] = '/lunch';
include_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/classes/common.class.php');

$GLOBALS['PROJECTS']['LUNCH_ROOT'] = __DIR__ . '/../';
$GLOBALS['LUNCH_CONFIG'] = parse_ini_file($GLOBALS['PROJECTS']['LUNCH_ROOT'] . '/config.ini', true);
$db_hostname = $GLOBALS['LUNCH_CONFIG']['General']['db_hostname'];
$db_database = $GLOBALS['LUNCH_CONFIG']['General']['db_database'];
$db_username = $GLOBALS['LUNCH_CONFIG']['General']['db_username'];
$db_password = $GLOBALS['LUNCH_CONFIG']['General']['db_password'];
$stop_time = $GLOBALS['LUNCH_CONFIG']['General']['stop_time'];
$parent_url = $GLOBALS['LUNCH_CONFIG']['General']['parent_url'];

try {
  $dbh = new PDO("mysql:host=$db_hostname;dbname=$db_database", $db_username, $db_password);
}catch(PDOException $e) {
  exit;
}

$common_obj = new common(array('dbh' => $dbh));

date_default_timezone_set("America/Phoenix");
$T['image_src'] = '';
$T['refresh'] = '';
$T['meta_description'] = '';
$T['meta_keywords'] = '';
foreach (array('a','c','d','q','s','t') as $i){
  $T[$i] = (!empty($_GET[$i]) ? preg_replace('/"/',"&quot;", $_GET[$i]) : '');
}
