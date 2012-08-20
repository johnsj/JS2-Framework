<div class="go_back"><a href="<?php echo add_query_arg(array('edit' => 'true'))?>">Edit</a></div>
<?php
$user = get_userdata($user_id);
?>
<div class="achievement_profile">
  <div class="achievement_profile_img">
    <?php echo get_avatar($user_id, $size = 128, $default = '', $alt = $user->first_name . " " . $user->last_name)?>
  </div>
  <div class="achievement_profile_info">
    <table class="achievement_profile_table">
      <tr>
        <th>Name</th>
        <td><?php echo esc_html( $user->first_name ) ?></td>
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
    <?php 
    foreach ($badges->get_badges_img_paths() as $badge) {?>
    <li><img src="<?php echo $badge;?>" alt=""></li>
    <?php }

    if(count($badges->get_badges_img_paths() ) == 0){?>
    <li>No badges achieved! Go inspire people to get badges!!</li>
    <?php }
    ?>
  </ul>
</div>
<div class="races">
  <pre>
    <?php print_r($races_output);?>
  </pre>
</div>