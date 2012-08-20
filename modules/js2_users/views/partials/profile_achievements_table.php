<div class="achievement_table">
  <div class="achievement_part">
    <span class="title">
      Achievements
    </span>
    <span class="students">
      <?php echo 'Reached a total of ' . $student_sum . ' students'?>
    </span>
  </div>

<?php foreach ($achievements as $achievement) :?>
<div class="achievement_part">
  <div class="achievement_img">
    <img width="150px" height="180px" src="<?php echo $achievement->image_url?>" />
  </div>
  <div class="achievement_data">
    <table class="achievement_info_table">
      <tr>
        <th>School/Event</th>
        <td>
          <?php echo $achievement->location ?>
        </td>
      </tr>
      <tr>
        <th>Date (yyyy/mm/dd)</th>
        <td>
          <?php echo $achievement->presentation_date ?>
        </td>
      </tr>
      <tr>
        <th>Number of students</th>
        <td>
          <?php echo $achievement->students?>
        </td>
      </tr>
      <tr>
        <th>More Information</th>
        <td><a href="<?php echo add_query_arg(array('achievement' => $achievement->recID))?>">Click here to read more!</a></td>
      </tr>
    </table>

  </div>
</div>
<?php endforeach;?>
</div>