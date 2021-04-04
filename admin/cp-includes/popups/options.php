<?php 


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