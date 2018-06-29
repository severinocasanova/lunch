<?php
$T['webroot'] = '/lunch';
require_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/require/setup.php');
include_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/classes/lunch_winners.class.php');

#if($T['user']['user_permission'] < 3){
#  $T['title'] = 'Delete Entry';
#  include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'templates/axess.t.php');
#}

$lunch_winners_obj = new lunch_winners(array('dbh' => $dbh));

$id = (preg_match("/\/delete\/[\w-]+\/(\d+)/",$_SERVER['REQUEST_URI'],$matches) ? $matches['1'] : '');

if(isset($_POST['lunch_winner_delete'])){
  $hash['lunch_winner_display'] = 0;
  if($lunch_winners_obj->update_lunch_winner(array('id' => $id, 'hash' => $hash))){
    header("Location: /lunch");
  }
}

$T['lunch_winner'] = $lunch_winners_obj->get_lunch_winner(array('id' => $id));

# template variables
$T['title'] = 'Delete Entry';
$T['messages'] = $lunch_winners_obj->messages;
include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/delete/lunch-winner.tpl.php');
?>
