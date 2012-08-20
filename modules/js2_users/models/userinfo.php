<?php

/**
* 
*/
class Userinfo_Model extends JS2_Model
{
  
  function __construct()
  {
    # code...
    parent::__construct();
  }

  function get_student_sum_by_user_id($user_id){

    global $wpdb, $JS2_Registry;

    $this->_tablename = "js2_achievements";

   return $this->select('SUM(students) as students')->where('user_id =' . $user_id)->get_single();

  }
}