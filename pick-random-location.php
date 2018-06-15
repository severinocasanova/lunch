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
// select a random vote entry
$random_index = array_rand($T['lunch_locations']);
$T['random_location'] = $T['lunch_locations'][$random_index]['lunch_location_name'];

$T['lunch_winners'] = $lunch_winners_obj->get_lunch_winners(array());

# template variables
$T['title'] = 'Pick Random Location';
$T['messages'] = $lunch_locations_obj->messages;
include($_SERVER['DOCUMENT_ROOT'].'/lunch/templates/pick-random-location.tpl.php');
?>
