<?php 


$error = '0';
$owner = '1';
$admin = new admin;
$notes = new notes;
if (! empty($_POST['id'])) {
    $editing             = '1';
    $data                = new stdClass;
    $data->final_content = $notes->get_note($_POST['id']);
    // $data = new history($_POST['id'],'','','','','','ppSD_notes');
    $date       = $data->final_content['date'];
    $final_user = $data->final_content['user_id'];
    $deadline   = $data->final_content['deadline'];
    $item_scope = $data->final_content['item_scope'];
    $value      = $data->final_content['value'];
    $for        = $data->final_content['for'];
    $flabel     = $data->final_content['label'];
    $completed  = $data->final_content['complete'];
    $encrypt    = $data->final_content['encrypt'];
    $pin        = $data->final_content['pin'];
    $pipeline   = $data->final_content['type'];

    if (!empty($data->final_content['for'])) {
        if ($employee['id'] != $data->final_content['for'] && $employee['permissions']['admin'] != '1' && $data->final_content['added_by'] != $employee['id']) {
            $error = '1';
        } else {
            $emp      = $admin->get_employee('', $data->final_content['for']);
            $for_name = $emp['username'];
        }
        if ($employee['id'] != $data->final_content['added_by'] && $data->final_content['public'] != '1') {
            $owner = '0';
        }
    } else {
        $for_name = '';
    }
    $cid = $_POST['id'];
} else {
    $date      = current_date();
    $deadline  = '';
    $completed = '0';
    $editing   = '0';
    $value     = '0.00';
    $flabel    = '2';
    $pipeline = 'Contact';
    $for       = '';
    $for_name  = '';
    $encrypt   = '0';
    $pin       = '0';

    if (!empty($_POST['scope'])) {
        $item_scope = $_POST['scope'];
    } else {
        $item_scope = '';
    }
    if (!empty($_POST['user_id'])) {
        $final_user = $_POST['user_id'];
    } else {
        $final_user = '';
    }
    $cid = generate_id('random', '30');
}
if ($error == '1') {
    echo "You cannot view this note.";
} else {
    ?>



    <script type="text/javascript">

        $.ctrl('S', function () {
            return json_add('note-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
        });

    </script>



    <form action="" method="post" id="popupform"
          onsubmit="return json_add('note-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');"
          enctype="multipart/form-data">


    <div id="popupsave">


        <?php

        if ($deadline != '1920-01-01 00:01:01' && !empty($deadline)) {
            if ($completed == '1') {
                ?>



                <input type="submit" value="Mark Incomplete"
                       onclick="return json_add('note_complete','<?php echo $cid; ?>','1','skip','complete=0');"/>



            <?php

            } else {
                ?>

                <input type="submit" value="Mark Complete"
                       onclick="return json_add('note_complete','<?php echo $cid; ?>','1','skip','complete=1');"/>

            <?php

            }

        }

        if ($editing == '1') {
            ?>

            <button type="button"
                    onclick="return window.open('<?php echo PP_URL . '/admin/cp-includes/print/note.php?id=' . $cid; ?>','','width=980px,height=600px');">
                <img src="imgs/icon-print.png" width="16" height="16" border="0" alt="Print" title="Print"/> Print
            </button>

        <?php

        }

        ?>

        <input type="submit" value="Save" class="save"/>

        <input type="hidden" name="user_id" value="<?php echo $final_user; ?>"/>

        <input type="hidden" name="item_scope" value="<?php echo $item_scope; ?>"/>

    </div>


    <h1 class="noLinkColors">
        Adding Note

        <?php
        if (!empty($final_user)) {
            $note_user = $notes->get_note_user($final_user, $item_scope);
            echo ' for ' . $note_user['type'] . ' ' . $note_user['link'];
        }
        ?>
    </h1>

    <div class="popupbody">


    <ul id="theStepList">

        <li class="on" onclick="return goToStep('0');">Note</li>

        <li onclick="return goToStep('1');">Attachments</li>

    </ul>


    <div class="pad24t">

    <ul id="formlist">

    <li class="form_step">


    <div class="col25l noBorder">

    <fieldset>

        <legend>Overview</legend>

        <div class="notePad">

            <div class="field">

                <label class="less">Date</label>

                <div class="field_entry_less">

                    <?php


                    echo $af
                        ->setSpecialType('datetime')
                        ->setValue($date)
                        ->string('date');

                    // echo $admin->datepicker('date', $date, '1', '100%');

                    ?>

                </div>

            </div>


            <div class="field">
                <label class="less">Deadline</label>
                <div class="field_entry_less">
                    <?php

                    echo $af
                        ->setSpecialType('datetime')
                        ->setValue($deadline)
                        ->string('deadline');

                    //echo $admin->datepicker('deadline', $deadline, '1', '100%');

                    ?>
                </div>
            </div>

            <?php
            if ($deadline != '1920-01-01 00:01:01' && $editing == '1') {
            ?>

                <p style="margin-top:-32px;margin-bottom: 32px;padding-left:16px;border-left: 12px solid #f1f1f1;">
                    <b>Status: </b><?php echo $data->final_content['show_status'] ?><br />
                    <b>Completed On: </b><?php echo $data->final_content['show_complete_on']; ?><br />
                    <b>Completed By: </b><?php echo $data->final_content['show_complete_by']; ?>
                </p>

            <?php
            }
            ?>

            <?php
            if ($item_scope == 'contact') {
                ?>
                <div class="field" style="margin-bottom:32px;">
                    <label class="top">Next Required Action Date</label>
                    <div class="field_entry_top">
                        <input type="checkbox" name="update_next_action" value="1"/> Update "Next Action" date for this
                        user.<br/>
                    </div>
                </div>

                <div class="field" style="margin-bottom:32px;">
                    <label class="top">Pipeline</label>
                    <div class="field_entry_top">
                        <input type="radio" name="advance_pipeline" value="0" checked="checked" /> No pipeline change.<br />
                        <input type="radio" name="advance_pipeline" value="1" /> Advance contact in pipeline.<br />
                        <input type="radio" name="advance_pipeline" value="-1" /> Downgrade contact in pipeline.
                    </div>
                </div>
            <?php
            }
            ?>


            <div class="field">
                <label class="less">Encryption</label>
                <div class="field_entry_less">
                    <input type="radio" name="encrypt" value="1" <?php if ($encrypt == '1') { echo " checked=\"checked\""; } ?> /> Encrypt this note.<br />
                    <input type="radio" name="encrypt" value="0" <?php if ($encrypt != '1') { echo " checked=\"checked\""; } ?> /> Do NOT encrypt this note.<br />
                </div>
            </div>


        </div>

    </fieldset>




    </div>

    <div class="col25c noBorder">

        <fieldset>
            <legend>Label and Display</legend>

            <div class="pad24t">

            <div class="field">
                <label class="less">Label</label>
                <div class="field_entry_less">
                    <select name="label">
                        <?php
                        echo $admin->get_note_labels($flabel);
                        ?>
                    </select>
                </div>
            </div>

            <div class="field" style="margin-bottom:32px;">
                <label class="less">Pin Note?</label>
                <div class="field_entry_less">
                    <input type="radio" name="pin" value="1" <?php if ($pin == '1') { echo " checked=\"checked\""; } ?> /> Pin note to member/contact/item.<br />
                    <input type="radio" name="pin" value="2" <?php if ($pin == '2') { echo " checked=\"checked\""; } ?> /> Pin note to dashboard homepage.<br />
                    <input type="radio" name="pin" value="0" <?php if ($pin == '0') { echo " checked=\"checked\""; } ?> /> Do not pin note.<br />
                </div>
            </div>


            <div class="field">
                <label class="less">Value</label>
                <div class="field_entry_less">
                    <?php
                    echo place_currency('<input type="text" name="value" value="' . $value . '" style="width:100px;" maxlength="10" />', '1');
                    ?>
                </div>
            </div>


                <div class="field">
                    <label class="top">Note Accessibility</label>
                    <div class="field_entry_top">
                        <?php
                        if (! empty($data->{'final_content'}['public'])) {
                            ?>

                            <input type="radio" name="public" value="1"
                                   onclick="return hide_div('find_employee');" <?php if ($data->{'final_content'}['public'] == '1') {
                                echo " checked=\"checked\"";
                            } ?> /> Public: all staff can view this.<br/>

                            <input type="radio" name="public" value="2"
                                   onclick="return hide_div('find_employee');" <?php if ($data->{'final_content'}['public'] == '2') {
                                echo " checked=\"checked\"";
                            } ?> /> Broadcast: Display this note on staff feeds.<br/>

                            <input type="radio" name="public" value="3"
                                   onclick="return show_div('find_employee');" <?php if ($data->{'final_content'}['public'] == '3') {
                                echo " checked=\"checked\"";
                            } ?> /> Specific Employee.<br/>

                            <input type="radio" name="public" value="0"
                                   onclick="return hide_div('find_employee');" <?php if ($data->{'final_content'}['public'] == '0') {
                                echo " checked=\"checked\"";
                            } ?> /> Private: for my eyes only<br/>

                        <?php

                        } else {

                            ?>

                            <input type="radio" name="public" value="1"
                                   onclick="return hide_div('find_employee');"/> Public: all staff can view this.<br/>

                            <input type="radio" name="public" value="2"
                                   onclick="return hide_div('find_employee');"/> Broadcast: Display this note on staff feeds.
                            <br/>

                            <input type="radio" name="public" value="3"
                                   onclick="return show_div('find_employee');"/> Specific Employee.<br/>

                            <input type="radio" name="public" value="0" onclick="return hide_div('find_employee');"
                                   checked="checked"/> Private: for my eyes only<br/>

                        <?php
                        }
                        ?>

                    </div>

                </div>

                <div class="field" id="find_employee" style="display:<?php
                if (!empty($data->final_content['public']) && $data->final_content['public'] == '3') {
                    echo "block";
                } else {
                    echo "none";
                }
                ?>;">

                    <label class="less">Employee</label>

                    <div class="field_entry_less">

                        <input type="text" id="ownerd" name="owner_dud"
                               autocomplete="off" onkeyup="return autocom(this.id,'id','username','ppSD_staff','username','staff');"
                               value="<?php echo $for_name; ?>" style="width:200px;"/><a href="null.php" onclick="return get_list('staff','ownerd_id','ownerd');"><img
                                src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"
                                title="Select from list" class="icon-right"/></a>

                        <input type="hidden" name="for" id="ownerd_id" value="<?php echo $for; ?>"/>

                        <p class="field_desc" id="owner_dud_dets">Input any employee for whom this note applies.</p>

                    </div>

                </div>

            </div>
        </fieldset>

    </div>

    <div class="col50r noBorder">


        <fieldset>

            <legend>Note Content</legend>

            <div class="pad24t">


                <div class="field">

                    <label class="less">Title</label>

                    <div class="field_entry_less">

                        <input type="text" name="name" value="<?php if (!empty($data->final_content['name'])) {
                            echo $data->final_content['name'];
                        } ?>" style="width:100%;" maxlength="85"/>

                    </div>

                </div>


                <div class="field">

                    <textarea name="note" class="richtext" id="123a"
                              style="width:100%;height:300px;"><?php
                        if (! empty($data->final_content['note'])) {
                            if ($encrypt == '1') {
                                $fdata = decode($data->final_content['note']);
                            } else {
                                $fdata = $data->final_content['note'];
                            }
                            echo $fdata;
                        }
                        ?></textarea>

                    <?php

                    echo $admin->richtext('100%', '300px', '123a', '0', '1');

                    ?>

                </div>


            </div>


        </fieldset>


    </div>

    <div class="clear"></div>


    </li>

    <li class="form_step">

        <div class="pad24t">


            <?php

            if (!empty($_POST['id'])) {
                ?>

                <fieldset>

                    <legend>Existing Files</legend>

                    <div class="pad24t">

                        <?php

                        $attach = $admin->get_note_attachments($_POST['id']);

                        echo $attach['data'];

                        ?>

                    </div>

                </fieldset>

            <?php

            }

            ?>



            <fieldset>

                <legend>Add New Files</legend>

                <div class="pad24t">


                    <div class="field">

                        <label class="top">Files</label>

                        <script type="text/javascript" src="js/jquery.fileuploader.js"></script>

                        <script type="text/javascript">

                            $(document).ready(function () {
                                var uploader = new qq.FileUploader({

                                    element: document.getElementById('fileuploader'),
                                    action: 'cp-functions/upload.php',
                                    debug: true,
                                    params: {

                                        type: '',
                                        id: '<?php echo $final_user; ?>',
                                        permission: 'upload-note',
                                        label: 'note_attachment',
                                        noteid: '<?php echo $cid; ?>',
                                        scope: '1' // 1 = admin cp only, 0 = user page as well
                                    }

                                });
                            });

                        </script>

                        <p>Drag and drop files here to attach them to this note.</p>

                        <div id="fileuploader">

                            <noscript><p>Please enable JavaScript to use file uploader.</p></noscript>

                        </div>

                    </div>


                </div>

            </fieldset>


        </div>

    </li>

    </ul>

    </div>

    <script src="js/form_rotator.js" type="text/javascript"></script>


    </div>


    </form>



<?php

}

?>