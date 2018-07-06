<?php
$GLOBALS['PROJECTS']['LUNCH_ROOT'] = __DIR__ . '/../';
$GLOBALS['LUNCH_CONFIG'] = parse_ini_file($GLOBALS['PROJECTS']['LUNCH_ROOT'] . '/config.ini', true);
$document_root = $GLOBALS['LUNCH_CONFIG']['General']['document_root'];

$_SERVER['DOCUMENT_ROOT'] = $document_root;
require_once($_SERVER['DOCUMENT_ROOT'].'/lunch/require/setup.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/lunch/classes/lunch_suggestions.class.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/lunch/classes/lunch_winners.class.php');

$lunch_suggestions_obj = new lunch_suggestions(array('dbh' => $dbh));
$lunch_winners_obj = new lunch_winners(array('dbh' => $dbh));

$T['stop_time'] = $stop_time;

// what did people vote for? returns an array of associated arrays
$T['lunch_suggestions'] = $lunch_suggestions_obj->get_lunch_suggestions(array('hash' => array()));
$lunch_suggestions = $T['lunch_suggestions'];

// remove users who can't go
foreach($T['lunch_suggestions'] as $k => $v){
  if($v['lunch_suggestion_location'] == "Can't Go"){
    unset($lunch_suggestions[$k]);
  }
}
/*
Array
(
    [0] => Array
        (
            [lunch_suggestion_id] => 129
            [lunch_suggestion_created] => 2017-05-26 01:48:54
            [lunch_suggestion_name] => Severino
            [lunch_suggestion_ip_address] => 192.168.1.111
            [lunch_suggestion_location] => El Guero Canelo
            [lunch_suggestion_display] => 1
        )
)
*/

// select a random vote entry
$random_index = array_rand($lunch_suggestions);
$T['potential_winner'] = $lunch_suggestions[$random_index]['lunch_suggestion_location'].' - '.$lunch_suggestions[$random_index]['lunch_suggestion_name'];

$potential_winner = '';
$people_suggesting = array();
$lunch_suggestions_count = array();

// loop through suggestions to get count and percentage of each suggestion
// Also create an array of voters and what they voted for
foreach($lunch_suggestions as $i){
  if(isset($lunch_suggestions_count[$i['lunch_suggestion_location']])){
    $lunch_suggestions_count[$i['lunch_suggestion_location']]['count']++;
  }else{
    $lunch_suggestions_count[$i['lunch_suggestion_location']] = array();
    $lunch_suggestions_count[$i['lunch_suggestion_location']]['count'] = 1;
  }
  $lunch_suggestions_count[$i['lunch_suggestion_location']]['percentage'] = $lunch_suggestions_count[$i['lunch_suggestion_location']]['count'] / count($lunch_suggestions) * 100;
  if(!isset($people_suggesting[$i['lunch_suggestion_name']][$i['lunch_suggestion_location']])){
    $people_suggesting[$i['lunch_suggestion_name']][$i['lunch_suggestion_location']] = 0;
  }
  $people_suggesting[$i['lunch_suggestion_name']][$i['lunch_suggestion_location']]++;
}

// find a people percentage
$people_percentage = array();
foreach($lunch_suggestions as $i){
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
arsort($T['people_percentage']);

// find suggestions that have over 50% of the people voting for them
$over_50 = array();
foreach($people_percentage as $k => $v){
  if($v > 50){
    $over_50[$k]['people_percentage'] = $v;
    $over_50[$k]['suggestion_percentage'] = $lunch_suggestions_count[$k]['percentage'];
  }
}

if(count($over_50)){
  // find top people_percentage
  $top_people_percentage = 0;
  foreach($over_50 as $k => $v){
    if($v['people_percentage'] < $top_people_percentage ){
      unset($over_50[$k]);
    }else{
      $top_people_percentage = $v['people_percentage'];
    }
  }

  // find top suggestion_percentage
  $top_suggestion_percentage = 0;
  foreach($over_50 as $k => $v){
    if($v['suggestion_percentage'] >= $top_suggestion_percentage ){
      $top_suggestion_percentage = $v['suggestion_percentage'];
      $potential_winner = $k;
    }
  }

  // do we have suggestions with the same people percentage AND same suggestion percentage?
  $same_suggestion_percentage = array();
  foreach($over_50 as $k => $v){
    if($v['suggestion_percentage'] == $top_suggestion_percentage){
      $same_suggestion_percentage[] = $k;
    }
  }

  // if same people percentage AND same suggestion percentage then randomly select one
  if(count($same_suggestion_percentage) > 1){
    $random_index = array_rand($same_suggestion_percentage);
    $potential_winner = $same_suggestion_percentage[$random_index];
  }
}

// if we have a suggestion that overrides the random pick
if($potential_winner){
  $potential_winner_text = $potential_winner.' - ';
  foreach(array_reverse($T['lunch_suggestions']) as $i){
    if($i['lunch_suggestion_location'] == $potential_winner){
      $potential_winner_text .= $i['lunch_suggestion_name'].' ';
    }
  }
  $T['potential_winner'] = $potential_winner_text;
}

// make sure not to write to the winner file after the stop_time
if(date("Y-m-d H:i:s", time() - 5) < $T['stop_time']){
  file_put_contents($_SERVER['DOCUMENT_ROOT'].'/lunch/files/potential-winner.txt', $T['potential_winner']);
}

// if same minute, update the winners database
if(date("Y-m-d H:i", time()) == date("Y-m-d H:i",strtotime($T['stop_time']))){
  $hash = array();
  $hash['lunch_winner_location'] = $T['potential_winner'];
  $lunch_winners_obj->insert_lunch_winner(array('hash' => $hash));
}
?>
