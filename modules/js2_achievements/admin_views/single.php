<div class="wrap">
  <div class="icon32" id="icon-edit-pages"> <br/> </div>
  <h2>View Achievement</h2>
  <table class="widefat">
    <tr>
      <td><strong>User: </strong><?php 
          $current_user = get_userdata($record->user_id);

          echo $current_user->user_email;
      ?></td>
      <td><strong>Date: </strong><?php 
          echo $record->presentation_date;
      ?></td>
      <td><strong>Event: </strong><?php 
          echo $record->location;
      ?></td>
      <td><strong>Students: </strong><?php 
          echo $record->students;
      ?></td>
    </tr>
    <tr class="alternate">
      <td colspan="4"><strong>More: </strong><br><?php 
          echo $record->more;
      ?></td>
    </tr>
    <tr>
      <td colspan="4">
        <a href="<?php echo $record->image_url;?>">
          <img width="400" src="<?php echo $record->image_url;?>">
        </a>
      </td>
    </tr>
  </table>
  <a href="<?php echo admin_url("admin.php?page=js2_achievements");?>">Back</a>
</div>