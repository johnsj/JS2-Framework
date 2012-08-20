<h3 class="widgettitle"><?php echo $widget_title;?></h3>
<ol class="js2_topfive">
<?php 

foreach ($countries as $country) {
  # code...
  echo "<li>";
  echo "<div class=\"js2_topfive_wrap\">";
  echo "<span class=\"js2_topfive_name\">";
  echo $country->country;
  echo "</span>";
  echo "<span class=\"js2_topfive_sum\">";
  echo $country->student_sum;
  echo "</span>";
  echo "</div>";
  echo "</li>";
}

?>
</ol>
