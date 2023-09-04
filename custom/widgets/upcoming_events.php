<?php

// Build the query
if (empty($options['display'])) {
    $display = '5';
} else {
    $display = $options['display'];
}
$where = '';
if (!empty($options['calendar'])) {
    $where .= "`calendar_id`='" . $this->mysql_clean($options['calendar']) . "'";
} else {
    $where .= "`calendar_id`='1'";
}
if (!empty($options['timeframe'])) {
    $timeframe = add_time_to_expires($options['timeframe']);
    $where .= " AND `starts`>='" . current_date() . "' AND `starts`<='" . $timeframe . "'";
} else {
    $timeframe = add_time_to_expires('000600000000');
}
$where .= " AND `starts`>='" . current_date() . "' AND `starts`<='" . $timeframe . "'";
$where .= " AND `status`='1'";
// Load cart object
$event = new event;
// Run the query
$STH = $this->run_query("
    SELECT `id`
    FROM `ppSD_events`
    WHERE
      " . $where . "
    ORDER BY `starts` ASC
    LIMIT " . $this->mysql_cleans($display) . "
");
while ($row = $STH->fetch()) {
    // Load the product options.
    $data = $event->get_event($row['id']);
    // Generate the template.
    $changes = $data['data'];
    $temp    = new template('widget-upcoming_events', $changes, '0');
    echo $temp;
}

?>