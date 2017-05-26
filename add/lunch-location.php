<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lunch/require/setup.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/lunch/classes/lunch_locations.class.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/lunch/classes/lunch_suggestions.class.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/lunch/classes/lunch_winners.class.php');

$lunch_locations_obj = new lunch_locations(array('dbh' => $dbh));
$lunch_suggestions_obj = new lunch_suggestions(array('dbh' => $dbh));
$lunch_winners_obj = new lunch_winners(array('dbh' => $dbh));

# add suggestion
if(isset($_POST['lunch_location_name'])){
  $hash = $_POST;
  if($id = $lunch_locations_obj->insert_lunch_location(array('hash' => $hash))){
    header("Location: /lunch/");
  }
}

$T['lunch_locations'] = $lunch_locations_obj->get_lunch_locations(array());
$T['lunch_suggestions'] = $lunch_suggestions_obj->get_lunch_suggestions(array());
$T['lunch_winners'] = $lunch_winners_obj->get_lunch_winners(array());

# template variables
$T['title'] = 'Add Entry';
$T['messages'] = $lunch_locations_obj->messages;
include($_SERVER['DOCUMENT_ROOT'].'/lunch/templates/add/lunch-location.tpl.php');
?>
