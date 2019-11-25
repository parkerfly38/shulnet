<?php



/**
 *
 *
 * Zenbership Membership Software
 * Copyright (C) 2013-2016 Castlamp, LLC
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Brian Kresge
 * @link        http://www.covebrookcode.com/
 * @link        http://www.zenbership.com/
 * @copyright   (c) 2013-2016 Castlamp, 2019 Brian Kresge
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @project     Zenbership Membership Software for Synagogues
 */
$admin = new admin;
$yahrzeits = new yahrzeits;
$error = '0';
if (! empty($_POST['id'])) {
    $editing             = '1';
    $data                = new stdClass;
    $yahrzeits->get_yahrzeit($_POST['id']);
    $data->final_content = $yahrzeits->final_content;
    // $data = new history($_POST['id'],'','','','','','ppSD_notes');
    $englishname       = $data->final_content['English_Name'];
    $final_user = $data->final_content['user_id'];
    $hebrewname   = $data->final_content['Hebrew_Name'];
    $englishdate = $data->final_content['English_Date_of_Death'];
    $hebrewdate      = $data->final_content['Hebrew_Date_of_Death'];
    $relationship        = $data->final_content['Relationship'];
    
    $cid = $_POST['id'];
} else {
    $editing = '0';
    $englishdate      = current_date();
    $final_user  = '';
    $englishname = '';
    $hebrewname   = '';
    $hebrewdate    = '';
    $relationship = '';
   
    if (!empty($_POST['user_id'])) {
        $final_user = $_POST['user_id'];
    } else {
        $final_user = '';
    }
    $cid = generate_id('random', '20');
}
if ($error == '1') {
    echo "You cannot view this yahrzeit.";
} else {
    ?>
    <script type="text/javascript">

$.ctrl('S', function () {
    return json_add('yahrzeit-edit', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
});

</script>



<form action="" method="post" id="popupform"
  onsubmit="return json_add('yahrzeit-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');"
  enctype="multipart/form-data">


<div id="popupsave">


<?php



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


</div>


<h1 class="noLinkColors">
Adding Yahrzeit
</h1>

<div class="popupbody">


<ul id="theStepList">

<li class="on" onclick="return goToStep('0');">Yahrzeit</li>


</ul>


<div class="pad24t">

<ul id="formlist">

<li class="form_step">

<div class="col50r noBorder">


<fieldset>

    <legend>Info about Deceased</legend>

    <div class="pad24t">


        <div class="field">

            <label class="less">English Name</label>

            <div class="field_entry_less">

                <input type="text" name="English_Name" value="<?php if (!empty($data->final_content['English_Name'])) {
                    echo $data->final_content['English_Name'];
                } ?>" style="width:100%;" maxlength="255"/>

            </div>

        </div>

        <div class="field">

            <label class="less">Hebrew Name</label>

            <div class="field_entry_less">

                <input type="text" name="Hebrew_Name" value="<?php if (!empty($data->final_content['Hebrew_Name'])) {
                    echo $data->final_content['Hebrew_Name'];
                } ?>" style="width:100%;" maxlength="255"/>

            </div>

        </div>

        <div class="field">

            <label class="less">Calendar Date of Death</label>

            <div class="field_entry_less">

                <input type="date" name="English_Date_of_Death" value="<?php if (!empty($data->final_content['English_Date_of_Death'])) {
                    echo date_format(date_create($data->final_content['English_Date_of_Death']), "Y-m-d");
                } ?>" style="width:100%;"/>

            </div>

        </div>
        
        <div class="field">
            <label class="less">Hebrew Date of Death</label>

            <div class="field_entry_less">
                <input type="text" name="Hebrew_Date_of_Death" value="<?php if (!empty($data->final_content['Hebrew_Date_of_Death'])) {
                    echo $data->final_content['Hebrew_Date_of_Death'];
                } ?>" style="width:100%;"/>
            </div>
        </div>
        
        <div class="field">
            <label class="less">Relationship</label>

            <div class="field_entry_less">
                <input type="text" name="Relationship" value="<?php if (!empty($data->final_content['Relationship'])) {
                    echo $data->final_content['Relationship'];
                } ?>" style="width:100%;"/>
            </div>
        </div>
    </div>


</fieldset>


</div>

<div class="clear"></div>


</li>

</ul>

</div>

<script src="js/form_rotator.js" type="text/javascript"></script>


</div>


</form>



<?php

}

?>