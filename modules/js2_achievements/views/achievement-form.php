<?php

$location = (isset($_POST['location']))?$_POST['location']:"";
$date = (isset($_POST['date']))?$_POST['date']:"";
$students = (isset($_POST['students']))?$_POST['students']:"";
$more = (isset($_POST['more']))?$_POST['more']:"";

?>
<div class="achievement_form">
<h2>Submit a presentation</h2>
<h3>About your achievement</h3>
    <form action="" method="post" enctype="multipart/form-data">
      <table class="js2_form">
        <tr>
          <td>
            <label for="image">Upload Pictures, e.g. of the audience? (Max size 1MB)</label>
            <span class="js2_required">*</span>
          </td>
          <td>
            <input type="file" name="image" id="image">
          </td>
        </tr>
        <tr>
          <td>
            <label for="location">Name of School or event</label>
            <span class="js2_required">*</span>
          </td>
          <td>
            <input type="text" name="location" id="location" value="<?php echo $location;?>">
          </td>
        </tr>
        <tr>
          <td>
            <label for="date">Date (dd-mm-yy)</label>
            <span class="js2_required">*</span>
          </td>
          <td>
            <input type="text" name="date" id="date" value="<?php echo $date;?>">
          </td>
        </tr>
        <tr>
          <td>
            <label for="students">Number of students reached</label>
            <span class="js2_required">*</span>
          </td>
          <td>
            <input type="text" name="students" id="students" value="<?php echo $students;?>">
          </td>
        </tr>
        <tr>
          <td>
            <label for="video">Upload Video (Max 10MB)</label>
          </td>
          <td>
            <input type="file" name="video" id="video">
          </td>
        </tr>
        <tr>
          <td>
            <label for="more">Tell us more</label>
          </td>
          <td>
            <textarea name="more" id="more" cols="30" rows="10"><?php echo $more;?></textarea>
          </td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" value="Submit Achievement"></td>
        </tr>
      </table>
      <?php wp_nonce_field( 'js2_form_achievement' , 'js2_form_achievement_nonce' )?>
    </form>
</div>