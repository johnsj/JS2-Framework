<h3><?php _e('Achievement Status');?></h3>

<table class="form-table">
  <tr>
    <th>Students reached</th>
    <td><?php echo (isset($query->students))?$query->students:"0" ?></td>
  </tr>
</table>