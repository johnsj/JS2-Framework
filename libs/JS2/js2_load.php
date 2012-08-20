<?php


if ( ! class_exists('JS2_Logger')) {
  require_once plugin_dir_path(__FILE__) . "js2_logger.php";
}

/**
* JS2 Core Loader class
*/
class JS2_Load extends JS2_Logger
{
  
  var $plugin_directory;

  function __construct($controller_name)
  {
      $this->plugin_directory = JS2_MODULES_PATH . strtolower($controller_name) .'/';
  }

  function library($lib_name){
    $libfolder = $this->plugin_directory . "assets/libs/";

    require_once $libfolder . $lib_name . ".php";
  }

  function helper($helper){
    require_once JS2_ABSPATH . "helpers/" . $helper . ".php";
  }

  function partial($partialname, $data){
    $viewfolder = $this->plugin_directory . 'views/partials/';

    $path = $viewfolder . $partialname . '.php';

    return new JS2_View($path, $data);
  }

  function view($viewname, $data = array()){
    $viewfolder = $this->plugin_directory . 'views/';

    $path = $viewfolder . $viewname . '.php';

    return new JS2_View($path, $data);
  }

  function admin_view($viewname, $data = array()){
    $admin_view_folder = $this->plugin_directory . "admin_views/";

    $path = $admin_view_folder . $viewname . ".php";

    return new JS2_Admin_View($path, $data);

  }

  function model($modelname, $module = false){
    $modelfolder = $this->plugin_directory . 'models/';

    if($module){
      $modelfolder = JS2_MODULES_PATH . strtolower($module) . "/" . "models/";
    }

    $modelpath = $modelfolder . $modelname . ".php";

    if(file_exists($modelpath)){
      require_once $modelpath;

      $klass = ucfirst($modelname) . "_Model";

      $model = new $klass();

      return $model;
    } else {
      $this->notice('Did not find: <br>' . $modelpath);
    }
  }

  function table($tablename, $model){
    $tablefolder = $this->plugin_directory . 'tables/';

    $tablepath = $tablefolder . $tablename . "_table.php";

    if (file_exists($tablepath)) {
      # code...
      require_once $tablepath;

      $klass = ucfirst($tablename) . "_Table";

      $table = new $klass($model);

      return $table;
    } else {
      $this->notice("Did not find table: " . $tablename);
    }
  }

}