<?php

class lunch_locations extends common {
  var $table = 'lunch_locations';
  var $messages = array();
  var $lunch_location = array();
  var $lunch_locations = array();
  var $s = 'lunch_location_name';
  var $d = 'ASC';
  var $lunch_locations_columns = array();
  var $args;
  public $dbh;

  public function __construct($args){
    $this->dbh = $args['dbh'];
    $sql = "SHOW COLUMNS FROM $this->table";
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    while($r = $sth->fetch(PDO::FETCH_ASSOC)){
      $this->lunch_locations_columns[] = $r['Field'];
    }
  }

  # hash, user_id
  function get_lunch_locations($args){
    $fields = "CONCAT_WS(' ',lunch_location_name)";
    $query_params = common::build_search_query(array('hash' => $args['hash'], 'fields' => $fields, 'columns' => $this->lunch_locations_columns));
    $binds = $query_params['keywords'];
    $this->d = ($query_params['d'] ? $query_params['d'] : $this->d);
    $this->s = ($query_params['s'] ? $query_params['s'] : $this->s);
    # 100 is the default, pass ipp => '' if you want the full list
    $ipp = (isset($args['ipp']) ? $args['ipp'] : "100");
    $offset = (isset($args['offset']) ? "LIMIT $args[offset]" : "LIMIT 0");
    $offset = ($ipp ? "$offset, $ipp" : "");
    $sql = "
      SELECT *
      FROM lunch_locations
      WHERE ($fields LIKE $query_params[string]) AND
            lunch_location_display = '1'
      ORDER BY $this->s $this->d
      $offset";
    $sth = $this->dbh->prepare($sql);
    $sth->execute($binds);
    while ($r = $sth->fetch(PDO::FETCH_ASSOC)){
      $this->lunch_locations[] = $r;
    }
    return $this->lunch_locations;
  }

  # hash, location, user_id
  function insert_lunch_location($args){
    $hash = $args['hash'];
    if(!$hash['lunch_location_name']){
      $this->messages[] = "You did not enter in a lunch location!";
    }else{
        if($id = $this->insert_row(array('table' => $this->table, 'hash' => $hash, 'columns' => $this->lunch_locations_columns))){
          $this->messages[] = "You have successfully added a lunch location!";
          return $id;
        }
    }
  }

}
?>
