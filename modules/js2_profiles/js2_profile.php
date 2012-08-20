<?php
require_once ABSPATH . WPINC . '/pluggable.php';
require_once JS2_MODULES_PATH . 'js2_users/js2_races.php';
/**
* 
*/
class JS2_Profiles extends JS2_Controller
{
	
  var $races_obj = null;

	function __construct()
	{
		parent::__construct();

    $this->races_obj = new JS2_Races();

		$this->add_shortcodes();
    $this->add_styles();

    add_action('init', array($this, 'maintain_profile_redirect'));
	}

  function maintain_profile_redirect(){

    if(!current_user_can('administrator')){
      show_admin_bar(false);
    }

  }

  function add_styles(){
    add_action('wp_enqueue_scripts', array($this,'register_styles'));
  }

  function register_styles(){
    $cssfolder = plugin_dir_url(__FILE__) . "assets/css/";

    $filename = 'form';

    $path = $cssfolder . $filename . ".css";
    
      wp_register_style('JS2_edit_profile_style', $path);
      wp_enqueue_style('JS2_edit_profile_style');
  }

	function add_shortcodes(){
		add_shortcode('js2_profile_page', array($this, 'show_profile_page'));
		add_shortcode('js2_edit_profile_page', array($this, 'show_edit_profile_page'));
	}

  function get_races($current_user)
  {

    $user_races = $this->races_obj->get_races_by_user($current_user);

    return $user_races;

  }

	function show_profile_page($updated = false, $skip_edit_check = false){

    if( isset($_GET['edit']) && $_GET['edit'] == 'true' && !$skip_edit_check){
      $this->show_edit_profile_page();
      return;
    }

    $current_user = wp_get_current_user();
    $data['updated'] = $updated;
    $data['user_id'] = $current_user->ID;
    $data['achievements'] = $this->load->model('achievement', 'js2_achievements')->select('*')->where('user_id = ' . $current_user->ID)->orderby('presentation_date desc')->execute();
    $data['student_sum'] = $this->load->model('achievement', 'js2_achievements')->select('SUM(students) as students')->where('user_id = ' . $current_user->ID)->get_single()->students;
    $data['badges'] = new JS2_User_Badges($current_user);

    $data['table_content'] = $this->load->partial('profile_achievements_table',$data)->get_content();

    $data['races_output'] = $this->get_races( $current_user->ID );

		$this->load->view('profile',$data)->display();
	}

	function show_edit_profile_page(){


    if(isset( $_REQUEST['form_submit'] ) ){
      $this->handle_edits();
      return;
    }

    $this->load->helper('get_select_countries');

    $current_user = wp_get_current_user();
    $data['user_id'] = $current_user->ID;
    $data['achievements'] = $this->load->model('achievement', 'js2_achievements')->select('*')->where('user_id = ' . $current_user->ID)->orderby('presentation_date desc')->execute();
    $data['student_sum'] = $this->load->model('achievement', 'js2_achievements')->select('SUM(students) as students')->where('user_id = ' . $current_user->ID)->get_single()->students;
    
    $this->load->view('edit_profile',$data)->display();
	}

	function handle_edits(){

    $current_user = wp_get_current_user();

    if(isset($wp_version) && $wp_version >= 3.4){
      if ( !empty( $_REQUEST['user_name'] ) ){
        update_usermeta( $current_user->ID, 'first_name', esc_html( $_REQUEST['user_name'] ) );
      }
    }
    else {
      if ( !empty( $_REQUEST['user_name'] ) ){
        update_user_meta( $current_user->ID, 'first_name', esc_html( $_REQUEST['user_name'] ) );
      }
    }

    $JS2_Users_Obj = new JS2_Users();
    $JS2_Users_Obj->save_user_fields($current_user->ID);

    $this->load->view('edit_confirmation')->display();
	}

}

$JS2_Profiles = new JS2_Profiles();

function js2_login_redirect($redirect_to, $request){
  global $current_user;
  get_currentuserinfo();

  if( is_array( $current_user->roles ) ) {

    //is admin
    if( in_array('administrator', $current_user->roles) ){
      return home_url( '/wp-admin/' );
    } else {
      return home_url();
    }

  }
}

add_filter( 'login_redirect' , 'js2_login_redirect', 10, 3);