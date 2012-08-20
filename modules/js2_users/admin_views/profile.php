<h3><?php echo 'JA-YE specific user information'?></h3>
      <table class="form-table">
        <tr>
          <th>
            <label for="nationality">Nationality</label>
          </th>
          <td>
            <?php echo js2_helper_get_select_countries( "nationality" , esc_attr( get_user_meta( $user->ID, 'nationality', true ) )); ?>
            <span class="description"><?php _e('Please select you nationality here')?></span>
          </td>
        </tr>
        <tr>
          <th>
            <label for="residence">Residence</label>
          </th>
          <td>
            <?php echo js2_helper_get_select_countries( "residence" , esc_attr( get_user_meta( $user->ID, 'residence', true ) )); ?>
            <span class="description"><?php _e('Please select you residence here')?></span>
          </td>
        </tr>
        <tr>
          <th>
            <label for="programme">Attended Programme</label>
          </th>
          <td>
            <input type="text" name="programme" id="programme" value="<?php echo esc_attr( get_user_meta( $user->ID, 'programme', true ) )?>" class="regular-text"><br>
            <span class="description"><?php _e('Please input the JA-YE programme that you attended here (if applicable)')?></span>
          </td>
        </tr>
        <tr>
          <th>
            <label for="network">Part of the JA-YE Alumni network?</label>
          </th>
          <td>
            <select name="network" id="network">
              <?php switch (esc_attr( get_user_meta( $user->ID, 'network', true ) )) {
                case 'yes':
                ?>
                <option value="no">No</option>
                <option value="yes" selected="selected">Yes</option>
                <?php 
                break;
                
                default:
                ?>
                <option value="no" selected="selected">No</option>
                <option value="yes">Yes</option>
                <?php 
                break;
              }?>
            </select>
            <span class="description"><?php _e('Please enter you network name here')?></span>
          </td>
        </tr>
        <tr>
          <th>
            <label for="jayerole">JA-YE Role</label>
          </th>
          <td>
            <textarea name="jayerole" id="jayerole"><?php echo esc_attr( get_user_meta( $user->ID, 'jayerole', true ) );?></textarea><br>
            <span class="description"><?php _e('Please enter you role at JA-YE here')?></span>
          </td>
        </tr>
      </table>