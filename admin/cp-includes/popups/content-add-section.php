<?php 



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


$type = 'section';

if (!empty($_POST['id'])) {
    $content = new content;
    $data    = $content->get_section($_POST['id']);
    if ($data['error'] == '1') {
        $admin->show_popup_error($data['error_details']);
        exit;

    } else {
        $cid     = $_POST['id'];
        $editing = '1';

    }

} else {
    $temp_data = '';
    $data      = array(
        'name'         => '',
        'display_name' => '',
        'url'          => '',
        'secure'       => '0',
        'permalink_clean' => '',
    );
    $cid       = 'new';
    $editing   = '0';

}

?>





<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('content-section-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('content-section-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


    <div id="popupsave">
        <?php
        if (! empty($_POST['id'])) {
            ?>
            <input type="submit" value="Grant Access From Criteria" onclick="return switch_popup('build_criteria','type=member&act=content_access&act_id=<?php echo $cid; ?>','');" />
        <?php
        }
        ?>
        <input type="submit" value="Save" class="save"/>
        <input type="hidden" name="type" value="<?php echo $type; ?>"/>
    </div>

    <h1>Section Management</h1>


    <div class="fullForm popupbody">

        <p class="highlight">A section is an area on your website into which you can categorize pages.</p>


        <fieldset>
            <div class="pad">

                <label>What should the permalink be for this section?</label>
                <?php
                echo $af
                    ->setId('permalink')
                    ->setPlaceholder('My_Sections_Permalink')
                    ->string('permalink', $data['permalink_clean'], 'req');
                ?>
                <p class="field_desc" id="preview_permalink"></p>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#permalink').keyup(function() {
                            return check_permalink();
                        });
                    });
                </script>

            </div>
        </fieldset>




        <fieldset>

            <legend>Basic Details</legend>

            <div class="pad24t">


                <div class="field">

                    <label>Permalink Name</label>

                    <div class="field_entry">

                        <input type="text" name="name" class="req letnum" id="name" style="width:300px;"
                               value="<?php echo $data['permalink_clean']; ?>"/>

                        <p class="field_desc">This is the name that will appear in your web browser's URL bar. Letters,
                            spaces, and unscores only!</p>

                    </div>

                </div>


                <div class="field">

                    <label>Display Name</label>

                    <div class="field_entry">

                        <input type="text" name="display_name" class="req" id="display_name" style="width:300px;"
                               value="<?php echo $data['name']; ?>"/>

                        <p class="field_desc">This is the name that will appear to users in breadcrumbs.</p>

                    </div>

                </div>


                <div class="field">

                    <label>Secure?</label>

                    <div class="field_entry">

                        <input type="radio" name="secure" value="1" <?php if ($data['secure'] == '1') {
                            echo " checked=\"checked\"";
                        } ?> /> Secure (Members with access only)<br/>

                        <input type="radio" name="secure" value="0" <?php if ($data['secure'] != '1') {
                            echo " checked=\"checked\"";
                        } ?> /> Not Secure (open to the public)

                        <p class="field_desc">Is this section secure or open to the public?</p>

                    </div>

                </div>


            </div>

        </fieldset>


    </div>


</form>


<script type="text/javascript">

    function check_permalink() {
        send_data = 'section=' + $('#section').val() + '&id=<?php echo $cid; ?>&permalink=' + $('#permalink').val();
        $.post('cp-functions/preview_permalink.php', send_data, function (theResponse) {
            $('#preview_permalink').html(theResponse);
        });
        return false;
    }

</script>