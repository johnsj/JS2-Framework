<?php


/**
* JS2 Core View Class
*/
class JS2_Admin_View
{

  var $path;
  var $data;

  function __construct($path, $data = array()){
    $this->path = $path;
    $this->data = $data;
  }
  
  function display(){
    ob_start();

    do_action('JS2_Notice');

    if(!empty($this->data)){
      extract($this->data);
    }

    include $this->path;

    $content = ob_get_clean();

    echo $content;
  }

  function get_content(){
    ob_start();

    //do_action('JS2_Notice');

    if(!empty($this->data)){
      extract($this->data);
    }

    include $this->path;

    $content = ob_get_clean();

    return $content;
  }

}