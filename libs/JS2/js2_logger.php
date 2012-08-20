<?php

/**
* JS2 Framework Logger
*/
class JS2_Logger
{

  function notice($msg){
    /*add_action('JS2_Notice', function($msg) use ($msg){
      echo '<div class="updated">
        <p> ' . $msg . ' </p>
      </div>';
    });

    add_action('JS2_Front_Notice', function($msg) use ($msg){
      echo '<div class="updated">
        <p> ' . $msg . ' </p>
      </div>';
    });*/
  }

  function alert($msg){
    /*add_action('JS2_Notice', function($msg) use ($msg){
      echo '<div class="error">
        <p> ' . $msg . ' </p>
      </div>';
    });

    add_action('JS2_Front_Notice', function($msg) use ($msg){
      echo '<div class="error">
        <p> ' . $msg . ' </p>
      </div>';
    });*/
  }
}