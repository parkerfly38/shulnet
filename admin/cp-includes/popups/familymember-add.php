<?php

$error = '0';
$owner = '1';
$familymembers = new familymembers;
if (!empty($_POST['id']))
{
    $editing                = '1';
    $data                   = new stdClass;
    $data->final_content    = $familymembers->getFamilyMemberByID($_POST['id']);
    $first_name             = $data->final_content->first_name;
    $last_name              = $data->final_content->last_name;
    $address_line_1         = $data->final_content->address_line_1;
    $address_line_2         = $data->final_content->address_line_2;
    $city                   = $data->final_content->city;
    $state                  = $data->final_content->state;
    $zip                    = $data->final_content->zip;
    $country                = $data->final_content->country;
    $phone                  = $data->final_content->phone;
    $email                  = $data->final_content->email;
    $DOB                    = $data->final_content->DOB;
    $hebrew_name            = $data->final_content->hebrew_name;
    $bnai_mitzvah_date      = $data->final_content->bnai_mitzvah_date;

    $cid = $_POST["id"];
} else {
    $first_name = "";
    $last_name = "";
    $address_line_1 = "";
    $address_line_2 = "";
    $city = "";
    $state = "";
    $zip = "";
    $country = "";
    $phone = "";
    $email = "";
    $DOB = "";
    $hebrew_name = "";
    $bnai_mitzvah_date = "";
    $cid = 0;
}
?>
<script type="text/javascript">

$.ctrl('S', function () {
    return json_add('familymember-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
});

</script>
<form action="" method="post" id="popupform"
          onsubmit="return json_add('familymember-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');"
          enctype="multipart/form-data">
<div id="popupsave">
    
<input type="submit" value="Save" class="save"/>

<input type="hidden" name="id" value="<?php echo $cid; ?>"/>
<input type="hidden" name="member_id" value="<?php echo $_POST["user_id"]; ?>" />
</div>

<h1>Family Member</h1>

<div id="primary_slider_content" class="fullForm popupbody">
<fieldset>
        <legend>Family Member Data</legend>
    <div class="pad24t">
        <div class="col33l">

            <div class="field">
                <label class="less">First Name</label>
                <div class="field_entry_less">
                    <?php
                    echo $af
                        ->setValue($first_name)
                        ->string('first_name');
                    ?>
                </div>
            </div>
            <div class="field">
                <label class="less">Last Name</label>
                <div class="field_entry_less">
                    <?php
                    echo $af
                        ->setValue($last_name)
                        ->string('last_name');
                    ?>
                </div>
            </div>
            <div class="field">
                <label class="less">Date of Birth</label>
                <div class="field_entry_less">
                    <?php
                    echo $af
                        ->setSpecialType('date')
                        ->setValue($DOB)
                        ->string('DOB');
                    ?>
                </div>
            </div>
            <div class="field">
                <label class="less">Hebrew Name</label>
                <div class="field_entry_less">
                    <?php
                    echo $af
                        ->setValue($hebrew_name)
                        ->string('hebrew_name');
                    ?>
                </div>
            </div>
            <div class="field">
                <label class="less">Date of B'Nai Mitzvah</label>
                <div class="field_entry_less">
                    <?php
                    echo $af
                        ->setSpecialType('date')
                        ->setValue($bnai_mitzvah_date)
                        ->string('bnai_mitzvah_date');
                    ?>
                </div>
            </div>
        </div>
        <div class="col33r noBorder">
            <fieldset>
            <div class="field">
                <label class="less">Address Line 1</label>
                <div class="field_entry_less">
                    <?php
                    echo $af
                        ->setValue($address_line_1)
                        ->string('address_line_1');
                    ?>
                </div>
            </div>
            <div class="field">
                <label class="less">Address Line 2</label>
                <div class="field_entry_less">
                    <?php
                    echo $af
                        ->setValue($address_line_2)
                        ->string('address_line_2')
                    ?>
                </div>
            </div>
            <div class="field">
                <label class="less">City</label>
                <?php
                    echo $af
                        ->setValue($city)
                        ->string('city');
                ?>
            </div>
            <div class="field">
                <label class="less">State</label>
                <?php
                    echo $af
                        ->setValue($state)
                        ->select('state', $state, state_array(), '');
                ?>
            </div>
            <div class="field">
                <label class="less">Country</label>
                <?php
                    echo $af
                        ->setValue($country)
                        ->select('country',$country,country_array(), '');
                ?>
            </div>
            <div class="field">
                <label class="less">Zip</label>
                <?php
                    echo $af
                        ->setValue($zip)
                        ->string("zip");
                ?>
            </div>
            <div class="field">
                <label class="less">Phone</label>
                <?php
                    echo $af
                        ->setValue($phone)
                        ->string("phone");
                ?>
            </div>
            <div class="field">
                <label class="less">Email</label>
                <?php
                    echo $af
                        ->setValue($email)->string("email");
                ?>
            </div>
        </div>
</div>
</fieldset>
</div>


</form>