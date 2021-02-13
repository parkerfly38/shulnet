<?php 


if (! empty($_POST['id'])) {
    $data      = new history($_POST['id'], '', '', '', '', '', 'ppSD_criteria_cache');
    $cid       = $data->final_content['id'];
    $type      = $data->final_content['type'];
    $act       = $data->final_content['act'];
    $save      = $data->final_content['save'];
    $name      = $data->final_content['name'];
    $public    = $data->final_content['public'];
    $inclusive = $data->final_content['inclusive'];
    $act_id    = $data->final_content['act_id'];
    $display_per_page = $data->final_content['display_per_page'];
    $sort = $data->final_content['sort'];
    $sortOrder = $data->final_content['sort_order'];
    $datae     = unserialize($data->final_content['criteria']);
    if ($datae['all'] == '1') {
        $all = '0';
    } else {
        $all = '1';
    }
    $editing = '1';
    $act_id = '';
} else {
    $cid       = 'new';
    $type      = (! empty($_POST['type'])) ? $_POST['type'] : '';
    $act       = (! empty($_POST['act'])) ? $_POST['act'] : '';
    $save      = 1;
    $all       = 0;
    $public    = 1;
    $inclusive = 'and';
    $name      = '';
    $display_per_page = '50';
    $sort = 'last_name';
    $sortOrder = 'ASC';
    $datae     = array(
        'filters'       => array(),
        'filter_type'   => array(),
        'filter_tables' => array(),
    );
    $editing   = '0';
    if (! empty($_POST['act_id'])) {
        $act_id = $_POST['act_id'];
    } else {
        $act_id = '';
    }
}

if ($act == 'campaign' && empty($name)) {
    $name = 'Campaign Criteria';
}
?>

<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('criteria-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform" onsubmit="return json_add('criteria-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">

<input type="hidden" name="type" value="<?php echo $type; ?>"/>
<input type="hidden" name="act" value="<?php echo $act; ?>"/>
<input type="hidden" name="act_id" value="<?php echo $act_id; ?>"/>

<div id="popupsave">
    <input type="button" value="Preview" id="preview_but" class="" onclick="return preview_criteria('popupform');"/>
    <input type="submit" value="Save" class="save"/>
</div>

<h1>Criteria Builder</h1>

<div class="popupbody fullForm">

    <?php
    if ($act == 'campaign') {
        ?>
        <p class="highlight">Before we can set up your campaign, you will need to set up criteria for who will receive this campaign. Please build this criteria below.</p>
    <?php
    } else {
        ?>
        <p class="highlight">Before we can set up your campaign, you will need to set up criteria for who will receive this campaign. Please build this criteria below.</p>
    <?php
    }
    ?>

    <div id="pop_inner">

    <div class="col33l">

        <fieldset>
            <div class="pad">

                <?php
                // Adding content access by criteria.
                if ($act == 'content_access') {
                ?>

                    <label>Content Access Period</label>
                    <?php
                    echo $af
                        ->setDescription('For how long would you like to grant these members access to this content?')
                        ->timeframe('timeframe', '010000000000', 'req', '0');

                }
                ?>

                <label>Reference Name</label>
                <?php
                echo $af
                ->setDescription('Make this a descriptive title that will help you remember what this report is.')
                ->string('name', $name, 'req');


                if ($act == 'campaign') {
                    echo "<input type=\"hidden\" name=\"save\" value=\"1\" />";
                } else {
                    ?>

                    <label>Would you like to save this as a custom report for later use?</label>
                    <?php
                    echo $af
                        ->setDescription('If you save this as a custom report, you will be able to access it from the main navigation in the administrative dashboard.')
                        ->radio('save', $save, array(
                            '1' => 'Save',
                            '0' => 'Do not save',
                        ));
                    ?>

                    <label>Who should be able to run this report?</label>
                    <?php
                    echo $af
                        ->radio('public', $save, array(
                            '1' => 'Anyone',
                            '0' => 'Just myself and administrators',
                        ));
                    ?>

                    <label>Results Per Page?</label>
                    <?php
                    echo $af
                        ->setDescription('When viewing this report, how many results should appear per page?')
                        ->string('display_per_page', $display_per_page);
                    ?>

                    <label>Sort By</label>
                    <?php
                    echo $af
                        ->setDescription('What field should the results be sorted by?')
                        ->fieldList('sort', $sort);
                    ?>

                    <label>Sort Order</label>
                    <?php
                    echo $af
                        ->radio('sort_order', $sortOrder, array(
                            'ASC' => 'Ascending',
                            'DESC' => 'Descending',
                        ));

                }
                ?>

                <label>Match all rules or any rule?</label>
                <?php
                echo $af
                    ->setDescription('If you set this to "all", matching ' . $type . 's will need to meet all of the established criteria to appear in the report. If set to "any", they will only have to match a single rule.')
                    ->radio('inclusive', $inclusive, array(
                        'and' => 'Must match all criteria.',
                        'or' => 'Must match any criteria.',
                    ));
                ?>

            </div>
        </fieldset>

    </div>
    <div class="col66r">

        <fieldset>
            <div class="pad">

                <label>Match all or specific <?php echo $type; ?>s?</label>
                <?php
                echo $af->radio('criteria', $all, array(
                    '1' => 'Only ' . $type . 's matching the criteria.',
                    '0' => 'All ' . $type . 's.',
                ));
                ?>

                <div id="matchSpecific" style="display:<?php
                if ($all == '1') {
                    echo 'block';
                } else {
                    echo 'none';
                }
                ?>;">

                    <label>Select a Field to Add As Criteria</label>
                    <?php
                    $array = array();
                    if ($type == 'member') {
                        $array = $admin->get_scope_fields('member', 'array');
                        $array[] = array(
                            'id' => '_content_access',
                            'name' => 'Content Access',
                        );

                        $array[] = array(
                            'id' => '_joined_within',
                            'name' => 'Joined Within (days)',
                        );
                    } else if ($type == 'yahrzeit')
                    {
                        $array = $admin->get_scope_fields('yahrzeit', 'array');
                    
                    } else {
                        $array = $admin->get_scope_fields('contact', 'array');

                        $array[] = array(
                            'id' => '_created_within',
                            'name' => 'Created Within (days)',
                        );
                    }
                    $array[] = array(
                        'id' => '_total_spent',
                        'name' => 'Total Spent',
                    );
                    $array[] = array(
                        'id' => '_product_bought',
                        'name' => 'Product Purchased',
                    );
                    $array[] = array(
                        'id' => '_last_action_within',
                        'name' => 'Last Action (days)',
                    );
                    $array[] = array(
                        'id' => '_next_action_within',
                        'name' => 'Next Action Within (days)',
                    );
                    $array[] = array(
                        'id' => '_last_updated_within',
                        'name' => 'Last Updated Within (days)',
                    );

                    $fArray = array();
                    foreach ($array as $name) {
                        $fArray[$name['id']] = $name['name'];
                    }

                    echo $af
                        ->setId('add_field')
                        ->select('', '', $fArray);
                    ?>

                    <img src="imgs/arrow-down.png" class="lookDown" />

                    <div style="min-height:700px;display:<?php if ($all != '1') {
                        echo "block";
                    } else {
                        echo "none";
                    } ?>;" id="add_options">

                        <!--<label>Your Criteria</label>-->
                        <div id="possible_fields">
                            <?php
                            foreach ((array)$datae as $fname => $options) {
                                if (is_array($options)) {
                                    foreach ($options as $anOption) {
                                        echo $admin->cell_criteria($type, $fname, $anOption['value'], $anOption['eq']);
                                    }
                                }
                            }
                            ?>
                        </div>

                    </div>

                </div>
            </div>
        </fieldset>

    </div>
    </div>

</div>



</form>

<script src="js/form_rotator.js" type="text/javascript"></script>

<script type="text/javascript">

    $(document).ready(function() {
        $("input[type=radio][name='criteria']").change(function() {
            switch(this.value) {
                case '1':
                    return show_div('matchSpecific');
                case '0':
                    return hide_div('matchSpecific');
            }
        });
    });

    function check_submit() {
        if ($('#load_saved').val()) {
            return json_add('criteria-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
        }
    }

    var repSo = '';

    $(document).ready(function () {
        $('#add_field').live('change', function () {
            return add_criteria($(this).val());
        });
    });

    function add_criteria(id, value, eq) {
        repSo = '';
        show_loading();
        send_data = 'type=<?php echo $type; ?>&id=' + id + '&value=' + value + '&eq=' + eq;
        $.post('cp-functions/criteria_field.php', send_data, function (repSo) {
            $('#possible_fields').prepend(repSo);
            $('#add_field').val('');
            close_loading();
        });
        return false;
    }

    function remove_criteria(id) {
        $('#' + id).remove();
    }

</Script>