<?php

class lunch_suggestions extends common {
  var $table = 'lunch_suggestions';
  var $messages = array();
  var $lunch_suggestion = array();
  var $lunch_suggestions = array();
  var $s = 'lunch_suggestion_id';
  var $d = 'DESC';
  var $lunch_suggestions_columns = array();
  var $args;
  public $dbh;

  public function __construct($args){
    $this->dbh = $args['dbh'];
    $sql = "SHOW COLUMNS FROM $this->table";
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    while($r = $sth->fetch(PDO::FETCH_ASSOC)){
      $this->lunch_suggestions_columns[] = $r['Field'];
    }
  }

  # id, user_id
  function get_lunch_suggestion($args){
    $sql = "
      SELECT *
      FROM lunch_suggestions
      WHERE lunch_suggestion_id = :id
      LIMIT 1";
    $sth = $this->dbh->prepare($sql);
    $sth->execute(array(':id' => $args['id']));
    $r = $sth->fetch(PDO::FETCH_ASSOC);
    return $r;
  }

  # hash, user_id
  function get_lunch_suggestions($args){
    $this->lunch_suggestions = array();
    $fields = "CONCAT_WS(' ',lunch_suggestion_name,lunch_suggestion_location)";
    $query_params = common::build_search_query(array('hash' => $args['hash'], 'fields' => $fields, 'columns' => $this->lunch_suggestions_columns));
    $binds = $query_params['keywords'];
    $this->d = ($query_params['d'] ? $query_params['d'] : $this->d);
    $this->s = ($query_params['s'] ? $query_params['s'] : $this->s);
    $if_category = '';
    if(isset($args['hash']['c']) && $args['hash']['c'] != ''){
      $if_category = 'lunch_suggestion_name = :c AND ';
      $binds[':c'] = $args['hash']['c'];
    }
    # 100 is the default, pass ipp => '' if you want the full list
    $ipp = (isset($args['ipp']) ? $args['ipp'] : "100");
    $offset = (isset($args['offset']) ? "LIMIT $args[offset]" : "LIMIT 0");
    $offset = ($ipp ? "$offset, $ipp" : "");
    $sql = "
      SELECT *
      FROM lunch_suggestions
      WHERE ($fields LIKE $query_params[string]) AND
            $if_category
            lunch_suggestion_display = '1'
      ORDER BY $this->s $this->d
      $offset";
    $sth = $this->dbh->prepare($sql);
    $sth->execute($binds);
    while ($r = $sth->fetch(PDO::FETCH_ASSOC)){
      $this->lunch_suggestions[] = $r;
    }
    return $this->lunch_suggestions;
  }

  # hash, location, user_id
  function insert_lunch_suggestion($args){
    $hash = $args['hash'];
    if(!$hash['lunch_suggestion_location']){
      $this->messages[] = "You did not enter in a lunch suggestion!";
    }else{
        if($id = $this->insert_row(array('table' => $this->table, 'hash' => $hash, 'columns' => $this->lunch_suggestions_columns))){
          $this->messages[] = "You have successfully added a lunch_suggestion!";
          return $id;
        }
    }
  }

  # hash, id, user_id
  function update_lunch_suggestion($args){
    $hash = $args['hash'];
    $item = $this->get_lunch_suggestion(array('id' => $args['id']));
    $where = 'lunch_suggestion_id = :id';
    $update = NULL;
    foreach($hash as $k => $v){
      if($hash[$k] != $item[$k] && array_key_exists($k, $item)){
        $binds[':'.$k] = $v;
        $update .= (is_null($v) ? "$k = NULL, " : "$k = :$k, ");
        $this->messages[] = "You have successfully updated the $k!";
      }
    }
    $update = rtrim($update, ', ');
    $sql = "UPDATE $this->table SET $update WHERE $where";
    if($update){
      $binds[':id'] = $args['id'];
      $sth = $this->dbh->prepare($sql);
      $sth->execute($binds);
      return 1;
    }
  }

}
?>
