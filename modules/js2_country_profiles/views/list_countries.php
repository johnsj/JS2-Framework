
<table id="js2_countries_table">
  <thead>
    <tr>
      <th width="30px"></th>
      <th>Country</th>
      <th style="text-align:right;">Students reached</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($countries as $country) : ?>
    <tr>
      <td valign="middle"> <img class="flag flag-<?php echo $country->code;?>" src="<?php echo plugin_dir_url(__FILE__) . "../assets/img/1x1-pixel.png"?>" alt="<?php echo $country->name?>"> </td>
      <td valign="middle"><?php echo $country->name?></td>
      <td valign="middle"><?php echo $country->students?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>