<table id="achievers_list">
  <thead>
    <tr>
      <th style="text-align:left; padding-left:56px;">Achiever</th>
      <th>Badge</th>
      <th style="text-align:right;">Students reached</th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($achievements as $achievement) :

  $user = get_userdata($achievement->user_id);

  $user_display = ($user->first_name !== "") ? $user->first_name . " " . $user->last_name : $user->user_email;
?>
<tr>
  <td>
    <a href="<?php echo add_query_arg(array('user_id' => $user->ID));?>">
      <div>    
        <div style="vertical-align:top; float:left; padding: 0px 5px; margin:0px">
          <?php echo get_avatar($user->ID, $size = '48', $default = '', $alt = $user->first_name . " " . $user->last_name)?>
          <?php echo $user_display?>
        </div>
      </div>
    </a>
  </td>
  <td align="center" style="vertical-align:middle;"><?php //echo $user->user_email;
        $b = new JS2_User_Badges($user);
        $b_badge = $b->get_badges_img_paths();
        if( isset( $b_badge[0] ) )
          echo "<img width=50px src=" . $b_badge[0] . " alt=\"\">";
      ?></td>
  <td style="text-align:right;"><?php echo $achievement->students;?></td>
</tr>
<?php endforeach;?>
  </tbody>
</table>