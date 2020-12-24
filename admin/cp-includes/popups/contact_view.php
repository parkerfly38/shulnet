<?php


if (empty($_POST['id'])) {
    $admin->show_popup_error('No contact selected.');

} else {
    $contact = new contact;
    $data    = $contact->get_contact($_POST['id']);
    $qz      = $db->get_eav_value('options', 'contact_quick_view');

    ?>



    <div id="popupsave">

        <input type="button" value="View Full Profile" class="save"
               onclick="return load_page('contact','view','<?php echo $_POST['id']; ?>');"/>

    </div>

    <h1>Contact Card</h1>

    <div class="popupbody">
        <div class="pad">
            <dl class="horizontal">

                <?php

                $sp = new special_fields('contact');

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
        </div>
    </div>



<?php

}

?>