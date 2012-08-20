<?php

/**
* 
*/
class JS2_Country_Profiles extends JS2_Controller
{
  
  function __construct()
  {
    # code...
    parent::__construct();

    $this->add_shortcodes();
    $this->add_styles();
  }

  function add_shortcodes(){
    add_shortcode('js2_countries_list', array($this, 'show_countries'));
  }

  function show_countries(){
    $data['countries'] = $this->load->model('countries')->get_students_per_country();

    $this->load->view('list_countries',$data)->display();
  }

  function add_styles(){

    add_action('wp_enqueue_scripts', array($this,'register_the_style'));
  }

  function register_the_style(){
    $cssfolder = plugin_dir_url(__FILE__) . "assets/css/";

    $filename = 'flags';

    $path = $cssfolder . $filename . ".css";
    
      wp_register_style('JS2_country_profile_style', $path);
      wp_enqueue_style('JS2_country_profile_style');
  }
}

$JS2_Country_Profiles = new JS2_Country_Profiles();