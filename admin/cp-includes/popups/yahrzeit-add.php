<?php

$admin = new admin;
$yahrzeits = new yahrzeits;
$error = '0';
if (! empty($_POST['id'])) {
    $editing             = '1';
    $data                = new stdClass;
    $data->final_content = $yahrzeits->get_yahrzeit($_POST['id']);
    // $data = new history($_POST['id'],'','','','','','ppSD_notes');
    $englishname       = $data->final_content['English_Name'];
    $hebrewname   = $data->final_content['Hebrew_Name'];
    $englishdate = $data->final_content['English_Date_of_Death'];
    $hebrewdate      = $data->final_content['Hebrew_Date_of_Death'];    
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
    return json_add('yahrzeit-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
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
                    echo $data->final_content['English_Date_of_Death'];
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