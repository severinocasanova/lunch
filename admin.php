<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lunch/require/setup.php');

$messages = array();

if(isset($_POST['stop_time']) && $_POST['stop_time'] != ''){
  config_set($config_file,'General','stop_time',$_POST['stop_time']);
  $GLOBALS['LUNCH_CONFIG'] = parse_ini_file($config_file, true);
  $messages[] = 'You have successfully updated the Stop Time!';
}
$T['config'] = $GLOBALS['LUNCH_CONFIG']['General'];

function config_set($config_file, $section, $key, $value) {
    $config_data = parse_ini_file($config_file, true);
    $config_data[$section][$key] = $value;
    $new_content = '';
    foreach ($config_data as $section => $section_content) {
        $section_content = array_map(function($value, $key) {
            return "$key=$value";
        }, array_values($section_content), array_keys($section_content));
        $section_content = implode("\n", $section_content);
        $new_content .= "[$section]\n$section_content\n";
    }
    file_put_contents($config_file, $new_content);
}

# template variables
$T['title'] = 'Admin';
$T['messages'] = $messages;
include($_SERVER['DOCUMENT_ROOT'].'/lunch/templates/admin.tpl.php');
?>
