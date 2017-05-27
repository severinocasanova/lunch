<?php
$T['webroot'] = '/lunch';
require_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/require/setup.php');
include_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/classes/lunch_locations.class.php');
include_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/classes/lunch_suggestions.class.php');
include_once($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/classes/lunch_winners.class.php');

$lunch_locations_obj = new lunch_locations(array('dbh' => $dbh));
$lunch_suggestions_obj = new lunch_suggestions(array('dbh' => $dbh));
$lunch_winners_obj = new lunch_winners(array('dbh' => $dbh));

// values from config.ini
$T['stop_time'] = $stop_time;
$T['people'] = $voters;

# add suggestion
if(isset($_POST['lunch_suggestion_location']) && in_array($_POST['lunch_suggestion_name'],$T['people'])){
  $hash = array();
  $hash = $_POST;
  $hash['lunch_suggestion_ip_address'] = $_SERVER['REMOTE_ADDR'];
  # do they have 2 active right now?
  $hash2 = array();
  $hash2['c'] = $_POST['lunch_suggestion_name'];
  $T['lunch_suggestions'] = $lunch_suggestions_obj->get_lunch_suggestions(array('hash' => $hash2));
  if(count($T['lunch_suggestions']) >= 2){
    $lunch_suggestions_obj->messages[] = 'This user has already voted twice!';
  }else{
    if($id = $lunch_suggestions_obj->insert_lunch_suggestion(array('hash' => $hash))){
      #header("Location: /lunch");
    }
  }
}

$T['lunch_locations'] = $lunch_locations_obj->get_lunch_locations(array('hash' => array()));
$T['lunch_suggestions'] = $lunch_suggestions_obj->get_lunch_suggestions(array('hash' => array()));

$people_suggesting = array();
$lunch_suggestions_count = array();

// loop through suggestions to get count and percentage of each suggestion
// Also create an array of voters and what they voted for
foreach($T['lunch_suggestions'] as $i){
  if(isset($lunch_suggestions_count[$i['lunch_suggestion_location']])){
    $lunch_suggestions_count[$i['lunch_suggestion_location']]['count']++;
  }else{
    $lunch_suggestions_count[$i['lunch_suggestion_location']] = array();
    $lunch_suggestions_count[$i['lunch_suggestion_location']]['count'] = 1;
  }
  $lunch_suggestions_count[$i['lunch_suggestion_location']]['percentage'] = $lunch_suggestions_count[$i['lunch_suggestion_location']]['count'] / count($T['lunch_suggestions']) * 100;
  if(!isset($people_suggesting[$i['lunch_suggestion_name']][$i['lunch_suggestion_location']])){
    $people_suggesting[$i['lunch_suggestion_name']][$i['lunch_suggestion_location']] = 0;
  }
  $people_suggesting[$i['lunch_suggestion_name']][$i['lunch_suggestion_location']]++;
}

// find a people percentage
$people_percentage = array();
foreach($T['lunch_suggestions'] as $i){
  $this_suggested = 0;
  foreach($people_suggesting as $k => $v){
    if(isset($people_suggesting[$k][$i['lunch_suggestion_location']])){
      $this_suggested++;
    }
  }
  if($this_suggested){
    $people_percentage[$i['lunch_suggestion_location']] = $this_suggested / count($people_suggesting) * 100;
  }
}
$T['people_percentage'] = $people_percentage;

$T['lunch_winners'] = $lunch_winners_obj->get_lunch_winners(array('hash' => array()));

$T['current_time'] = date('Y-m-d H:i:s', time() - 1);
if($T['current_time'] >= $T['stop_time'] && date('Y-m-d H:i:s', time() - 5) < $T['stop_time']){
  sleep(3);
}
$T['potential_winner'] = file_get_contents(__DIR__ . '/files/potential-winner.txt');

# template variables
$T['title'] = 'Over-Engineered Unbiased Lunch Selector';
$T['messages'] = $lunch_suggestions_obj->messages;
$T['lunch_suggestions_count'] = $lunch_suggestions_count;
include($_SERVER['DOCUMENT_ROOT'].$T['webroot'].'/templates/index.tpl.php');
