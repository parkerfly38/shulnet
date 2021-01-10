<?phpShulNETShulNETShulNET



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
 * @author      Castlamp
 * @link        http://www.castlamp.com/
 * @link        http://www.zenbership.com/
 * @copyright   (c) 2013-2016 Castlamp
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @project     Zenbership Membership Software
 */


$campaign = new campaign($_POST['id']);

$data = $campaign->get_campaign();


// Monthly Graph

$gdata = $admin->get_graph_array($_POST);

$notes = new notes;
$pinned_notes = $notes->get_pinned_notes($_POST['id']);

// Graph 1

$graph = array(
    array(
        'title' => 'Sent E-Mails',
        'key'   => 'emails_sent-' . $_POST['id'],
    ),
    array(
        'title' => 'Read E-Mails',
        'key'   => 'emails_read-' . $_POST['id'],
    ),
    array(
        'title' => 'Bounced  E-Mails',
        'key'   => 'bounced_emails-' . $_POST['id'],
    ),
);

$options = array(
    'title'      => 'E-Mail Activity',
    'element'    => 'stats_graphA',
    'increments' => $gdata['int'],
    'type'       => $gdata['unit'],
);

$graph_outA = new graph($graph, $options);


// Graph 2

$graph = array(
    array(
        'title' => 'Links Clicked',
        'key'   => 'link_clicks-' . $_POST['id'],
    ),
    array(
        'title' => 'Milestones Reached',
        'key'   => 'milestones-' . $_POST['id'],
    ),
);

$options = array(
    'title'      => 'Link Clicks vs Milestones Reached',
    'element'    => 'stats_graphB',
    'increments' => $gdata['int'],
    'type'       => $gdata['unit'],
);

$graph_outB = new graph($graph, $options);


// Graph 3

$graph = array(
    array(
        'title' => 'Subscriptions',
        'key'   => 'campaign_subscriptions-' . $_POST['id'],
    ),
    array(
        'title' => 'Unsubscriptions',
        'key'   => 'campaign_unsubscriptions-' . $_POST['id'],
    ),
);

$options = array(
    'title'      => 'Subscription Activity',
    'element'    => 'stats_graphC',
    'increments' => $gdata['int'],
    'type'       => $gdata['unit'],
);

$graph_outC = new graph($graph, $options);


// Graph 4

$graph = array(
    array(
        'title' => 'Effectiveness',
        'key'   => 'campaign_effectiveness-' . $_POST['id'],
    ),
);

$options = array(
    'title'      => 'Effectiveness',
    'element'    => 'stats_graphD',
    'increments' => $gdata['int'],
    'type'       => $gdata['unit'],
);

$graph_outD = new graph($graph, $options);


echo $graph_outA;

echo $graph_outB;

echo $graph_outC;

echo $graph_outD;





?>



<?php

if ($data['total_messages'] <= 0 && $data['optin_type'] == 'criteria') {
    echo "<p class=\"highlight center\">There are no messages in this campaign. Click on \"Messages\" to add some.</p>";

}

?>



<div class="pad24">


    <?php
        if (sizeof($pinned_notes) > 0) {
    ?>
    <div class="col75l">
    <?php
        } else {
    ?>
    <div class="col100">
    <?php
    }
    ?>

    <form action="" id="graph_form" onsubmit="return regen_graph();" method="get">

        <?php

        echo $admin->graph_form($gdata);

        ?>

        <div class="graph_area">

            <div class="col50l">

                <div id="stats_graphA" class="graph_box_full" style="height:250px;"></div>

                <div id="stats_graphB" class="graph_box_full" style="height:250px;"></div>

            </div>

            <div class="col50r">

                <div id="stats_graphC" class="graph_box_full" style="height:250px;"></div>

                <div id="stats_graphD" class="graph_box_full" style="height:250px;"></div>

            </div>

            <div class="clear"></div>

        </div>

    </form>

    </div>
        <?php
        if (sizeof($pinned_notes) > 0) {
        ?>
        <div class="col25r">

        <?php

        if (! empty($pinned_notes)) {

            foreach ($pinned_notes as $item) {
                echo $admin->format_note($item);
            }

        }

        ?>

    </div>
        <?php
        }
        ?>


</div>

