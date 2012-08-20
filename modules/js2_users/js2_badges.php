<?php



/**
* JS2 Badge Admin system
*/
class JS2_Badges extends JS2_Controller
{
	
	function __construct()
	{
		parent::__construct('js2_users');

		//$this->check_or_create_tables();
	}

	function create_admin_page(){
	add_menu_page(
      $this->page_title,            //Page Title
      'Badges',               //Menu Title
      $this->admin_capability,      //Admin Capabilities
      $this->main_menu_slug,        //Main Menu Slug
      array($this, 'admin_main'));  //Main page function
	}

	function admin_main(){	

		$this->load->admin_view('badges')->display();

		return;
	}

	function check_or_create_tables(){
		global $wpdb;
		require_once ABSPATH . '/wp-admin/includes/upgrade.php';

		$sql = '
		CREATE TABLE `' . $wpdb->prefix . 'js2_badges` (
		`recID` int(11) NOT NULL AUTO_INCREMENT,
		`badge_name` varchar(255) NOT NULL,
		`badge_description` text NOT NULL,
		`badge_criteria` varchar(255) NOT NULL,
		`badge_type` varchar(255) NOT NULL,
		`badge_img_url` varchar(255) NOT NULL,
		`badge_img_file` varchar(255) NOT NULL,
		PRIMARY KEY (`recID`) ) ';

		dbDelta($sql);
	}

	function save_badge_type_to_db(){

	}

}

//add_action('JS2_init_module', 'js2_badge_init');

function js2_badge_init(){

  $JS2_Badges = new JS2_Badges();

  $JS2_Badges->page_title = "JS2 Badges";
  $JS2_Badges->admin_capability = 'activate_plugins';
  $JS2_Badges->main_menu_slug = 'js2_badges';

  add_action('admin_menu', array($JS2_Badges, 'create_admin_page'));

}


/**
* 
*/
class JS2_Badge_Type extends JS2_Controller
{
	var $criteria;
	var $type;
	var $description;
	var $name;


	var $icons_path;

	function __construct($name, $type, $measurement, $description = "")
	{
		parent::__construct();
		$this->criteria = $measurement;
		$this->type = $type;
		$this->name = $name;
		$this->description = $description;

		$this->icons_path = plugin_dir_url(__FILE__) . 'assets/icons/';
	}

	function get_badge_img($image_name){
		return $this->icons_path . $image_name;
	}

	function get_icons_path(){
		return $this->icons_path;
	}

	function upload_icon(&$file){
		//RÆTTA OVERRIDE!!!  => $overrides = array( 'test_form' => false )
		$upload_results = wp_handle_upload(&$file, $overrides = false);

		return $upload_results;
	}

}

/**
* 
*/
class JS2_Students_Badge extends JS2_Badge_Type
{
	
	function __construct($name, $measurement, $description){
		$this->type = 'students';

		parent::__construct($name, $this->type, $measurement, $description);
		$this->icons_path = $this->icons_path . 'students/';
	}

}