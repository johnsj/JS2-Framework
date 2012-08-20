<?php

/*
Plugin Name: JS2 Framework
Author: John Schwartz Jacobsen
Description: A basic framework for plugin development
Version: 0.1

*/

//Declaration of Plugin Constants
define( 'JS2_ABSPATH', plugin_dir_path( __FILE__ ) );
define( 'JS2_MODULES_PATH', JS2_ABSPATH . "modules/");


require_once(JS2_ABSPATH . "libs/JS2/js2_core.php" );