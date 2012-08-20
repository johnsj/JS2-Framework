<div class="go_back"><a href="<?php echo remove_query_arg('user_id', $query=false)?>">Back</a></div>
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
        <td><?php echo $user->first_name . " " . $user->last_name?></td>
      </tr>
      <tr>
        <th>Nationality</th>
        <td><?php echo get_user_meta($user->ID, $meta_key = 'nationality', true)?></td>
      </tr>
      <tr>
        <th>Residence</th>
        <td><?php echo get_user_meta($user->ID, $meta_key = 'residence', true)?></td>
      </tr>
      <tr>
        <th>Participated in</th>
        <td><?php echo get_user_meta($user->ID, $meta_key = 'programme', true)?></td>
      </tr><!--
      <tr>
        <th>Part of JA-YE Alumni network?</th>
        <td><?php echo ucfirst(get_user_meta($user->ID, $meta_key = 'network', true))?></td>
      </tr>-->
      <?php if(get_user_meta($user->ID, $meta_key = 'network', true) == 'yes') :?>
      <tr>
        <th>- My role is</th>
        <td><?php echo get_user_meta($user->ID, $meta_key = 'jayerole', true)?></td>
      </tr>
      <?php endif;?>
    </table>
  </div>
</div>
<div class="badges">
  <h2>Badges</h2>
  <ul>
    <?php foreach ($badges->get_badges_img_paths() as $badge) {?>
    <li><img src="<?php echo $badge;?>" alt=""></li>
    <?php }?>
  </ul>
</div>
<?php echo $table_content?>