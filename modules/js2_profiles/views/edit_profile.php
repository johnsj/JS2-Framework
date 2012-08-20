<div class="go_back"><a href="<?php echo remove_query_arg('edit', $query=false)?>">Back</a></div>
<?php
$user = get_userdata($user_id);
?>
<div class="achievement_profile">
  <div class="achievement_profile_img">
    <?php echo get_avatar($user_id, $size = '128', $default = '', $alt = $user->first_name . " " . $user->last_name)?>
    <a target="_blank" href="<?php home_url('/')?>wp-admin/admin-ajax.php?action=user_avatar_add_photo&step=1&uid=<?php echo $user_id?>&TB_iframe=true&width=720&height=450">Change photo</a>
  </div>
  <form method="POST" action="<?php echo add_query_arg(array('form_submit' => true))?>">
    <input type="hidden" name="user_id" value="<?php echo $user_id?>">
    
    <div class="achievement_profile_info">
      <table class="achievement_profile_table edit_profile">
        <tr>
          <th>Name</th>
          <td>
            <input class="edit_profile" type="text" value="<?php echo $user->first_name ?>" name="user_name">
          </td>
        </tr>
        <tr>
          <th>Nationality</th>
          <td>
            <?php echo js2_helper_get_select_countries('nationality', get_user_meta($user->ID, $meta_key = 'nationality', true) )?>
          </td>
        </tr>
        <tr>
          <th>Residence</th>
          <td>
            <?php echo js2_helper_get_select_countries('residence', get_user_meta($user->ID, $meta_key = 'residence', true) )?>
          </td>
        </tr>
        <tr>
          <th>Participated in</th>
          <td>
            <input type="text" class="edit_profile" name="programme" value="<?php echo get_user_meta($user->ID, $meta_key = 'programme', true)?>">
          </td>
        </tr>
        <tr>
          <th>Part of JA-YE Alumni network?</th>
          <td>
            <?php
            $selected_role = ""; 
              if(get_user_meta($user->ID, $meta_key = 'network', true) == 'yes'){
                $selected_role = "selected=\"selected\"";
              }
            ?>
            <select name="network">
              <option value="no">No</option>
              <option value="yes" <?php echo $selected_role?>>Yes</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>- My role is</th>
          <td>
            <textarea name="jayerole"><?php echo trim(get_user_meta($user->ID, $meta_key = 'jayerole', true))?>
            </textarea>
          </td>
        </tr>
      </table>
      <input type="submit" value="Update Profile">
      <input type="reset" value="Cancel">
    </div>
  
  </form>
</div>