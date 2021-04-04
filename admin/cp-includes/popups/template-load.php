<?php
?>

<h1>Select Preset Template</h1>

<div class="popupbody">
    <ul class="popup_longlist">
        <!--<li><a href="null.php" onclick="return populate_template('def001');">Default E-Mail Template</a></li>-->
        <?php
        $query = $db->run_query("
    SELECT `template`,`title`
    FROM `ppSD_templates_email`
    WHERE
      ppSD_templates_email.custom='1' AND
      (
          ppSD_templates_email.public='1' OR
          ppSD_templates_email.owner='" . $employee['id'] . "'
      )
    ORDER BY title ASC
    LIMIT 0,50
");
        while ($row = $query->fetch()) {
            echo "<li><a href=\"null.php\" onclick=\"return populate_template('" . $row['template'] . "');\">" . $row['title'] . "</a></li>";
        }
        ?>
    </ul>
</div>