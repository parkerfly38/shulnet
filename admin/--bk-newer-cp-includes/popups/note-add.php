<?php/** * * * Zenbership Membership Software * Copyright (C) 2013-2016 Castlamp, LLC * * This program is free software: you can redistribute it and/or modify * it under the terms of the GNU General Public License as published by * the Free Software Foundation, either version 3 of the License, or * (at your option) any later version. * * This program is distributed in the hope that it will be useful, * but WITHOUT ANY WARRANTY; without even the implied warranty of * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the * GNU General Public License for more details. * * You should have received a copy of the GNU General Public License * along with this program.  If not, see <http://www.gnu.org/licenses/>. * * @author      Castlamp * @link        http://www.castlamp.com/ * @link        http://www.zenbership.com/ * @copyright   (c) 2013-2016 Castlamp * @license     http://www.gnu.org/licenses/gpl-3.0.en.html * @project     Zenbership Membership Software */$error = '0';$owner = '1';$admin = new admin;$notes = new notes;if (! empty($_POST['id'])) {    $notes->mark_seen($_POST['id']);    $editing             = '1';    $data                = new stdClass;    $data->final_content = $notes->get_note($_POST['id']);    // $data = new history($_POST['id'],'','','','','','ppSD_notes');    $date       = $data->final_content['date'];    $final_user = $data->final_content['user_id'];    $deadline   = $data->final_content['deadline'];    $item_scope = $data->final_content['item_scope'];    $value      = $data->final_content['value'];    $for        = $data->final_content['for'];    $flabel     = $data->final_content['label'];    $completed  = $data->final_content['complete'];    $encrypt    = $data->final_content['encrypt'];    if (!empty($data->final_content['for'])) {        if ($employee['id'] != $data->final_content['for'] && $employee['permissions']['admin'] != '1' && $data->final_content['added_by'] != $employee['id']) {            $error = '1';        } else {            $emp      = $admin->get_employee('', $data->final_content['for']);            $for_name = $emp['username'];        }        if ($employee['id'] != $data->final_content['added_by'] && $data->final_content['public'] != '1') {            $owner = '0';        }    } else {        $for_name = '';    }    $cid = $_POST['id'];} else {    $date      = current_date();    $deadline  = '';    $completed = '0';    $editing   = '0';    $value     = '0.00';    $flabel    = '';    $for       = '';    $for_name  = '';    $encrypt   = '0';    if (!empty($_POST['scope'])) {        $item_scope = $_POST['scope'];    } else {        $item_scope = '';    }    if (!empty($_POST['user_id'])) {        $final_user = $_POST['user_id'];    } else {        $final_user = '';    }    $cid = generate_id('random', '30');}if ($error == '1') {    echo "You cannot view this note.";} else {    ?>    <script type="text/javascript">        $.ctrl('S', function () {            return json_add('note-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');        });    </script>    <form action="" method="post" id="popupform"          onsubmit="return json_add('note-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');"          enctype="multipart/form-data">    <div id="popupsave">        <?php        if ($deadline != '0000-00-00 00:00:00' && !empty($deadline)) {            if ($completed == '1') {                ?>                <input type="submit" value="Mark Incomplete"                       onclick="return json_add('note_complete','<?php echo $cid; ?>','1','skip','complete=0');"/>            <?php            } else {                ?>                <input type="submit" value="Mark Complete"                       onclick="return json_add('note_complete','<?php echo $cid; ?>','1','skip','complete=1');"/>            <?php            }        }        if ($editing == '1') {            ?>            <button type="button"                    onclick="return window.open('<?php echo PP_URL . '/admin/cp-includes/print/note.php?id=' . $cid; ?>','','width=980px,height=600px');">                <img src="imgs/icon-print.png" width="16" height="16" border="0" alt="Print" title="Print"/> Print            </button>        <?php        }        ?>        <input type="submit" value="Save" class="save"/>        <input type="hidden" name="user_id" value="<?php echo $final_user; ?>"/>        <input type="hidden" name="item_scope" value="<?php echo $item_scope; ?>"/>    </div>    <h1>Add Note</h1>    <div class="popupbody">    <ul id="theStepList">        <li class="on" onclick="return goToStep('0');">Note</li>        <li onclick="return goToStep('1');">Attachments</li>    </ul>    <div class="pad24t">    <ul id="formlist">    <li class="form_step">    <div class="col33">    <?php    if (!empty($final_user)) {        $note_user = $notes->get_note_user($final_user, $item_scope);        /*        if ($item_scope == 'member') {            $link = "<a href=\"returnnull.php\" onclick=\"return load_page('member','view','" . $final_user . "');\">$final_user</a>";            $type_show = 'Member';        }        else if ($item_scope == 'contact') {            $link = "<a href=\"returnnull.php\" onclick=\"return load_page('contact','view','" . $final_user . "');\">$final_user</a>";            $type_show = 'Contact';        }        else if ($item_scope == 'account') {            $link = "<a href=\"returnnull.php\" onclick=\"return load_page('account','view','" . $final_user . "');\">$final_user</a>";            $type_show = 'Account';        }        else {            $link = "";            $type_show = ucwords($item_scope);        }        */        ?>        <fieldset>            <legend>Pertains To</legend>            <div class="pad24t">                <dl>                    <dt>ID</dt>                    <dd><?php echo $note_user['link']; ?></dd>                    <dt>Type</dt>                    <dd><?php echo $note_user['type']; ?></dd>                </dl>                <div class="clear"></div>            </div>        </fieldset>    <?php    }    ?>    <fieldset>        <legend>Dates</legend>        <div class="pad24t">            <div class="field">                <label class="less">Date</label>                <div class="field_entry_less">                    <?php                    echo $admin->datepicker('date', $date, '1', '100%');                    ?>                </div>            </div>            <div class="field">                <label class="less">Deadline</label>                <div class="field_entry_less">                    <?php                    echo $admin->datepicker('deadline', $deadline, '1', '100%');                    ?>                </div>            </div>        </div>    </fieldset>    <?php    if ($deadline != '0000-00-00 00:00:00' && $editing == '1') {        ?>        <fieldset>            <legend>Status</legend>            <div class="pad24t">                <dl>                    <dt>Status</dt>                    <dd><?php                        echo $data->final_content['show_status'];                        ?></dd>                    <dt>Completed On</dt>                    <dd><?php                        echo $data->final_content['show_complete_on'];                        ?></dd>                    <dt>Completed By</dt>                    <dd><?php                        echo $data->final_content['show_complete_by'];                        ?></dd>                </dl>                <div class="clear"></div>            </div>        </fieldset>    <?php    }    ?>    <fieldset>        <legend>Additional Data</legend>        <div class="pad24t">            <div class="field">                <label class="less">Label</label>                <div class="field_entry_less">                    <select name="label">                        <?php                        echo $admin->get_note_labels($flabel);                        ?>                    </select>                </div>            </div>            <div class="field">                <label class="less">Encryption</label>                <div class="field_entry_less">                    <input type="radio" name="encrypt" value="1" <?php if ($encrypt == '1') { echo " checked=\"checked\""; } ?> /> Encrypt this note.<br />                    <input type="radio" name="encrypt" value="0" <?php if ($encrypt != '1') { echo " checked=\"checked\""; } ?> /> Do NOT encrypt this note.<br />                </div>            </div>            <div class="field">                <label class="top">Note Accessibility</label>                <div class="field_entry_top">                    <?php                    if (!empty($data->{'final_content'}['public'])) {                        ?>                        <input type="radio" name="public" value="1"                               onclick="return hide_div('find_employee');" <?php if ($data->{'final_content'}['public'] == '1') {                            echo " checked=\"checked\"";                        } ?> /> Public: all staff can view this.<br/>                        <input type="radio" name="public" value="2"                               onclick="return hide_div('find_employee');" <?php if ($data->{'final_content'}['public'] == '2') {                            echo " checked=\"checked\"";                        } ?> /> Broadcast: Display this note on staff feeds.<br/>                        <input type="radio" name="public" value="3"                               onclick="return show_div('find_employee');" <?php if ($data->{'final_content'}['public'] == '3') {                            echo " checked=\"checked\"";                        } ?> /> Specific Employee.<br/>                        <input type="radio" name="public" value="0"                               onclick="return hide_div('find_employee');" <?php if ($data->{'final_content'}['public'] == '0') {                            echo " checked=\"checked\"";                        } ?> /> Private: for my eyes only<br/>                    <?php                    } else {                        ?>                        <input type="radio" name="public" value="1"                               onclick="return hide_div('find_employee');"/> Public: all staff can view this.<br/>                        <input type="radio" name="public" value="2"                               onclick="return hide_div('find_employee');"/> Broadcast: Display this note on staff feeds.                        <br/>                        <input type="radio" name="public" value="3"                               onclick="return show_div('find_employee');"/> Specific Employee.<br/>                        <input type="radio" name="public" value="0" onclick="return hide_div('find_employee');"                               checked="checked"/> Private: for my eyes only<br/>                    <?php                    }                    ?>                </div>            </div>            <div class="field" id="find_employee" style="display:<?php            if (!empty($data->final_content['public']) && $data->final_content['public'] == '3') {                echo "block";            } else {                echo "none";            }            ?>;">                <label class="less">Employee</label>                <div class="field_entry_less">                    <input type="text" id="ownerd" name="owner_dud"                           autocomplete="off" onkeyup="return autocom(this.id,'id','username','ppSD_staff','username','staff');"                           value="<?php echo $for_name; ?>" style="width:200px;"/><a href="null.php" onclick="return get_list('staff','ownerd_id','ownerd');"><img                            src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"                            title="Select from list" class="icon-right"/></a>                    <input type="hidden" name="for" id="ownerd_id" value="<?php echo $for; ?>"/>                    <p class="field_desc" id="owner_dud_dets">Input any employee for whom this note applies.</p>                </div>            </div>            <?php            if ($item_scope == 'contact') {                ?>                <div class="field">                    <label class="top">Next Required Action Date</label>                    <div class="field_entry_top">                        <input type="checkbox" name="update_next_action" value="1"/> Update "Next Action" date for this                        user.<br/>                    </div>                </div>            <?php            }            ?>    </fieldset>    <fieldset>        <legend>Value</legend>        <div class="pad24t">            <div class="field">                <label class="less">Value</label>                <div class="field_entry_less">                    <?php                    echo place_currency('<input type="text" name="value" value="' . $value . '" style="width:100px;" maxlength="10" />', '1');                    ?>                </div>            </div>        </div>    </fieldset>    </div>    <div class="col66r">        <fieldset>            <legend>Note Content</legend>            <div class="pad24t">                <div class="field">                    <label class="less">Title</label>                    <div class="field_entry_less">                        <input type="text" name="name" value="<?php if (!empty($data->final_content['name'])) {                            echo $data->final_content['name'];                        } ?>" style="width:100%;" maxlength="85"/>                    </div>                </div>                <div class="field">                    <textarea name="note" class="richtext" id="123a"                              style="width:100%;height:200px;"><?php                        if (! empty($data->final_content['note'])) {                            if ($encrypt == '1') {                                $fdata = decode($data->final_content['note']);                            } else {                                $fdata = $data->final_content['note'];                            }                            echo $fdata;                        }                        ?></textarea>                    <?php                    echo $admin->richtext('100%', '500px', '123a', '0', '1');                    ?>                </div>            </div>        </fieldset>    </div>    <div class="clear"></div>    </li>    <li class="form_step">        <div class="pad24t">            <?php            if (!empty($_POST['id'])) {                ?>                <fieldset>                    <legend>Existing Files</legend>                    <div class="pad24t">                        <?php                        $attach = $admin->get_note_attachments($_POST['id']);                        echo $attach['data'];                        ?>                    </div>                </fieldset>            <?php            }            ?>            <fieldset>                <legend>Add New Files</legend>                <div class="pad24t">                    <div class="field">                        <label class="top">Files</label>                        <script type="text/javascript" src="js/jquery.fileuploader.js"></script>                        <script type="text/javascript">                            $(document).ready(function () {                                var uploader = new qq.FileUploader({                                    element: document.getElementById('fileuploader'),                                    action: 'cp-functions/upload.php',                                    debug: true,                                    params: {                                        type: '',                                        id: '<?php echo $final_user; ?>',                                        permission: 'upload-note',                                        label: 'note_attachment',                                        noteid: '<?php echo $cid; ?>',                                        scope: '1' // 1 = admin cp only, 0 = user page as well                                    }                                });                            });                        </script>                        <p>Drag and drop files here to attach them to this note.</p>                        <div id="fileuploader">                            <noscript><p>Please enable JavaScript to use file uploader.</p></noscript>                        </div>                    </div>                </div>            </fieldset>        </div>    </li>    </ul>    </div>    <script src="js/form_rotator.js" type="text/javascript"></script>    </div>    </form><?php}?>