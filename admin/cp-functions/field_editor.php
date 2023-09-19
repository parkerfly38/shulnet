<?php 

require "../sd-system/config.php";

if ($_POST['action'] == 'get_list') {
    $STH  = $db->run_query("
		SELECT `id`,`display_name`,`type`
		FROM `ppSD_fields`
		ORDER BY `display_name` ASC
	");
    $list = '';
    while ($row = $STH->fetch()) {
        $list .= "<option value=\"" . $row['id'] . "||" . $row['display_name'] . "||||" . $row['type'] . "\">" . $row['display_name'] . ' (' . $row['id'] . ')' . "</option>";

    }
    echo $list;
    exit;

}

else if ($_POST['action'] == 'get_fieldset') {
    $STH   = $db->run_query("
		SELECT `id`,`name`
		FROM `ppSD_fieldsets`
		WHERE `billing`!='1'
		GROUP BY `id`,`name`
		ORDER BY `name` ASC
	");
    $listA = '';
    while ($row = $STH->fetch()) {
        $listA .= "<option value=\"" . $row['id'] . "||" . $row['name'] . "\">" . $row['name'] . "</option>";

    }
    echo $listA;
    exit;

}

else if ($_POST['action'] == 'build_form') {
    $together = '';
    $form     = new form;
    $data     = $form->get_form($_POST['id']);

    if (! empty($data['type'])) {
        if ($data['type'] == 'contact' || $data['type'] == 'dependency' || $data['type'] == 'register-free' || $data['type'] == 'register-paid') {
            $cur = 0;
            $pages = $data['pages'];
            while ($pages > 0) {
                $cur++;
                if (empty($data['step' . $cur . '_name'])) {
                    $pgname = 'Step ' . $cur;
                } else {
                    $pgname = $data['step' . $cur . '_name'];
                }
                $together .= ',page_break||' . $pgname . '||||';
                $field = new field();
                $fieldsets = $field->get_field_sets($_POST['id'] . '-' . $cur);
                foreach ($fieldsets['0'] as $aSet) {
                    $add = return_fieldset($aSet);
                    $together .= $add;
                }
                $pages--;
            }
        } else {
            $field = new field();
            $fieldsets = $field->get_field_sets($_POST['id']);
            foreach ($fieldsets['0'] as $aSet) {
                $add = return_fieldset($aSet);
                $together .= $add;
            }
        }

        if (!empty($together)) {
            echo ltrim($together, ',');
        } else {
            echo '';
        }
    }
    exit;
}

else if ($_POST['action'] == 'fieldset_fields') {
    $listA = return_fieldset($_POST['id']);
    echo ltrim($listA, ',');
    exit;

}

function return_fieldset($id)
{
    global $db;
    $listA = '';
    // Get fieldset name
    $set = $db->get_array("
		SELECT *
		FROM `ppSD_fieldsets`
		WHERE `id`='" . $db->mysql_cleans($id) . "'
		LIMIT 1
	");
    $listA .= ",section||" . $set['name'] . '||||';
    // Now get all fields in the set.
    $STH = $db->run_query("
		SELECT
			ppSD_fieldsets_fields.req,
			ppSD_fieldsets_fields.field,
			ppSD_fields.display_name,
			ppSD_fields.type
		FROM
			`ppSD_fieldsets_fields`
		JOIN
			`ppSD_fields`
		ON
			ppSD_fields.id=ppSD_fieldsets_fields.field
		WHERE
			ppSD_fieldsets_fields.fieldset='" . $db->mysql_cleans($id) . "'
		ORDER BY
			ppSD_fieldsets_fields.order ASC
	");
    while ($row = $STH->fetch()) {
        $listA .= "," . $row['field'] . '||' . $row['display_name'] . '||' . $row['req'] . '||' . $row['type'];
    }
    return $listA;
}



