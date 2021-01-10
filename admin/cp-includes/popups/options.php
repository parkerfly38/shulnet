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

if ($employee['permissions']['admin'] != '1') {
    $admin->show_popup_error('No permissions.');
}
else if (empty($_POST['type'])) {
    $admin->show_popup_error('Option type not selected.');
}
else {
    $type = strtoupper($_POST['type']);

?>

    <script type="text/javascript">
        $.ctrl('S', function () {
            return json_add('options-add', '', '1', 'popupform');
        });
    </script>

    <form action="" method="post" id="popupform" onsubmit="return json_add('options-add','','1','popupform');">

    <div id="popupsave">
        <input type="submit" value="Save" class="save"/>
    </div>

    <h1><?php echo $type; ?> Options</h1>

    <div class="popupbody">

        <p class="highlight">Use this form to control the program's options and settings.</p>

        <div class="pad">

        <?php

        $q1 = $db->run_query("
            SELECT *
            FROM `ppSD_options`
            WHERE `section`!='system' AND `section`!='' AND `section`='" . $db->mysql_cleans($_POST['type']) . "'
            ORDER BY `id` ASC
        ");

        $more = 0;
        $current_section = '';
        while ($row = $q1->fetch()) {
            $more++;
            if ($current_section != $row['section']) {
                if (!empty($current_section)) {
                    echo "</ul>";

                }
                echo "<ul class=\"option_editor\">";
                $current_section = $row['section'];

            }
            $option = $db->format_option($row);
            echo $option;
        }

        if ($more == '0') {
            echo "<li class=\"weak\">There are no options to display.</li>";
        }

        ?>
        </ul>

        </div>
    </div>

<?php
}
?>