<?php

/**
* 
*/
class JS2_Achievement_Widget extends WP_Widget
{
  
  function JS2_Achievement_Widget()
  {
    $widget_options = array(
      'classname' => 'JS2_achievement_widget',
      'description' => 'Displays the currently reached amount of students.'
    );

    $this->WP_Widget('JS2_Achievement_Widget','JS2 Achievements', $widget_options);
  }

  function form($instance){
    
    $defaults = array(
      'title' => 'Students Reached:'
    );

    $instance = wp_parse_args( (array) $instance, $defaults );
    $title = $instance['title'];
    $data['title'] = $title;

    $this->view('widget-admin', $data, $this);

  }

  function update($new_instance, $old_instance){
    //No updates required
  }

  function widget($args, $instance){
    extract($args);
    echo $before_widget;

    $data['students'] = $this->get_students_reached();

    echo $this->view('widget-show', $data);

    echo $after_widget;
  }


  function get_students_reached(){
    global $wpdb;

    $sql = "SELECT SUM(students) FROM " . $wpdb->prefix . "js2_achievements";

    return $wpdb->get_var($sql);
  }

  function view($view_name, $data = array(), $thiz = null){

    if(!empty($data)){
      extract($data);
    }

    include plugin_dir_path(__FILE__) . "views/" . $view_name . ".php";
  }
}

add_action('widgets_init', 'JS2_achievement_widget_init');
function JS2_achievement_widget_init(){
  return register_widget('JS2_Achievement_Widget');
}