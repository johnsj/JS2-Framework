<?php 
global $input_variables;
?>
<form action="" method="post">
      <table class="js2_form">
        <tr>
          <td>
            <label for="first_name">First Name</label>
            <span class="js2_required">*</span>
          </td>
          <td>
            <input type="text" name="first_name" id="first_name" value="<?php echo $input_variables['input_first_name']?>">
          </td>
        </tr>
        <tr>
          <td>
            <label for="last_name">Last Name</label>
            <span class="js2_required">*</span>
          </td>
          <td>
            <input type="text" name="last_name" id="last_name" value="">
          </td>
        </tr>
        <tr>
          <td>
            <label for="nationality">Nationality</label>
            <span class="js2_required">*</span>
          </td>
          <td>
            <?php echo js2_helper_get_select_countries('nationality');?>
          </td>
        </tr>
        <tr>
          <td>
            <label for="residence">Current Country of Residence</label>
            <span class="js2_required">*</span>
          </td>
          <td>
            <?php echo js2_helper_get_select_countries('residence');?>
          </td>
        </tr>
        <tr>
          <td>
            <label for="programme">Which JA-YE programme have you participated in?</label>
            <span class="js2_required">*</span>
          </td>
          <td>
            <input type="text" name="programme" id="programme" value="">
          </td>
        </tr>
        <tr>
          <td>
            <label for="network">Are you part of a JA-YE Alumni network?</label>
            <span class="js2_required">*</span>
          </td>
          <td>
            <select name="network" id="network">
              <option value="no" selected="selected">No</option>
              <option value="yes">Yes</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <label for="jayerole">If yes what is your role?</label>
          </td>
          <td>
            <textarea name="jayerole" id="jayerole"></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <label for="email">Email</label>
            <span class="js2_required">*</span>
          </td>
          <td>
            <input type="text" name="email" id="email" value="">
          </td>
        </tr>
        <tr>
          <td>
            <label for="password">Password</label>
            <span class="js2_required">*</span>
          </td>
          <td>
            <input type="password" name="password" id="password">
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" value="Register">
          </td>
        </tr>
      </table>
      <?php wp_nonce_field( 'js2_form_registration' , 'js2_form_registration_nonce' )?>
    </form>