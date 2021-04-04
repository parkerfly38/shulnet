<?php 

if (! empty($_POST['type'])) {
    $act  = $_POST['type'];
    $type = 'search for';
} else {
    $act  = 'email';
    $type = 'e-mail';
}

if (! empty($_POST['type']) && $_POST['type'] == 'sms') {
    $permission = 'sms-targeted';
    $check = $admin->check_permissions($permission, $employee);
    if ($check != '1') {
        echo "0+++You don't have permission to use this feature.";
        exit;
    }
}
else if (! empty($_POST['type']) && $_POST['type'] == 'email') {
    $permission = 'targeted';
    $check = $admin->check_permissions($permission, $employee);
    if ($check != '1') {
        echo "0+++You don't have permission to use this feature.";
        exit;
    }
}

// This is used for mass subscribing or
// mass granting access to content
// based on criteria.
if (! empty($_POST['id'])) {
    $act_id = $_POST['id'];
} else {
    $act_id = '';
}

?>



<h1>Who is this applicable to?</h1>


<div class="popupbody">

    <?php

    if ($act == 'campaign') {
        ?>
        <p class="highlight">Before we can set up your campaign, you will need to set up criteria for who will receive this campaign. Please build this criteria below.</p>
        <?php
    } else {
        ?>
        <p class="highlight">Select who the criteria you are building applies to.</p>
        <?php
    }

    ?>

    <div class="pad fullForm">

        <div class="col50l"><div class="box text-center pad">
            <label>
                <a href="returnnull.php"
                   onclick="return switch_popup('build_criteria','act=<?php echo $act; ?>&act_id=<?php echo $act_id; ?>&type=member','1');"><img src="imgs/icon-members-lg.png" width="124" height="124" alt="Members"
                     title="Members" class="iconlgCenter"/>Members</a>
            </label>
            <p class="nobotmargin">Targeted to members.</p>
        </div></div>
        <div class="col50r"><div class="box text-center pad">
            <label>
                <a href="returnnull.php"
                    onclick="return switch_popup('build_criteria','act=<?php echo $act; ?>&act_id=<?php echo $act_id; ?>&type=contact','1');"><img src="imgs/icon-contacts-lg.png" width="124" height="124" alt="Contacts"
                     title="Contacts" class="iconlgCenter"/>Contacts</a>
            </label>
            <p class="nobotmargin">Targeted to contacts.</p>
        </div></div>
        <div class="col50l"><div class="box text-center pad">
            <label>
                <a href="returnnull.php"
                   onclick="return switch_popup('build_criteria','act=<?php echo $act; ?>&act_id=<?php echo $act_id; ?>&type=yahrzeit','1');"><img src="imgs/icon-members-lg.png" width="124" height="124" alt="Yahrzeits"
                     title="Yahrzeits" class="iconlgCenter"/>Yahrzeits</a>
            </label>
            <p class="nobotmargin">Targeted to members.</p>
        </div></div>
    </div>

    <div class="clear"></div>

    </div>
</div>

