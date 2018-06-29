<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lunch/require/setup.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/lunch/classes/lunch_locations.class.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/lunch/classes/lunch_suggestions.class.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/lunch/classes/lunch_winners.class.php');

$lunch_locations_obj = new lunch_locations(array('dbh' => $dbh));
$lunch_suggestions_obj = new lunch_suggestions(array('dbh' => $dbh));
$lunch_winners_obj = new lunch_winners(array('dbh' => $dbh));

$id = (preg_match("/\/edit\/[\w-]+\/(\d+)/",$_SERVER['REQUEST_URI'],$matches) ? $matches['1'] : '');

# add suggestion
if(isset($_POST['lunch_winner_location'])){
  $hash = $_POST;
  if($id = $lunch_winners_obj->update_lunch_winner(array('id' => $id, 'hash' => $hash))){
    header("Location: /lunch/");
  }
}
$T['lunch_winner'] = $lunch_winners_obj->get_lunch_winner(array('id' => $id));

# template variables
$T['title'] = 'Update Entry';
$T['messages'] = $lunch_winners_obj->messages;
include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/edit/lunch-winner.tpl.php');
?>
