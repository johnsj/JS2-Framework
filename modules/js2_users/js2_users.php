<?php
require_once ABSPATH . WPINC . '/pluggable.php';


class JS2_Users extends JS2_Controller {

  var $current_user;
  var $model;

  function __construct(){

    parent::__construct();
    global $current_user;
    get_currentuserinfo();

    $this->current_user = $current_user;

    $this->add_actions();

    $this->model = $this->load->model('userinfo');

  }

  function get_sum_of_students(){

    return $this->model->get_student_sum_by_user_id($this->current_user);
  }

  function add_actions(){
    add_action('show_user_profile', array($this,'show_user_fields'));
    add_action('edit_user_profile', array($this,'show_user_fields'));

    add_action( 'personal_options_update', array( $this , 'save_user_fields' ) );
    add_action( 'edit_user_profile_update', array( $this , 'save_user_fields' ) );
  }

  function save_user_fields($user){
    //echo "<pre>" . print_r($_POST) . "</pre>";
    if(!current_user_can('edit_user', $user)){
      echo "Cannot edit!!";
      return false;
    }
    global $wpdb;

    global $wp_version;
    if($wp_version >= 3.4){
      update_user_meta($user, 'nationality', $wpdb->escape( $_POST['nationality']) );
      update_user_meta($user, 'residence', $wpdb->escape( $_POST['residence']) );
      update_user_meta($user, 'programme', $wpdb->escape( $_POST['programme']) );
      update_user_meta($user, 'network', $wpdb->escape( $_POST['network']) );
      update_user_meta($user, 'jayerole', $wpdb->escape( trim($_POST['jayerole'])) );
    } else {
      update_usermeta($user, 'nationality', $wpdb->escape( $_POST['nationality']) );
      update_usermeta($user, 'residence', $wpdb->escape( $_POST['residence']) );
      update_usermeta($user, 'programme', $wpdb->escape( $_POST['programme']) );
      update_usermeta($user, 'network',  $wpdb->escape( $_POST['network']) );
      update_usermeta($user, 'jayerole', $wpdb->escape( trim($_POST['jayerole'])) );  
    }

    
  }

  public function show_user_fields($user){

    $this->load->helper('get_select_countries');

    $data1['user'] = $user;
    $this->get_admin_page("profile", $data1)->display();

    $data['query'] = $this->model->get_student_sum_by_user_id($user->ID);

    echo $this->get_admin_page('achievements', $data)->display();
  }

}

$JS2_Users = new JS2_Users();