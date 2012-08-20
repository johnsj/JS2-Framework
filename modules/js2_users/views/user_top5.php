<h3 class="widgettitle"><?php echo $widget_title;?></h3>
<ol class="js2_topfive">
<?php 

foreach ($users as $user) {
  # code...
  $current_user = get_user_by('id', $user->user_id);
  echo "<li>";
  echo "<div class=\"js2_topfive_wrap\">";
  echo "<span class=\"js2_topfive_name\">";
  echo $current_user->first_name;
  echo "</span>";
  echo "<span class=\"js2_topfive_sum\">";
  echo $user->student_sum;
  echo "</span>";
  echo "</div>";
  echo "</li>";
}

?>
</ol>
