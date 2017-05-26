<?php
$T['webroot'] = 'lunch/';
require_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'require/setup.php');
include_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'classes/lunch_suggestions.class.php');

#if($T['user']['user_permission'] < 3){
#  $T['title'] = 'Delete Entry';
#  include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'templates/axess.t.php');
#}

$lunch_suggestions_obj = new lunch_suggestions(array('dbh' => $dbh));

$id = (preg_match("/\/delete\/.*?\/(\d+)/",$_SERVER['REQUEST_URI'],$matches) ? $matches['1'] : '');

$T['lunch_suggestion'] = $lunch_suggestions_obj->get_lunch_suggestion(array('id' => $id));
if($T['lunch_suggestion']['lunch_suggestion_ip_address'] != $_SERVER['REMOTE_ADDR']){
  header("Location: /lunch");
}

if(isset($_POST['lunch_suggestion_delete'])){
  $hash['lunch_suggestion_display'] = 0;
  if($lunch_suggestions_obj->update_lunch_suggestion(array('id' => $id, 'hash' => $hash))){
    header("Location: /lunch");
  }
}

$T['lunch_suggestion'] = $lunch_suggestions_obj->get_lunch_suggestion(array('id' => $id));
if($T['lunch_suggestion']['lunch_suggestion_ip_address'] != $_SERVER['REMOTE_ADDR']){
  header("Location: /lunch");
}

# template variables
$T['title'] = 'Add Entry';
$T['messages'] = $lunch_suggestions_obj->messages;
include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'templates/delete/lunch-suggestion.tpl.php');
?>
