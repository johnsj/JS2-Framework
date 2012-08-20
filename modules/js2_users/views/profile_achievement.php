<div class="go_back"><a href="<?php echo remove_query_arg('achievement', $query=false)?>">Back</a></div>
<div class="achievement_table">
  <div class="">
    <img id="achievement_img_single" src="<?php echo $current_achievement->image_url?>" alt="">
  </div>
  <div class="achievement_data_single">
    <table class="achievement_info_table">
        <tr>
          <th>School/Event</th>
          <td>
            <?php echo $current_achievement->location ?>
          </td>
        </tr>
        <tr>
          <th>Date</th>
          <td>
            <?php echo $current_achievement->presentation_date ?>
          </td>
        </tr>
        <tr>
          <th>Number of students</th>
          <td>
            <?php echo $current_achievement->students?>
          </td>
        </tr>
      </table>
  </div>
  <div class="achievement_more">
    <?php echo $current_achievement->more?>
  </div>
</div>