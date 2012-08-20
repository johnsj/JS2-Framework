
<?php

/**
* 
*/
class Achievement_Model extends JS2_Model
{
  
  function __construct()
  {
    # code...
    parent::__construct();
    $this->_tablename = 'js2_achievements';

  }

  function get_results(){
    return $this->select('*')->execute();
  }

  function get_results_as_array(){
    return $this->select('*')->execute(ARRAY_A);
  }

  function get_achievement_by_recid($recid){
    return $this->select('*')->where('recID = ' . $recid)->get_single();
  }

  function delete_achievements($recids){
    global $wpdb;

    if(is_array($recids)){
      $recids = join($recids, ',');
    }

    $sql = "DELETE FROM " . $wpdb->prefix . $this->_tablename . " WHERE recID IN (%s)";

    $sql = $wpdb->prepare($sql, $recids);

    return $this->perform_query($sql);
  }

  function get_achievements_by_recids($recids){

    if(is_array($recids)){
      $recids = join($recids, ',');
    }

    return $this->select('*')->where('recID IN (' . $recids . ')')->execute();
  }

  function get_achievements_by_user_id($user_id){
        if(is_array($user_id)){
      $recids = join($user_id, ',');
    }

    return $this->select('*')->where('user_id IN (' . $user_id . ')')->execute();
  }

}
