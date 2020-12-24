<?php

$admin = new admin;
$yahrzeits = new yahrzeits;
$error = '0';

$editing = '0';
$englishdate      = current_date();
$englishname = '';
$hebrewname   = '';
$hebrewdate    = '';

$cid = generate_id('random', '20');

if ($error == '1') {
    echo "You cannot view this yahrzeit.";
} else {
    ?>
    <script type="text/javascript">

$.ctrl('S', function () {
    return json_add('yahrzeit-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'slider_form');
});

</script>
<script src="js/jquery.accent-keyboard.js"></script>
    
    <script>
        $("input[name*='Hebrew']:not([name*='Date'])").accentKeyboard({
            layout: 'il_HE',
            active_shift: true,
            active_caps: false,
            is_hidden: true,
            open_speed: 300,
            close_speed: 100,
            show_on_focus: true,
            hide_on_blur: true,
            trigger: undefined,
            enabled: true
        });
        $(document).ready(function() {
            $(document).on("blur","#English_Date_of_Death", function()
            {
                $.ajax({
                    type: "POST",
                    url: "/admin/cp-includes/widgets/gregtojd.php",
                    data: "englishDate="+ $(this).val(),
                    success: function(data){
                        $("#Hebrew_Date_of_Death").val(data);
                    }
                });
            });
        });
    </script>


<form action="" method="post" id="slider_form"
  onsubmit="return json_add('yahrzeit-add','<?php echo $cid; ?>','<?php echo $editing; ?>','slider_form');"
  enctype="multipart/form-data">


  <div id="slider_submit">
        <div class="pad24tb">

            <div id="slider_right">

                <input type="submit" value="Save" class="save"/>

            </div>

            
            <div class="clear"></div>

        </div>
    </div>


<div id="primary_slider_content">
    <div class="col70">

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

                <input type="date" id="English_Date_of_Death" name="English_Date_of_Death" value="<?php if (!empty($data->final_content['English_Date_of_Death'])) {
                    echo $data->final_content['English_Date_of_Death'];
                } ?>" style="width:100%;"/>

            </div>

        </div>
        
        <div class="field">
            <label class="less">Hebrew Date of Death</label>

            <div class="field_entry_less">
                <input type="text" id="Hebrew_Date_of_Death" name="Hebrew_Date_of_Death" value="<?php if (!empty($data->final_content['Hebrew_Date_of_Death'])) {
                    echo $data->final_content['Hebrew_Date_of_Death'];
                } ?>" style="width:100%;"/>
            </div>
        </div>
        
        <!--<div class="field">
            <label class="less">Relationship</label>

            <div class="field_entry_less">
                <input type="text" name="Relationship" value="<?php if (!empty($data->final_content['Relationship'])) {
                    echo $data->final_content['Relationship'];
                } ?>" style="width:100%;"/>
            </div>
        </div>-->
    </div>


</fieldset>


</div>

<div class="clear"></div>


</li>

</ul>

</div>
            </div>

<script src="js/form_rotator.js" type="text/javascript"></script>


</div>


</form>



<?php

}

?>