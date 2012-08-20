<?php


/**
* JS2 Core View Class
*/
class JS2_View
{
  
  var $path;
  var $data;

  function __construct($path, $data = array()){
    $this->path = $path;
    $this->data = $data;
  }
  
  function display(){
    ob_start();

    do_action('JS2_Front_Notice');

    if(!empty($this->data)){
      extract($this->data);
    }

    include $this->path;

    $content = ob_get_clean();

    echo $content;
  }

  function get_partial($partialname, $data = array()){
    ob_start();

    if(!empty($data)){
      extract($data);
    }

    include dirname($this->path) . '/partials/' . $partialname . '.php';

    $content = ob_get_clean();

    return $content;

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