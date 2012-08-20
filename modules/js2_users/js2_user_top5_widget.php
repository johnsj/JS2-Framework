<?php


class JS2_User_top5_Widget extends WP_Widget 
{

  function __construct(){

    $widget_options = array(
      'classname' => 'JS2_User_top5user_widget',
      'description' => 'Displays the top five users on the Achievement leaderboard.'
    );

    $this->WP_Widget('JS2_User_top5user_Widget', "JS2 User Top 5", $widget_options);


    add_action('wp_enqueue_scripts', array($this, 'register_the_style'));

  }

  function register_the_style(){
    $cssfolder = plugin_dir_url(__FILE__) . "assets/css/";

    $filename = 'style';

    $path = $cssfolder . $filename . ".css";
    
      wp_register_style('JS2_User_style', $path);
      wp_enqueue_style('JS2_User_style');
  }

  function form($instance){

    $defaults = array(
      'title' => 'Top Five Users:'
    );

    $instance = wp_parse_args((array) $instance, $defaults);
    $title = $instance['title'];
    $data['title'] = $title;
    $data['context'] = $this;

    echo $this->_admin_view('user_top5', $data);

  }

  function update( $new_instance, $old_instance ){
    $instance = array();
    $instance['title'] = strip_tags( $new_instance['title'] );
    return $instance;
  }

  function widget($args, $instance){


    extract($args);
    echo $before_widget;

    $data['users'] = $this->_get_top5_users();
    $data['widget_title'] = apply_filters('widget_title', $instance['title'] );

    echo $this->_view('user_top5',$data);

    echo $after_widget;
  }


  private function _view( $view_name, $data = array() ){
    ob_start();

    if( !empty( $data ) ){
      extract( $data );
    }

    include plugin_dir_path(__FILE__) . "views/" . $view_name . ".php";

    $view_content = ob_get_clean();

    return $view_content;
  }

  private function _admin_view( $view_name, $data = array() ){
    ob_start();

    if( !empty( $data ) ){
      extract( $data );
    }

    include plugin_dir_path(__FILE__) . "admin_views/" . $view_name . ".php";

    $view_content = ob_get_clean();

    return $view_content;
  }

  private function _get_top5_users(){
    global $wpdb;

    $query = "
      SELECT    user_id, SUM(students) as student_sum
      FROM " . $wpdb->prefix . "js2_achievements
      GROUP BY  user_id
      ORDER BY  student_sum DESC
      LIMIT     5
    ";

    return $wpdb->get_results($query);

  }
}


add_action('widgets_init', 'JS2_user_top5_widget_init');
function JS2_user_top5_widget_init(){
  return register_widget('JS2_User_top5_Widget');
}