<?php 

$curl_url = '';
$curl_qs = '';
$curl_xml = '';
$curl_headers = '';
$curl_credentials = '';
$mysql_commands = '';
$mysql_host = '';
$mysql_db = '';
$mysql_username = '';
$mysql_password = '';
$save = '';
$sms_message = '';
$sms_to = '';
$trackback = '';
$track_links = '';
$format = '';
$subject = '';
$message = '';
$to = '';
$from = '';
$cc = '';
$bcc = '';


if (! empty($_POST['id'])) {

    $widget = $db->get_hook($_POST['id']);

    $type = $widget['type'];
    
    $cid = $_POST['id'];
    $editing = '1';
    
    if ($type == '1') {
        $path = $widget['data'];
    } else {
        $data = unserialize($widget['data']);
    }
    $name = $widget['name'];
    $active = $widget['active'];
    $when = $widget['when'];
    $trigger = $widget['trigger'];
    $specific_trigger = $widget['specific_trigger'];
    $trigger_type = $widget['trigger_type'];

    if ($trigger_type == '1') {
        $specific_trigger_product = $specific_trigger;
        $specific_trigger_form = '';
        $cart = new cart;
        $specific_trigger_product_name = $cart->get_product_name($specific_trigger);
        $specific_trigger_form_name = '';
    }
    else if ($trigger_type == '2') {
        $specific_trigger_product = '';
        $specific_trigger_form = $specific_trigger;
        $form = new form;
        $specific_trigger_form_name = $form->get_form_name($specific_trigger);
        $specific_trigger_product_name = '';
    }

    
    if ($type == '2') {
        $save = $data['save'];
        $trackback = $data['trackback'];
        $track_links = $data['track_links'];
        $format = $data['format'];
        $subject = $data['subject'];
        $message = $data['message'];
        $to = $data['to'];
        $from = $data['from'];
        $cc = $data['cc'];
        $bcc = $data['bcc'];
    } 
    else if ($type == '3') {
        $mysql_host = decode($data['db_host']);
        $mysql_db = decode($data['db_name']);
        $mysql_username = decode($data['db_user']);
        $mysql_password = '';
        $mysql_commands = $data['commands'];
    }
    else if ($type == '5') {
        $curl_url = $data['url'];
        $curl_qs = $data['query_string'];
        $curl_xml = $data['xml'];
        $curl_headers = $data['headers'];
        $curl_credentials = $data['credentials'];
    }
    else if ($type == '6') {
        $sms_to = $data['to'];
        $sms_message = $data['message'];
    }

    
} else {
    $cid = 'new';
    $editing = '0';
    $path = PP_PATH . '/custom';
    $name = '';
    $type = $_POST['type'];
    $save = '1';
    $trackback = '1';
    $track_links = '0';
    $format = '1';
    $subject = '';
    $message = '';
    $to = '';
    $from = '';
    $cc = '';
    $bcc = '';

    $active = '1';
    $when = '2';
    $trigger = '';
    $specific_trigger = '0';
    $specific_trigger_product_name = '';
    $specific_trigger_form_name = '';
    $specific_trigger_form = '';
    $specific_trigger_product = '';
    $trigger_type = '0';
}

?>


<script type="text/javascript">
    $.ctrl('S', function () {
        return json_add('hook-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });
</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('hook-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


    <div id="popupsave">
        <input type="submit" value="Save" class="save" />
        <input type="hidden" name="type" value="<?php echo $type; ?>" />
    </div>

    <h1>Hook: PHP Code Execution</h1>
    <div class="popupbody">

    <script src="<?php echo PP_ADMIN; ?>/js/form_steps.js" type="text/javascript"></script>
    <ul id="step_tabs" class="popup_tabs">
        <li class="on">
            Overview
        </li><li>
            Specifics
        </li>
    </ul>

    <div id="step_1" class="step_form fullForm">

        <p class="highlight">Input the basic information that will control when this hook runs. Click on "Specifics" for more options.</p>

        <div class="col50l">
            <fieldset>
                <div class="pad">

                    <label>Hook Status</label>
                    <?php
                    echo $af->radio('active', $active, array(
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ));
                    ?>

                    <label>Reference Name</label>
                    <?php
                    echo $af
                        ->setDescription('Give this hook a name you can easily remember it by.')
                        ->string('name', $name, 'req');
                    ?>


                </div>
            </fieldset>
        </div>
        <div class="col50r">
            <fieldset>
                <div class="pad">

                    <label>What task should trigger this hook?</label>
                    <?php
                    $hookList = $db->hook_list($trigger, false);

                    $final = array();
                    foreach ($hookList as $key => $value) {
                        $final['GROUP' . uniqid()] = $key;
                        foreach ($value as $name => $item) {
                            $final[$name] = $item;
                        }
                    }

                    echo $af->select('trigger', $trigger, $final, 'req');
                    ?>

                    <label>When should this hook run?</label>
                    <?php
                    echo $af->radio('when', $when, array(
                        '1' => 'Before Task',
                        '2' => 'After Task',
                    ));
                    ?>


                    <script type="text/javascript">
                        $("input[type=radio]['trigger_type']").change(function() {
                            switch(this.value) {
                                case '0':
                                    return swap_multi_div('','specific_prod,specific_form');
                                case '1':
                                    return swap_multi_div('specific_prod','specific_form');
                                case '2':
                                    return swap_multi_div('specific_form','specific_prod');
                            }
                        });
                    </script>



                    <label>Is this for a specific trigger or any trigger?</label>
                    <?php
                    echo $af->radio('trigger_type', $trigger_type, array(
                        '0' => 'Apply to all tasks',
                        '1' => 'Apply to a specific product',
                        '2' => 'Apply to a specific form',
                    ));
                    ?>

                    <div id="specific_prod" style="display:<?php if ($trigger_type == '1') { echo "block"; } else { echo "none"; } ?>;">
                        <label>Specific Products</label>

                        <?php
                        echo $af
                            ->setDescription('Which product when purchased will trigger this task?')
                            ->productList('specific_prod', $specific_trigger_product);
                        ?>
                    </div>

                    <div id="specific_form" style="display:<?php if ($trigger_type == '2') { echo "block"; } else { echo "none"; } ?>;">
                        <label>Specific Form</label>
                        <?php
                        echo $af
                            ->setDescription('Which form when submitted will trigger this task?')
                            ->formList('specific_form', $specific_trigger_form);
                        ?>
                    </div>



                </div>
            </fieldset>
        </div>

        </div>
        <div id="step_2" class="step_form fullForm" style="display:none;">

        <?php
        if ($type == '1') {
        ?>
            <p class="highlight">Tell Zenbership where the PHP file is located on your server that will run when the hook is triggered.</p>

            <fieldset>
            <div class="pad">

                    <label>Path to File</label>
                    <?php
                    echo $af
                        ->setDescription('Where is the PHP file that will be exectued located on the server? Remember to read the documentation for information on how to properly create hook files! Not doing so can result in program crashes and incomplete tasks.')
                        ->string('path', $path, 'req');
                    ?>

            </div>
        </fieldset>
        <?php
        }
        else if ($type == '2') {
        ?>
            <p class="highlight">Create the e-mail that will be sent when the hook is triggered below. Consult the documentation for information on which caller tags are available to you.</p>

            <fieldset>
            <legend>E-Mail Hook</legend>
            <div class="pad">

                <div class="col50l">

                        <label>To</label>
                        <?php
                        echo $af
                            ->string('data[to]', $to, 'req');
                        ?>

                        <label>From</label>
                        <?php
                        echo $af
                            ->string('data[from]', $from);
                        ?>

                        <label>CC</label>
                        <?php
                        echo $af
                            ->string('data[cc]', $cc);
                        ?>

                        <label>BCC</label>
                        <?php
                        echo $af
                            ->string('data[bcc]', $bcc);
                        ?>
                
                </div>
                <div class="col50r">

                        <label>Save</label>
                        <?php
                        echo $af->radio('data[save]', $save, array(
                            '1' => 'Save a copy',
                            '0' => 'Do NOT save a copy',
                        ));
                        ?>

                        <label>Tracking</label>
                        <?php
                        echo $af->radio('data[trackback]', $trackback, array(
                            '1' => 'Track when the email has been opened',
                            '0' => 'Do NOT track when the email has been opened',
                        ));
                        ?>

                        <label>Link Clicking</label>
                        <?php
                        echo $af->radio('data[track_links]', $track_links, array(
                            '1' => 'Track when links in the email have been clicked',
                            '0' => 'Do NOT track when links in the email have been clicked',
                        ));
                        ?>

                        <label>Format</label>
                        <?php
                        echo $af->radio('data[format]', $format, array(
                            '1' => 'Send in HTML format email',
                            '0' => 'Send as a plain text email',
                        ));
                        ?>
                    
                </div>
                <div class="clear"></div>

                <label>Subject</label>
                <?php
                echo $af
                    ->string('data[subject]', $subject, 'req');
                ?>

                <label class="top">Message</label>
                <?php
                echo $af
                    ->richtext('data[message]', $message, '350');
                ?>
                
            </div>
        </fieldset>
        <?php
        }
        else if ($type == '6') {
            ?>

            <p class="highlight">Sends an SMS to an eligible user. Note that for this to function you have have a SMS plugin active, and the user receiving the SMS must have a valid cell phone number on file.</p>

            <fieldset>
                <div class="pad">

                    <label>Send To</label>
                    <?php
                    echo $af
                        ->setPlaceholder('Example: +14449998888 or %data:cell%')
                        ->setDescription('Input the full phone number, including +1 to which the SMS is being sent. Enter %data:cell% to send the triggering user an SMS.')
                        ->string('data[to]', $sms_to);
                    ?>

                    <label>Outgoing Message</label>
                    <?php
                    echo $af
                        ->setPlaceholder('Example: my_db_name')
                        ->setDescription('Please note that you can use eligible %cAlLeR_TaGs% in the outgoing message.')
                        ->string('data[message]', $sms_message);
                    ?>

                </div>
            </fieldset>
            <?php
        }
        else if ($type == '3') {
        ?>
            <p class="highlight">Runs a MySQL command when the hook is triggered. Be very careful using this: only run hooks if you have a good understanding of MySQL databases.</p>

            <fieldset>
                <div class="pad">

                <div class="col50l">

                    <label>MySQL Server Host</label>
                    <?php
                    echo $af
                        ->setPlaceholder('Example: localhost')
                        ->string('data[db_host]', $mysql_host);
                    ?>

                    <label>MySQL Database Name</label>
                    <?php
                    echo $af
                        ->setPlaceholder('Example: my_db_name')
                        ->string('data[db_name]', $mysql_db);
                    ?>

                </div>
                <div class="col50r">

                    <label>MySQL User Username</label>
                    <?php
                    echo $af
                        ->setPlaceholder('Example: my_user_username')
                        ->string('data[db_user]', $mysql_username);
                    ?>

                    <label>MySQL User Password</label>
                    <?php
                    echo $af
                        ->setPlaceholder('Example: my_user_password')
                        ->string('data[db_pass]', $mysql_password);
                    ?>

                </div>
                <div class="clear"></div>

                <label class="top">Commands</label>
                <div class="clear"></div>
                <?php
                echo $af
                    ->textarea('data[commands]', $mysql_commands, 'req', '', 'commands');
                ?>

            </div>
        </fieldset>
        <?php
        }
        else if ($type == '5') {
        ?>
            <p class="highlight">Use cURL to connect to an outside service. This is designed for basic requested: if you need for control over the request, please create a PHP script hook to code the cURL request.</p>

            <fieldset>
            <div class="pad24t">
                
                <div class="col50l">

                    <label>URL</label>
                    <?php
                    echo $af
                        ->setPlaceholder('http://www.outsideservice.com/script.php')
                        ->string('data[url]', $curl_url);
                    ?>

                    <label>Query String</label>
                    <?php
                    echo $af
                        ->string('data[query_string]', $curl_qs);
                    ?>
                    
                </div>
                <div class="col50r">

                    <label>Data Transfer Type</label>
                    <?php
                    echo $af
                        ->radio('data[xml]', $curl_xml, array(
                            '0' => 'Query String',
                            '1' => 'XML',
                        ));
                    ?>

                    <label>Headers</label>
                    <?php
                    echo $af
                        ->string('data[headers]', $curl_headers);
                    ?>

                    <label>Credentials</label>
                    <?php
                    echo $af
                        ->string('data[credentials]', $curl_credentials);
                    ?>

                </div>
                <div class="clear"></div>

            </div>
        </fieldset>
        <?php
        }
        ?>
        
    </div>
    </div>

</form>


<script type="text/javascript">
    function check_folder() {
        send_data = 'path=' + $('#path').val();
        $.post('cp-functions/check_folder.php', send_data, function (theResponse) {
            $('#preview_path').html(theResponse);
        });
        return false;
    }
</script>