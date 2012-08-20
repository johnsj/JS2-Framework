<?php


if ( ! class_exists('JS2_Logger')) {
  require_once plugin_dir_path(__FILE__) . "js2_logger.php";
}

/**
* JS2 Core Controller class
*/
class JS2_Controller extends JS2_Logger
{

  var $load;
  var $table_constructer;


  var $page_title;
  var $admin_capability;
  var $main_menu_slug;
  var $icon_url;
  var $menu_position;

  var $addOn = array();
  
  function __construct($parent_module = false)
  {
    $controller_name = get_class($this);

    if($parent_module){
      $controller_name = $parent_module;
    }

    $this->load = new JS2_Load( $controller_name );
    //$this->table_constructer = new JS2_WP_List_Table();
  }

  function addOn($name, $module){
    $this->addOn[$name] = $module;
  }

  function get_table(){
    return $this->table_constructer->get_table_content();
  }

  function get_admin_page($pagename, $data = array()){
    $content = $this->load->admin_view($pagename, $data);

    return $content;
  }

  function get_addOn($modulename){
    return $this->addOn[$modulename];
  }

}