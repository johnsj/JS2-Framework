<?php


/**
* JS2 Core class for the JS2 Framework
*/
class JS2_Core
{
  
  function __construct()
  {
    # code...
  }

  function init(){
    $this->loop_through_libraries();
    $this->loop_through_modules();
  }


  function loop_through_libraries(){

    $libs_directory = JS2_ABSPATH . "libs/";

    foreach (glob($libs_directory . "*", GLOB_ONLYDIR) as $dir) {

      $current_dir = opendir($dir);

      while (false !== ( $file = readdir($current_dir) ) ) {
        
        if($file != "." && $file != ".."){
          require_once($dir . "/" . $file);
        }

      }

      closedir();

    }

  }


  function loop_through_modules(){

    $modules_directory = JS2_ABSPATH . "modules/";

    foreach (glob($modules_directory . "*", GLOB_ONLYDIR) as $dir) {

      $current_dir = opendir($dir);

      while (false !== ( $file = readdir($current_dir) ) ) {

        $fileinfo = pathinfo($file);
        
        if( isset($fileinfo['extension']) && $fileinfo['extension'] == "php" ){
          require_once($dir . "/" . $file);
        }

      }

      closedir();

    }    
  }

}



$js2_core = new JS2_Core();
add_action('JS2_load_framework', array($js2_core, 'init'));

do_action('JS2_load_framework');


do_action('JS2_init_lib_class');

do_action('JS2_init_module');

do_action('JS2_activation_deactivation_scripts');

do_action('JS2_Display_UI');