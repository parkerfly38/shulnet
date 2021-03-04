<?php 



$permission = 'calendar';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions();
} else {

if ($employee['permissions']['admin'] == '1') {
    $copts = array(
        'display' => array(
            'sales',
            'revenue',
            'rsvps',
            'contacts',
            'members',
            'contacts_due',
            'deadlines',
            'appointments',
        ),
        'options' => '',
    );
} else {
    $copts = array(
        'display' => array(
            'contacts_due',
            'deadlines',
            'appointments',
        ),
        'options' => '',
    );
}

if (! empty($_GET['year'])) {
    $year = $_GET['year'];
} else {
    $year = '';
}
if (! empty($_GET['month'])) {
    $month = $_GET['month'];
} else {
    $month = '';
}

$calendar = new calendar($year, $month, $copts);
$nextprev = $calendar->next_prev_links();

?>

    <div id="topblue" class="fonts small">
        <div class="holder">
            <div class="floatright" id="tb_right">
                <?php
                /*
                 * title'      => $title,
            'next_month' => $next_month,
            'next_link'  => $link_next,
            'prev_month' => $prev_month,
            'prev_lin
                 */
                echo '<span><a href="' . $nextprev['prev_link'] . '">' . $nextprev['prev_month'] . '</a></span>';
                echo '<span class="div"></span>';
                echo '<span><b>' . $nextprev['title'] . '</b></span>';
                echo '<span class="div"></span>';
                echo '<span><a href="' . $nextprev['next_link'] . '">' . $nextprev['next_month'] . '</a></span>';
                ?>
            </div>
            <div class="floatleft" id="tb_left">
                <b>Calendar</b>
                <?php
                include PP_PATH . "/admin/cp-includes/user_link_menu.php";
                ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <link rel="stylesheet" type="text/css" media="all" href="css/calendar.css"/>
    <div id="mainsection">
        <div class="nontable_section">
            <div class="pad24">
                <h1>Calendar of Activity (<?php echo $nextprev['title']; ?>)</h1>
                <div class="nontable_section_inner">
                    <?php
                    echo $calendar->output;
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>