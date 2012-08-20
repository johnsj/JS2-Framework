<?php
require_once ABSPATH . '/wp-admin/includes/upgrade.php';
/**
* 
*/
class JS2_Races extends JS2_Controller
{
  var $DB_version = "1.0";
  var $current_race = null;

  function __construct()
  {
    parent::__construct("js2_users");

    $this->add_javascript();
  }

  function get_tableName()
  {
    global $wpdb;
    return $wpdb->prefix . "js2_races";
  }

  function create_db()
  {
    global $wpdb;
    $tableName = $this->get_tableName();

    $installed_db_version = get_option("js2_races_db_version");

    if( $installed_db_version == $this->DB_version ){
      return;
    }

    $sql = "CREATE TABLE `" . $this->get_tableName() . "` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user1_id` bigint(20) NOT NULL,
    `user2_id` bigint(20) NOT NULL,
    `amount` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `stage` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
    )";

    update_option("js2_races_db_version", $this->DB_version);

    dbDelta($sql);
  }

  function request_race($user1, $user2, $amount)
  {
    global $wpdb;

    $args = array(
        "user1_id" => $user1,
        "user2_id" => $user2,
        "amount"   => $amount,
        "stage"    => "request"
      );

    return $wpdb->insert( $this->get_tableName(), $args);
  }

  function accept_race($raceId)
  {
    global $wpdb;

    $args = array(
        "stage" => "running"
      );

    $where = array(
        "id" => $raceId
      );

    return $wpdb->update( $this->get_tableName(), $args , $where );
  }

  function remove_race($raceId)
  {
    global $wpdb;

    $sql = "
      DELETE from " . $this->get_tableName() . "
      WHERE id = %d
    ";

    return $wpdb->query( $wpdb->prepare($sql, $raceId) );
  }

  function get_race($raceId)
  {
    global $wpdb;

    $sql = "
      SELECT * FROM " . $this->get_tableName() . "
      WHERE id = %d
    ";

    $this->current_race = $wpdb->get_results( $wpdb->prepare( $sql, $raceId ) );

    return $this;
  }

  function get_races_by_user($user_id)
  {
    global $wpdb;

    $sql = "
      SELECT * FROM " . $this->get_tableName() . "
      WHERE user1_id = %d OR user2_id = %d
      ";

    return $wpdb->get_results( $wpdb->prepare( $sql, $user_id, $user_id ) );
  }

  function finish_race($raceId)
  {
    global $wpdb;

    $user_id = get_winner($raceId);

    $args = array(
        "stage" => "complete",
        "winner" => $user_id
      );

    $where = array(
      "id" => $raceId
      );

    return $wpdb->update($this->get_tableName, $args, $where);
  }

  function add_javascript()
  {
    add_action("wp_enqueue_scripts", array($this, "register_javascript"));
    add_action("wp_ajax_send_request",array($this, "send_request"));
  }

  function register_javascript()
  {
    wp_register_script("js2_races", plugin_dir_url(__FILE__) . "assets/js/js2_races.js", array(), false, true);
    wp_enqueue_script("js2_races");
    wp_enqueue_script('thickbox',null,array('jquery'));
    wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css');
  }

  function send_request()
  {
    $data['challenger'] = get_user_by('id', $_GET['challenger']);
    $data['challengee'] = get_user_by('id', $_GET['challengee']);

    $this->load->view("race_request", $data)->display();
    die();
  }

}