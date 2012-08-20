<?php

/**
* 
*/
class JS2_Database_Table
{
  var $columns = array();

  function __construct(){
  }

  function add_column($column_name, $data_type){
    array_push($this->columns, array($column_name, $data_type));
  }

  function generate_sql(){
    $sql = "";
    

    echo $sql;
  }

}