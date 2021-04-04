<?php

   


// Generate Calendar
$exp = explode(' ', current_date());
$exp_date = explode('-', $exp['0']);
if (!empty($_GET['year'])) {
    $year = $_GET['year'];
} else {
    $year = $exp_date['0'];
}
if (!empty($_GET['month'])) {
    $month = $_GET['month'];
} else {
    $month = $exp_date['1'];
}

$copts = array(
    'display' => $options['display'],
    'options' => $options['options'],
);
$calendar = new calendar($year, $month, $copts);

?>

<link href="css/calendar.css" rel="stylesheet" type="text/css"/>
<div class="nontable_section">
    <div class="pad24">
        <h2><?php echo $data['title']; ?></h2>

        <div class="nontable_section_inner">
            <div class="pad24">
                <?php
                echo $calendar->output;
                ?>
            </div>
        </div>
    </div>
</div>