<?php
/**
* 
*/
class JS2_Registration extends JS2_Controller
{
  
  function __construct()
  {
    parent::__construct();
    $this->shortcodes();
    $this->actions();
    $this->load->helper('get_select_countries');
  }

  function shortcodes(){
    add_shortcode( 'js2_register_form', array( $this, 'registration_form' ) );
  }

  function actions(){
    $this->registration_styles();
  }

  function registration_form($atts, $content){

    if($_POST && wp_verify_nonce($_POST['js2_form_registration_nonce'], 'js2_form_registration')){
      if($this->respond_to_registration()){
        $this->load->view('registration_confirmation')->display();
      }
    } else {
      if(is_user_logged_in()){
        $this->load->view('registration_logged_in')->display();
      } else {
        $this->load->view('registration_form')->display();
      }
    }

  }

  function registration_styles()
  {

    add_action('wp_enqueue_scripts', array($this, 'register_the_style'));
  }

  function register_the_style(){
    $cssfolder = plugin_dir_url(__FILE__) . "assets/css/";

    $path = $cssfolder . 'style' . ".css";
      wp_register_style('JS2_registration_style', $path);
      wp_enqueue_style('JS2_registration_style');

  }

  function respond_to_registration(){
    //echo "<pre>" . print_r($_POST) . "</pre>";

    //arguments to validate
    if(!$this->validation_check()){
      echo apply_filters('js2_registration_form', $this->load->view('registration_form')->get_content());
      return;
    } 

    $args = array();
    $username = $_POST['email'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $user_id = wp_create_user( $username, $password, $email );

    if( is_wp_error($user_id) ){
      switch ($user_id->get_error_code()) {
        case 'existing_user_login':
          js2_registration_alert('This email is already used.');
          break;
        case 'empty_user_login':
          js2_registration_alert('You need to provide an email.');
          break;
        case 'existing_user_email':
          js2_registration_alert('This email is already used.');
          break;

        default: 
          js2_registration_alert();
          break;
      };
      echo apply_filters('js2_registration_form', $this->load->view('registration_form')->get_content());
      return;
    } else {

        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $args["nationality"] = $_POST["nationality"];
        $args["residence"] = $_POST["residence"];
        $args["programme"] = $_POST["programme"];
        $args["network"] = $_POST["network"];
        $args["jayerole"] = $_POST["jayerole"];

        //echo "<pre>" . print_r($args) . "</pre>";

        $userdata = array( 'ID'=>$user_id, 'first_name' => $first_name, 'last_name' => $last_name );

        $update_result = wp_update_user($userdata);

        if( is_wp_error($update_result) ){
          //return $update_result;
          echo "wp_update_user failed";

        }

        $result = $this->update_wp_user_meta($args, $user_id);

        if ( is_wp_error( $result ) ) {
          //return $result;
          echo "update_user_meta failed";
        }
      }

    return $user_id;
  }

  function update_wp_user_meta($args, $user_id){

    foreach ($args as $key => $value) {
      $result = add_user_meta($user_id, $key, $value, $unique = true);
      if ( !$result ) {
        return new WP_Error('js2_user_meta_failed', 'User meta failed: ' . $key . ' - ' . $value);
      }
    }

  }

  function validation_check(){
    $valid = true;

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    //$nationality = $_POST["nationality"];
    //$residence = $_POST["residence"];
    $programme = $_POST["programme"];
    //$network = $_POST["network"];
    //$jayerole = $_POST["jayerole"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    //$validation_args = compact($first_name, $last_name, $nationality, $residence, $programme, $network);

    if($first_name == null || $first_name == ""){
      js2_registration_alert('No first name specified.');
      $valid = false;
    }
    if($last_name == null || $last_name == ""){
      js2_registration_alert('No last name specified.');
      $valid = false;
    }
    if($programme == null || $programme == ""){
      js2_registration_alert('No programme specified.');
      $valid = false;
    }
    if($email == null || $email == ""){
      js2_registration_alert('No email specified.');
      $valid = false;
    }
    if($password == null || $password == ""){
      js2_registration_alert('No password specified.');
      $valid = false;
    }

    return $valid;
  }
}

$JS2_Registration = new JS2_Registration();