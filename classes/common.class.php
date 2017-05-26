<?php

class common {
  var $messages = array();
  var $args;
  public $dbh;

  public function __construct($args){
    $this->dbh = $args['dbh'];
  }

  # hash, fields
  static function build_search_query($args){
    $fields = $args['fields'];
    $query = array();
    $query['d'] = $query['s'] = '';
    $query['string'] = ':k0';
    $query['keywords'][] = (isset($args['hash']['q']) ? $args['hash']['q'] : '');
    $query_string = '';

    # look for OR searches
    $query_keywords = array();
    foreach($query['keywords'] as $qk){
      if(preg_match('/\s+OR\s+/i', $qk, $matches)){
        $keywords = preg_split('/\s+OR\s+/i', $qk);
        foreach($keywords as $k => $v){
          $query_keywords[] = $v;
          $key = array_search($v, $query_keywords);
          if($k != count($keywords) - 1){
            $query_string .= ":k$key OR $fields LIKE ";
          }else{
            $query_string .= ":k$key";
          }
        }
      }else{
        $query_keywords[] = $qk;
      }
    }
    $query['keywords'] = $query_keywords;

    # look for AND searches
    $query_keywords = array();
    foreach($query['keywords'] as $qk){
      if(preg_match('/(\s+AND\s+|\s+)/i', $qk, $matches)){
        $keywords = preg_split('/(\s+AND\s+|\s+)/i', $qk);
        foreach($keywords as $k => $v){
          $query_keywords[] = $v;
          $key = array_search($v, $query_keywords);
          if($k != count($keywords) - 1){
            $query_string .= ":k$key AND $fields LIKE ";
          }else{
            $query_string .= ":k$key";
          }
        }
      }else{
        $query_keywords[] = $qk;
      }
    }
    $query['keywords'] = $query_keywords;

    # prepare keywords for bind array so it can be passed to PDO
    $query_keywords = array();
    foreach($query['keywords'] as $k => $v){
      $query_keywords[':k'.$k] = "%$v%";
    }
    $query['keywords'] = $query_keywords;

    if($query_string)
      $query['string'] = $query_string;

    # order by
    if(isset($args['hash']['s'])){
      $key = array_search($args['hash']['s'],$args['columns']);
      $query['s'] = ($key ? $args['columns'][$key] : '');
    }
    # direction
    $directions = array('asc','desc');
    if(isset($args['hash']['d'])){
      $key = array_search($args['hash']['d'],$directions);
      $query['d'] = (isset($key) ? $directions[$key] : NULL);
    }
    return $query;
  }

  static function get_pages($page,$pages_count){
    if($pages_count < 1)
      $pages_count = 1;
    $page_range = range(1, $pages_count);
    foreach ($page_range as $p){
      # the 10 here is a 10 page spread, not items per page
      if(abs($page - $p) <= 10){
        $pages[] = $p;
      }
    }
    return($pages);
  }

  # id, bow
  static function get_url($args){
    $types = array('AB' => '/address-book/',
                   'A' => '/activities/',
                   'AC' => '/accounts/',
                   'V' => '/vehicles/',
                   'W' => '/wishes/',
                   'WC' => '/wedding/costs/');
    $type = preg_replace('/\d+/','', $args['id']);
    $bow_characters = 150-strlen('http://severinocasanova.com')-strlen($types{$type})-strlen($args['id'])-1;
    $bow = strtolower($args['bow']);
    $bow = preg_replace('/\s+/','-', $bow);
    $bow = preg_replace('/[^\w-\/]/','', $bow);
    $useless_words = array('a','an','of','the','in','with',
                           'and','or','on');
    foreach($useless_words as $bad_word){
       $bow = preg_replace('/-'.$bad_word.'-/','-', $bow);
    }
    $bow = preg_replace('/-+/','-', $bow);
    if(preg_match('/(.{'.$bow_characters.'})/', $bow, $matches)){
      $bow = $matches[1];
      if(preg_match('/(.*)-/', $bow, $last_space)){
        $bow = $last_space[1];
      }
    }
    $url = $types[$type].$bow.'/'.$args['id'];
    $url = preg_replace('/(-\/|\/-)/','/', $url);
    return $url;
  }

  # table, hash, columns
  public function insert_row($args){
    # only allow known columns
    foreach($args['columns'] as $i){
      if(isset($args['hash'][$i]))
        $hash[$i] = $args['hash'][$i];
    }
    $sql = sprintf('INSERT INTO %s (%s) VALUES (:%s)',
             $args['table'],
             implode(', ', array_keys($hash)),
             implode(', :', array_keys($hash)));
    # prepare keywords for bind array so it can be passed to PDO
    $binds = array();
    foreach($hash as $k => $v){
      $binds[':'.$k] = $v;
    }
    $sth = $this->dbh->prepare($sql);
#$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
#print $sql;
#error_log('sql:'.$sql);
    $sth->execute($binds);
#$binds_json = json_encode($binds);
#error_log('binds:'.$binds_json);
    return $this->dbh->lastInsertId();
  }

}

?>
