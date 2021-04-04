<?php

if (empty($_POST['id'])) {
    $admin->show_popup_error('No conversion selected.');

} else {
    $contact = new contact;
    $details = $contact->get_conversion($_POST['id']);
    if (empty($details)) {
        $admin->show_popup_error('Conversion not found.');

    } else {
        ?>



        <div id="popupsave">

            <input type="button" value="View Contact"
                   onclick="return load_page('contact','view','<?php echo $details['contact_id']; ?>');"/>

            <?php

            if (!empty($details['user_id'])) {
                echo "<input type=\"button\" value=\"View Member\" onclick=\"return load_page('member','view','" . $details['user_id'] . "');\" />";

            }

            ?>

        </div>

        <h1>Conversion Details</h1>



        <div class="pad24t popupbody">


            <fieldset>

                <legend>Overview</legend>

                <div class="pad24t">

                    <dl>

                        <dt>Date</dt>

                        <dd><?php echo $details['date_show']; ?></dd>

                        <dt>Conversion Time</dt>

                        <dd><?php echo $details['time_to_convert']; ?></dd>

                        <dt>Converted By</dt>

                        <dd><?php $employee = $admin->get_employee('', $details['owner']);
                            echo $employee['username']; ?></dd>

                    </dl>

                    <div class="clear"></div>

                </div>

            </fieldset>


            <fieldset>

                <legend>Value</legend>

                <div class="pad24t">

                    <dl>

                        <dt>Expected Value</dt>

                        <dd><?php echo $details['estimated_formatted']; ?></dd>

                        <dt>Actual Value</dt>

                        <dd><?php echo $details['actual_formatted']; ?></dd>

                        <dt>Difference</dt>

                        <dd><?php echo $details['difference']; ?></dd>

                        <dt>Change</dt>

                        <dd><?php

                            if ($details['percent_change'] > 0) {
                                echo '<div class="positive">+' . $details['percent_change'] . '%</div>';

                            } else if ($details['percent_change'] < 0) {
                                echo '<div class="negative">-' . $details['percent_change'] . '%</div>';

                            } else {
                                echo '=';

                            }

                            ?></dd>

                    </dl>

                    <div class="clear"></div>

                </div>

            </fieldset>


        </div>

        <div class="clear"></div>



        </div>



    <?php

    }

}