<?php

/**
* 
*/
class Countries_Model extends JS2_Model
{

  var $_countries;
  
  function __construct()
  {
    # code...
    parent::__construct();

    $this->_tablename = "js2_countries";
  }

  function get_students_per_country(){
    global $wpdb;
    $sql = "
    SELECT wp_js2_countries.name, wp_js2_countries.code, student_per_country.students
    FROM wp_js2_countries
    LEFT JOIN student_per_country
      ON student_per_country.country = wp_js2_countries.name
      ORDER BY student_per_country.students DESC, wp_js2_countries.name";

    $this->_countries = $wpdb->get_results($sql);

    $this->add_flag_code();

    return $this->_countries;
  }


  function add_flag_code(){

  }
}