<?php

if ( ! class_exists('JS2_Logger')) {
  require_once plugin_dir_path(__FILE__) . "js2_logger.php";
}

/**
* JS2 Framework Registry
* Used to store all initialized class for cross-functionality
*/
class JS2_Registry extends JS2_Logger
{
  
  var $registry = array();

  function __construct()
  {
    # code...
  }

  function add($name, $obj){

    if( isset( $this->registry[$name] ) ){
      $this->notice($name . " is already used in the JS2 Registry");
      return false;
    }

    $this->registry[$name] = $obj;
  }

  function get($name){

    if(! isset($this->registry[$name]) ){

      $this->notice($name . " was not found in the JS2 Registry");

      return false;
    }

    return $this->registry[$name];
  }
}