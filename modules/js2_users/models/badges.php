<?php

/**
* 
*/
class Badges_Model extends JS2_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->_tablename = "js2_badges";
	}

	function get_all_badges(){
		global $wpdb;

		return $this->select('*')->execute();
	}

	function add_bagde($name, $description, $criterias){
		global $wpdb;

		$db_args['badge_name'] = $name;
		$db_args['badge_description'] = $description;
		$db_args['badge_criteria'];
		$db_args['badge_type'];

		$wpdb->insert($this->_tablename, $db_args);
		
	}
}