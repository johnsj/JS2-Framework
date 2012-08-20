<div class="wrap">
        <div class="icon32" id="icon-edit-pages"> <br/> </div>
        <h2>View Achievement</h2>
        <form method="post" action="<?php echo add_query_arg(array('action' => 'do_delete'))?>">
        <table class="widefat">
            <?php foreach ($records as $current_record) :?>
            <tr>
                <td><strong>User: </strong><?php 
                    $current_user = get_userdata($current_record->user_id);

                    echo $current_user->user_email;
                ?></td>
                <td><strong>Date: </strong><?php 
                    echo $current_record->presentation_date;
                ?></td>
                <td><strong>Event: </strong><?php 
                    echo $current_record->location;
                ?></td>
                <td><strong>Students: </strong><?php 
                    echo $current_record->students;
                ?></td>
            </tr>
            <tr class="alternate">
                <td colspan="4"><strong>More: </strong><br><?php 
                    echo $current_record->more;
                ?></td>
            </tr>
            <tr>
                <td colspan="4">
                    <a href="<?php echo $current_record->image_url;?>">
                        <img width="400" src="<?php echo $current_record->image_url;?>">
                    </a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
        <input type="submit" value="Delete">
        </form>
        <a href="<?php echo admin_url("admin.php?page=js2_achievements");?>">Back</a>
    </div>