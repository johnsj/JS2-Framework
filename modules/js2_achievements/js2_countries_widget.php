<?php


class JS2_top5countries_Widget extends WP_Widget 
{

  function __construct(){

    $widget_options = array(
      'classname' => 'JS2_top5countries_widget',
      'description' => 'Displays the top five countries on the Achievement leaderboard.'
    );

    $this->WP_Widget('JS2_top5countries_Widget', "JS2 Country Top 5", $widget_options);

  }

  function form($instance){

    $defaults = array(
      'title' => 'Top Five Countries:'
    );

    $instance = wp_parse_args((array) $instance, $defaults);
    $title = $instance['title'];
    $data['title'] = $title;
    $data['context'] = $this;

    echo $this->_view('top5countries-admin', $data);

  }

  function update( $new_instance, $old_instance ){
    $instance = array();
    $instance['title'] = strip_tags( $new_instance['title'] );
    return $instance;
  }

  function widget($args, $instance){
    extract($args);
    echo $before_widget;

    $data['countries'] = $this->_get_top5_countries();
    $data['widget_title'] = apply_filters('widget_title', $instance['title'] );

    echo $this->_view('top5countries',$data);

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

  private function _get_top5_countries(){
    global $wpdb;

    $sql = "
    SELECT " . $wpdb->prefix . "usermeta.meta_value as country, sum(" . $wpdb->prefix . "js2_achievements.students) as student_sum
    FROM " . $wpdb->prefix . "usermeta
    Left join " . $wpdb->prefix . "js2_achievements on " . $wpdb->prefix . "usermeta.user_id = " . $wpdb->prefix . "js2_achievements.user_id
    where " . $wpdb->prefix . "usermeta.meta_key = \"residence\"
    group by " . $wpdb->prefix . "usermeta.meta_value
    order by student_sum DESC
    LIMIT 5
    "
    ;

    return $wpdb->get_results($sql);

  }
}


add_action('widgets_init', 'JS2_top5countries_widget_init');
function JS2_top5countries_widget_init(){
  return register_widget('JS2_top5countries_Widget');
}