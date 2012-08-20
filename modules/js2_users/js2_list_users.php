<?php
require_once ABSPATH . '/wp-includes/user.php';
require_once JS2_MODULES_PATH . 'js2_users/js2_races.php';
/**
* 
*/
class JS2_List_Users extends JS2_Controller
{
  
  function __construct()
  {
    parent::__construct("js2_users");
    $this->add_shortcodes();
    $this->add_styles();
  }

  function add_shortcodes(){
    add_shortcode('js2_list_user_achievements', array($this, 'list_user_achievements'));
  }

  function add_styles(){

    add_action('wp_enqueue_scripts', array($this,'register_the_style'));
  }

  function register_the_style(){
    $cssfolder = plugin_dir_url(__FILE__) . "assets/css/";

    $filename = 'profile';

    $path = $cssfolder . $filename . ".css";
    
      wp_register_style('JS2_profile_style', $path);
      wp_enqueue_style('JS2_profile_style');
  }

  function list_user_achievements(){

    if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] !== "") {

      $data['achievements'] = $this->load->model('achievement', 'js2_achievements')->select('*')->where('user_id = ' . $_REQUEST['user_id'])->orderby('presentation_date desc')->execute();
      $data['user_id'] = $_REQUEST['user_id'];
      $data['student_sum'] = $this->load->model('achievement', 'js2_achievements')->select('SUM(students) as students')->where('user_id = ' . $_REQUEST['user_id'])->get_single()->students;
      
      if(isset($_REQUEST['achievement']) && $_REQUEST['achievement'] !== ""){

        $data['current_achievement'] = $this->load->model('achievement', 'js2_achievements')->select('*')->where('recID = ' . $_REQUEST['achievement'])->get_single();

        return $this->load->view('profile_achievement',$data)->get_content();

      }

      $badge_user = get_userdata($_REQUEST['user_id']);

      $data['badges'] = new JS2_User_Badges($badge_user);

      $data['table_content'] = $this->load->partial('profile_achievements_table',$data)->get_content();

      return $this->load->view('profile',$data)->display();

    }
    $data['achievements'] = $this->load->model('achievement', 'js2_achievements')->select('user_id, sum(students) as students')->group('user_id')->orderby('students desc')->execute();

    $this->load->view('list-users',$data)->display();
  }

}


/**
* User Badge System
*/
class JS2_User_Badges extends JS2_Controller
{
  
  var $user;
  var $awarded_badges = array();

  function __construct($user)
  {
    parent::__construct();
    $this->user = $user;
    $this->calculate_badges();
  }

  function get_badges(){
    return $this->awarded_badges;
  }

  function calculate_badges(){

    $student_sum = $this->load->model('achievement', 'js2_achievements')->select('SUM(students) as students')->where( 'user_id = ' . $this->user->ID )->get_single()->students;

    switch ($student_sum) {
      case null:
        break;

      case (intval( $student_sum ) >= 1000):
        $this->award_badge(1000);
      case (intval( $student_sum ) >= 500):
        $this->award_badge(500);
      case (intval( $student_sum ) >= 200):
        $this->award_badge(200);
      case (intval( $student_sum ) >= 100):
        $this->award_badge(100);
      case (intval( $student_sum ) >= 50):
        $this->award_badge(50);
        break;
      
      default:
        # code...
        break;
    }

  }

  function get_badges_img_paths(){
    
    $badges = array();

    if(isset($this->awarded_badges[2500])){
      $badge_img = 'chaging-lives_badges_16.png';
      $badge_folder = plugin_dir_url(__FILE__) . 'assets/icons/';
      array_push($badges, $badge_folder . $badge_img);
      //return $badges;
    }

    if(isset($this->awarded_badges[1000])){
      $badge_img = 'chaging-lives_badges_15.png';
      $badge_folder = plugin_dir_url(__FILE__) . 'assets/icons/';
      array_push($badges, $badge_folder . $badge_img);
      //return $badges;
    }

    if(isset( $this->awarded_badges[500]) ){
      $badge_img = 'chaging-lives_badges_09.png';
      $badge_folder = plugin_dir_url(__FILE__) . 'assets/icons/';
      array_push($badges, $badge_folder . $badge_img);
      //return $badges;
    }

    if(isset( $this->awarded_badges[200]) ){
      $badge_img = 'chaging-lives_badges_07.png';
      $badge_folder = plugin_dir_url(__FILE__) . 'assets/icons/';
      array_push($badges, $badge_folder . $badge_img);
      //return $badges;
    }

    if(isset( $this->awarded_badges[100]) ){
      $badge_img = 'chaging-lives_badges_05.png';
      $badge_folder = plugin_dir_url(__FILE__) . 'assets/icons/';
      array_push($badges, $badge_folder . $badge_img);
      //return $badges;
    }

    if(isset( $this->awarded_badges[50]) ){
      $badge_img = 'chaging-lives_badges_03.png';
      $badge_folder = plugin_dir_url(__FILE__) . 'assets/icons/';
      array_push($badges, $badge_folder . $badge_img);
      //return $badges;
    }

    return $badges;
  }

  function award_badge($award){
    $this->awarded_badges[$award] = true;
  }

}

$JS2_List_Users = new JS2_List_Users();