<div class="go_back"><a href="<?php echo remove_query_arg('user_id', $query=false)?>">Back</a>
</div>
<?php
$user = get_userdata($user_id);
?>
<div class="achievement_profile">
  <div class="achievement_profile_img">
    <?php echo get_avatar($user_id, $size = '128', $default = '', $alt = $user->first_name . " " . $user->last_name)?>
  </div>
  <div class="achievement_profile_info">
    <table class="achievement_profile_table">
      <tr>
        <th>Name</th>
        <td><?php echo esc_html( $user->first_name . " " . $user->last_name )?></td>
      </tr>
      <tr>
        <th>Nationality</th>
        <td><?php echo esc_html( get_user_meta($user->ID, $meta_key = 'nationality', true) )?></td>
      </tr>
      <tr>
        <th>Residence</th>
        <td><?php echo esc_html( get_user_meta($user->ID, $meta_key = 'residence', true) )?></td>
      </tr>
      <tr>
        <th>Participated in</th>
        <td><?php echo esc_html( get_user_meta($user->ID, $meta_key = 'programme', true) )?></td>
      </tr>
      <?php if(get_user_meta($user->ID, $meta_key = 'network', true) == 'yes') :?>
      <tr>
        <th>- My role is</th>
        <td><?php echo esc_html( get_user_meta($user->ID, $meta_key = 'jayerole', true) )?></td>
      </tr>
      <?php endif;?>
    </table>
  </div>
</div>
<div class="badges">
  <hr/>
  <ul>
    <?php foreach ($badges->get_badges_img_paths() as $badge) {?>
    <li><img src="<?php echo $badge;?>" alt=""></li>
    <?php }?>
  </ul>
</div>
<?php if(is_user_logged_in() && (get_current_user_id() != $_GET['user_id'])) :?>
<div class="races">
  <hr/>
  <div#challenge>
    <?php 
      $queries = array();
      
      $queries["challenge"] = get_current_user_id();
      
    ?>
    <p>
      <strong>Up for a challenge?</strong><br>
      Let's see who first gets <select name="race_amount" id="race_amount">
        <option value="100">100</option>
        <option value="200">200</option>
        <option value="500">500</option>
        <option value="1000">1000</option>
      </select> students? <a class="thickbox button" id="js2_race_challenge" href="/wp-admin/admin-ajax.php?action=send_request&challenger=<?php echo get_current_user_id()?>&challengee=<?php echo $_GET['user_id']?>">Send challenge request</a>
    </p>
  </div>
</div>
<?php endif;?>
<?php echo $table_content?>