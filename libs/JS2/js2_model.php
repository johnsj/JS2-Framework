<?php

if ( ! class_exists('JS2_Logger')) {
  require_once plugin_dir_path(__FILE__) . "js2_logger.php";
}

/**
* JS2 Core Model Class
*/
class JS2_Model extends JS2_Logger
{
  
  var $select_statement;
  var $where_statement = null;
  var $order_statement = null;
  var $group_statement = null;

  var $from_statement;

  var $_tablename;

  var $query;

  function __construct()
  {

  }

  function select($query){
    global $wpdb;
    $this->select_statement = "SELECT " . $wpdb->escape($query);

    return $this;
  }

  function where($query){
    global $wpdb;
    $this->where_statement = " WHERE " . $wpdb->escape($query);

    return $this;
  }

  private function from(){
    global $wpdb;
    $this->from_statement = " FROM " . $wpdb->escape($this->tablename());

    return $this;
  }

  function perform_query($sql){
    global $wpdb;

    return $wpdb->query($sql);
  }

  function generate_query(){
    $query = $this->select_statement;

    $this->from();

    $query .= $this->from_statement;

    if($this->where_statement){
      $query .= $this->where_statement;
    }

    if($this->group_statement){
      $query .= $this->group_statement;
    }

    if($this->order_statement){
      $query .= $this->order_statement;
    }

    $this->query = $query;

  }

  function tablename(){
    global $wpdb;

    return $wpdb->prefix . $this->_tablename;
  }

  function execute($dataform = OBJECT){
    global $wpdb;

    $this->generate_query();

    $results = $wpdb->get_results($this->query, $dataform);

    return $results;

  }


  function get_single($dataform = OBJECT){
    global $wpdb;

    $this->generate_query();

    $result = $wpdb->get_row($this->query, $dataform);

    return $result;
  }

  function group($query){
    global $wpdb;
    $this->group_statement = " GROUP BY " . $wpdb->escape($query);

    return $this;
  }

  function orderby($query){
    global $wpdb;
    $this->order_statement = " ORDER BY " . $wpdb->escape($query);

    return $this;
  }
}