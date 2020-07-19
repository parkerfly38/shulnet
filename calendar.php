<?php

   
// Load the basics
require "admin/sd-system/config.php";
// Check a user's session
$session = new session;
$ses     = $session->check_session();
// Calendar ID
if (empty($_GET['id'])) {
    $calendar_id = '1';
} else {
    $calendar_id = $_GET['id'];
}
// Generate the calendar
$empty_date = 0;

if (empty($_GET['year'])) {
    $year = date('Y');
    $empty_date++;
} else {
    if (is_numeric($_GET['year'])) {
        $year = $_GET['year'];
    } else {
        $year = date('Y');
    }
}

if (empty($_GET['month'])) {
    $month = date('m');
    $empty_date++;
} else {
    if ($_GET['month'] > 0 && $_GET['month'] <= 12) {
        $month = $_GET['month'];
    } else {
        $month = date('m');
    }
}

if (empty($_GET['day'])) {
    $day = '';
} else {
    if ($_GET['day'] > 0 && $_GET['day'] <= 31) {
        $day = $_GET['day'];
    } else {
        $day = '';
    }
}

if (empty($_GET['tags'])) {
    $tags = '';
} else {
    $tags = $_GET['tags'];
}


$event        = new event($year, $month, $calendar_id, $day, $tags);


// Find first available event
if ($empty_date == 2) {
    $next_event = $event->next_event_on_calendar($calendar_id);
    if (! empty($next_event)) {
        $blowup = explode(' ', $next_event['starts']);
        $blowupdate = explode('-', $blowup['0']);
        $year = $blowupdate['0'];
        $month = $blowupdate['1'];
        $event->setYear($year);
        $event->setMonth($month);
    }
}

// Accessible?
$get_calendar = $event->get_calendar($calendar_id);
if ($get_calendar['members_only'] == '1' && $ses['error'] == '1') {
    $session->reject('login', 'L004');
    exit;
}
if (!empty($_GET['export'])) {
    $event->export_calendar($year, $month, $day);
    exit;
} else {
    if (! empty($day)) {
        $calendar = $event->generate_day_calendar($year, $month, $day, $calendar_id, $tags);
    } else {
        $calendar = $event->generate_calendar($year, $month, $calendar_id, $tags);
    }
}
$calendar['label_legend'] = $event->build_label_legend();
$calendar['month']        = $month;
$calendar['year']         = $year;
$calendar['calendar_id']  = $calendar_id;

if ($get_calendar['style'] == '2') {
    $template  = new template('calendar_long', $calendar, '1');
} else {
    $template  = new template('calendar', $calendar, '1');
}
echo $template;
exit;