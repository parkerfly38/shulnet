<?php

   
if (empty($_POST['id'])) {
    $admin->show_popup_error('No member selected.');
} else {
    $user = new user;
    $data = $user->get_user($_POST['id']);
    $qz   = $db->get_eav_value('options', 'member_quick_view');
    ?>

    <div id="popupsave">
        <input type="submit" value="View Full Profile" class="save"
               onclick="return load_page('member','view','<?php echo $_POST['id']; ?>');"/>
    </div>
    <h1>Member Card</h1>

    <div class="popupbody">
        <div class="pad">

        <dl class="horizontal">
            <?php
            $sp = new special_fields('member');
            $fields = explode(',', $qz);
            foreach ($fields as $item) {
                $sp->update_row($item);
                $return = $sp->process($item, $data['data'][$item]);
                $name   = $sp->clean_name($item);
                echo "
                    <dt>" . $name . "</dt>
                    <dd>" . $return . "</dd>
                ";
            }
            ?>
        </dl>
        <div class="clear"></div>
        </div>
    </div>

<?php
}
?>