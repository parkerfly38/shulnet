<?php 


$data = new history($_POST['id'], '', '', '', '', '', 'ppSD_saved_emails');

if ($data->final_content['user_type'] == 'contact') {
    $contact = new contact;
    $cdata   = $contact->get_contact($data->final_content['user_id']);
    $theuser = "<a href=\"#\" onclick=\"return load_page('contact','view','" . $cdata['data']['id'] . "');\">Contact " . $cdata['data']['last_name'] . ", " . $cdata['data']['first_name'] . "</a>";
}
else if ($data->final_content['user_type'] == 'member') {
    $user    = new user;
    $cdata   = $user->get_user($data->final_content['user_id']);
    $theuser = "<a href=\"#\" onclick=\"return load_page('member','view','" . $cdata['data']['id'] . "');\">Member " . $cdata['data']['last_name'] . ", " . $cdata['data']['first_name'] . "</a>";
}

$connect = new connect;
$trackback = $connect->get_trackback($_POST['id'], 'email_id');

if ($data->final_content['fail'] == '2') {
    $bounced = $connect->get_bounced($_POST['id']);
} else {
    $bounced = array();
}

?>



<div id="popupsave">

    <input type="button" value="Re-send" class="save"
           onclick="return resend_email('<?php echo $data->{'final_content'}['id']; ?>');"/> <input type="button"
                                                                                                    value="Delete"
                                                                                                    class="del"
                                                                                                    onclick="return delete_item('ppSD_saved_emails','<?php echo $data->{'final_content'}['id']; ?>','','','2');"/>

</div>

<h1>Viewing Sent E-Mail</h1>


<div class="fullForm popupbody">

    <fieldset>
        <div class="pad">

        <div class="col50l">
            <dl>
                <dt>Date</dt>
                <dd><?php echo format_date($data->final_content['date']); ?></dd>
                <dt>User</dt>
                <dd><?php echo $theuser; ?></dd>
                <dt>To</dt>
                <dd><?php echo $data->final_content['to']; ?></dd>
                <dt>From</dt>
                <dd><?php echo $data->final_content['from']; ?></dd>
                <dt>Subject</dt>
                <dd><?php echo $data->final_content['subject']; ?></dd>
            </dl>
            <div class="clear"></div>


        </div>

        <div class="col50r">


            <dl>

                <dt>Status</dt>
                <?php
                if ($data->final_content['fail'] == '1') {
                    ?>
                    <dd>Failed</dd>
                    <dt>Reason</dt>
                    <dd><?php echo $data->final_content['fail_reason']; ?></dd>
                <?php
                } else if ($data->final_content['fail'] == '2') {
                    ?>
                    <dd>Bounced</dd>
                    <dt>Date Bounced</dt>
                    <dd><?php echo format_date($bounced['date']); ?></dd>
                <?php

                } else {
                    ?>

                    <dd>Success</dd>

                <?php

                }

                ?>

                <?php

                if ($trackback['error'] == '1') {
                    echo "<dt>Opened?</dt>";
                    echo "<dd>No data available.</dd>";

                } else {
                    echo "<dt>Opened?</dt>";
                    if ($trackback['status'] == '1') {
                        echo "<dd>Opened</dd>";
                        echo "<dt>First Opened</dt>";
                        echo "<dd>" . format_date($trackback['viewed']) . "</dd>";
                        echo "<dt>Last Opened</dt>";
                        echo "<dd>" . format_date($trackback['last_viewed']) . "</dd>";
                        echo "<dt>Times Opened</dt>";
                        echo "<dd>" . $trackback['times_opened'] . "</dd>";

                    } else {
                        echo "<dd>Not Opened</dd>";

                    }

                }

                ?>

            </dl>


        </div>

        <div class="clear"></div>

            </div>
        </fieldset>

    <div class="field">

        <iframe width="100%" height="600" frameborder='0'
                src="cp-functions/get_saved_email.php?id=<?php echo $data->final_content['id']; ?>"
                style="border: 1px solid #ccc;"></iframe>

    </div>

</div>