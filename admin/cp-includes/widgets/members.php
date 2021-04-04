<?php

   

// ----------------------------
// List Members

if ($options['list'] == '1') {
    $user     = new user;
    $sf       = new special_fields('member');
    $headings = '';
    foreach ($options['fields'] as $header) {
        $name = $sf->clean_name($header);
        $headings .= '<th>' . $name . '</th>';
    }
    $found = 0;
    $list  = '';
    $STH   = $this->run_query("
        SELECT *
        FROM `ppSD_members`
        JOIN `ppSD_member_data`
        ON ppSD_members.id=ppSD_member_data.member_id
        ORDER BY ppSD_members.joined DESC
        LIMIT " . $this->mysql_cleans($options['limit']) . "
    ");
    while ($row = $STH->fetch()) {
        $found      = 1;
        $this_entry = '';
        // Update current row in
        // field formatter
        $sf->update_row($row);
        // Headings
        $cur = 0;
        foreach ($options['fields'] as $header) {
            $cur++;
            if ($cur == 1) {
                $this_entry .= '<td><a href="returnull.php" onclick="return popup(\'member_view\',\'id=' . $row['id'] . '\');">' . $sf->process($header, $row[$header]) . '</a></td>';
            } else {
                $this_entry .= '<td>' . $sf->process($header, $row[$header]) . '</td>';
            }
        }
        // Row
        $list .= '<tr>';
        $list .= $this_entry;
        $list .= '</tr>';
    }
    if ($found <= 0) {
        $list .= '<tr><td colspan="3" class="weak">Nothing to display.</td></tr>';
    }
    $final_list = "
        <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"widget\">
        <thead>
            <tr>
                $headings
            </tr>
        </thead>
        <tbody>
            $list
        </tbody>
        </table>
    ";
} else {
    $final_list = '';
}

// ----------------------------
//  Graph Data

if ($options['graph'] == '1') {
    $graph_id   = uniqid();
    $gdata      = array(
        'int'  => $options['increments'],
        'unit' => $options['unit'],
    );
    $graph      = array(
        array(
            'title' => 'Members',
            'key'   => 'members',
        ),
    );
    $options    = array(
        'title'      => $data['title'],
        'element'    => $graph_id,
        'increments' => $gdata['int'],
        'type'       => $gdata['unit'],
    );
    $graph_outA = new graph($graph, $options);
    $graph_outA .= '<div id="' . $graph_id . '" class="graph_box_widget" style="height:250px;"></div>';
} else {
    $graph_outA = '';
}

?>

<div class="nontable_section">
    <div class="pad24">
        <div class="widget_full"><a href="index.php?l=members">Full List &raquo;</a></div>
        <h2><?php echo $data['title']; ?></h2>

        <div class="nontable_section_inner">
            <div class="pad24">
                <?php echo $final_list; ?>
                <?php echo $graph_outA; ?>
            </div>
        </div>
    </div>
</div>