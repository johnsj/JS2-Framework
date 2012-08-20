<?php

/**
* 
*/
class JS2_Facebook extends JS2_Controller
{
	var $instance;
  var $user;
  var $user_profile;

  var $appID;
  var $secret;
	
	function __construct()
	{
		parent::__construct();
		$this->load_sdk();
		$this->setup_facebook_instance();
    
    $this->get_user();

    $this->add_actions();
    $this->add_shortcodes();
	}

  function add_shortcodes(){
    add_shortcode('js2_facebook_registration_handler', array($this, 'check_for_data'));
  }

  function add_actions(){
    add_filter('js2_registration_form_print', array($this, 'registration_form'));
    add_action('after_body_tag', array($this, 'add_post_body_tag'));
  }

  function registration_form(){
    return $this->load->view('registration_form')->get_content();
  }

	function load_sdk(){
		$this->load->library('facebook-php-sdk/src/facebook');
	}

	function setup_facebook_instance(){

    $this->appID = '223837194395219';
    $this->secret = 'c0c89adb0898206a69527a0f920350c2';

		$this->instance = new Facebook(array(
			'appId'  => $this->appID,
			'secret' => $this->secret
		));
	}

	function get_user(){
		// Get User ID
		$this->user = $this->instance->getUser();

    if ($this->user) {
      try {
        // Proceed knowing you have a logged in user who's authenticated.
        $this->user_profile = $this->instance->api('/me');
      } catch (FacebookApiException $e) {
        error_log($e);
        $this->user = null;
      }
    }

    return $this;
	}

	function get_logInOut(){
    // Login or logout url will be needed depending on current user state.
    if ($this->user) {
      return $this->instance->getLogoutUrl();
    } else {
      return $this->instance->getLoginUrl();
    }
	}

  function check_for_data(){
    if ($_REQUEST) {
      $response = (isset($_REQUEST['signed_request']))?$this->parse_signed_request($_REQUEST['signed_request'], 
                                       $this->secret):'';
      $this->save_fb_info_to_db($response);
    }
  }

  function save_fb_info_to_db($response){

    $username = $response['registration']['name'];
    $password = $response['registration']['password'];
    $email = $response['registration']['email'];

    $nationality = $response['registration']['nationality']['name'];
    $residence = $response['registration']['residence']['name'];
    $programme = $response['registration']['programme'];
    $network = $response['registration']['network'];

    $user_id = wp_create_user( $username, $password, $email );

    if(is_wp_error($user_id)){
      switch ($user_id->get_error_code()) {
        case 'existing_user_login':
          echo('This email is already used.');
          break;
        case 'empty_user_login':
          echo('You need to provide an email.');
          break;
        case 'existing_user_email':
          echo('This email is already used.');
          break;

        default: 
          echo('ERROR');
          break;
      };
      return;
    }

    update_user_meta($user_id, 'nationality', $nationality);
    update_user_meta($user_id, 'residence', $residence);
    update_user_meta($user_id, 'programme', $programme);
    update_user_meta($user_id, 'network', $network);

    update_user_meta($user_id, 'fb_registration', $response);

    return $user_id;

  }

  function parse_signed_request($signed_request, $secret) {
    list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

    // decode the data
    $sig = $this->base64_url_decode($encoded_sig);
    $data = json_decode($this->base64_url_decode($payload), true);

    if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
      error_log('Unknown algorithm. Expected HMAC-SHA256');
      return null;
    }

    // check sig
    $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
    if ($sig !== $expected_sig) {
      error_log('Bad Signed JSON signature!');
      return null;
    }

    return $data;
  }

  function base64_url_decode($input) {
      return base64_decode(strtr($input, '-_', '+/'));
  }

	function test_instance(){
		
    $this->get_user();
    $logInOut = $this->get_logInOut();
    echo "<pre>";
    print_r($this->user_profile);
    print_r($_SESSION);
    echo "</pre>";

	}

  function add_post_body_tag(){
    ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fo_FO/all.js#xfbml=1&appId=APP_ID";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <?php
  }

}
global $js2_facebook;
$js2_facebook = new JS2_Facebook();