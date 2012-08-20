<?php
require_once ABSPATH . '/wp-admin/includes/file.php';
require_once ABSPATH . '/wp-admin/includes/upgrade.php';
require_once ABSPATH . '/wp-includes/user.php';

/**
* 
*/
class JS2_Achievements extends JS2_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->add_shortcodes();
    $this->add_styles();
    $this->add_actions();
  }

  function create_pages(){
    $this->create_main_page();
    $this->create_sub_pages();
  }

  function create_main_page(){
    add_menu_page(
      $this->page_title,            //Page Title
      'Achievements',               //Menu Title
      $this->admin_capability,      //Admin Capabilities
      $this->main_menu_slug,        //Main Menu Slug
      array($this, 'admin_main'));  //Main page function
  }

  function create_sub_pages(){

  }

  function add_styles(){
    

    add_action('wp_enqueue_scripts', array($this, 'register_the_style'));
  }

  function register_the_style($path){
$cssfolder = plugin_dir_url(__FILE__) . "assets/css/";

    $filename = 'profile';

    $path = $cssfolder . 'jquery-ui' . ".css";

    wp_register_style('jquery-ui', $path);
      wp_enqueue_style('jquery-ui');
  }

  function admin_main(){

    $model = $this->load->model('achievement');

    $items = $model->get_results_as_array();

    $table = $this->load->table('achievement', $items);

    switch ($table->current_action()) {
      case 'view':
        $recid = $_REQUEST['achievement'];

        $user = $model->get_achievement_by_recid($recid);

        $data['record'] = $user;

        $this->get_admin_page('single', $data)->display();
        break;

      case 'delete':
        $recids = $_REQUEST['achievement'];

        $records = $model->get_achievements_by_recids($recids);

        $data['records'] = $records;

        $this->get_admin_page('view-all', $data)->display();
        break;

      case 'do_delete':

        $recids = $_REQUEST['achievement'];

        $result = $model->delete_achievements($recids);

        $data['datatable'] = $table;
        $data['delete_complete'] = $result;

        $this->get_admin_page('main', $data)->display();
        break;
      
      default:
        $data['datatable'] = $table;

        $this->get_admin_page('main', $data)->display();
        break;
    }

  }


  //FROM OLD JS_ACHIEVEMENT

  function add_shortcodes(){
    add_shortcode('js2_achievement_form', array($this, 'achievement_form'));
    add_shortcode('js2_students_reached', array($this, 'sc_get_students_reached'));
  }

  function add_actions(){
    add_action('wp_enqueue_scripts', array($this, 'insert_achievement_header'));
    add_action('wp_footer', array($this, 'insert_achievement_footer'));
  }

  static function check_or_create_table(){
    global $wpdb;
    $table_name = $wpdb->prefix . "js2_achievements";

    $sql = "CREATE TABLE `alumni`.`" . $table_name . "` ( 
      `recID` int( 11 ) NOT NULL AUTO_INCREMENT ,
      `user_id` int( 11 ) NOT NULL ,
      `location` varchar( 255 ) NOT NULL ,
      `date_created` date NOT NULL ,
      `students` int( 11 ) NOT NULL ,
      `more` text,
      `image_url` varchar( 255 ) NOT NULL ,
      `image_file` varchar( 255 ) NOT NULL ,
      `video_url` varchar( 255 ) DEFAULT NULL ,
      `video_file` varchar( 255 ) DEFAULT NULL ,
      PRIMARY KEY ( `recID` ) 
      ) ;";

    dbDelta($sql);
  }

  function achievement_form(){
    if(is_user_logged_in()){
      if( isset( $_POST['js2_form_achievement_nonce'] ) && wp_verify_nonce($_POST['js2_form_achievement_nonce'], 'js2_form_achievement') ){
        return $this->achievement_form_handler();
      } else {
        return $this->load->view('achievement-form')->display();
      }
    } else {
      wp_redirect( home_url() );
    }
  }

  function insert_achievement_header(){
    wp_deregister_script('jquery');
    wp_deregister_script('jquery-ui');
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
    wp_register_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js');
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui');
  }

  function insert_achievement_footer(){
    ?>
      <script type="text/javascript">
        jQuery(document).ready(function () {
          jQuery('#date').datepicker({dateFormat: 'dd-mm-yy'});
        });
      </script>
    <?php
  }

  function achievement_form_handler(){
    
    if ( ! $this->is_valid() ) {
      return $this->load->view('achievement-form')->display();
    }

    $upload_result_image = wp_handle_upload( $_FILES['image'], $overrides = array( 'test_form' => false ) );
    $upload_result_video = wp_handle_upload( $_FILES['video'], $overrides = array( 'test_form' => false ) );

    $db_args = array(
      'user_id' => get_current_user_id(),
      'location' => $_POST['location'],
      'presentation_date' => date( "Y-m-d" , strtotime( $_POST['date'] ) ),
      'students' => $_POST['students'],
      'more' => $_POST['more'],
      'image_url' => $upload_result_image['url'],
      'image_file' => $upload_result_image['file'],
      'video_url' => (isset($upload_result_video['url']))?$upload_result_video['url']:null,
      'video_file' => (isset($upload_result_video['file']))?$upload_result_video['file']:null,
    );

    if ($this->save_to_db($db_args)) {
      return $this->load->view('achievement-submit-complete')->display();
    } else {
      
      return $this->load->view('achievement-submit-failed')->display();
    };
  }

  function is_valid(){
    $valid = true;

    if ($_FILES['image']['name'] == "") {
      $this->notice();
      $this->notice("No image was selected for upload.");
      $valid = false;
    }


    if($_POST['location'] == null || $_POST['location'] == ""){
      $this->notice("School or event not specified");
      $valid = false;
    }
    if($_POST['date'] == null || $_POST['date'] == ""){
      $this->notice("Date not specified");
      $valid = false;
    }
    if($_POST['students'] == null || $_POST['students'] == "" || $_POST['students'] < 1){
      $this->notice("Number of students reached not specified");
      $valid = false;
    }


    if($_FILES['image']['size'] > 1048576){
      $this->notice("Image size is larger than 1MB (1.048.576 bytes)");
      $valid = false;
    }
    if($_FILES['video']['size'] > 10485760){
      $this->notice("Video size is larger than 10MB (10.485.760 bytes");
      $valid = false;
    }

    return $valid;
  }

  function save_to_db($args){
    global $wpdb;

    $rows_affected = 0;



    $rows_affected = $wpdb->insert( $wpdb->prefix . "js2_achievements", $args );



    return $rows_affected;
  }

}

add_action('JS2_init_module', 'js2_achievement_init');

function js2_achievement_init(){
  global $JS2_Registry;

  $JS2_Achievements = new JS2_Achievements();

  $JS2_Achievements->page_title = "JS2 Achievements";
  $JS2_Achievements->admin_capability = 'activate_plugins';
  $JS2_Achievements->main_menu_slug = 'js2_achievements';

  add_action('admin_menu', array($JS2_Achievements, 'create_pages'));

}