<div class="wrap">
  <div class="icon32" id="icon-users"></div>
  <h2>Achievements</h2>
  <?php
    if (isset($delete_complete) && $delete_complete !== false) {
      ?> <h3>Records deleted</h3> <?php
    }
  ?>
  <form method='post'>
  <?php
    $datatable->prepare_items();
    $datatable->display();
  ?>
  </form>
</div>

