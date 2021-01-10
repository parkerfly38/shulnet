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


$type = 'redirect';

if (!empty($_POST['id'])) {
    $content = new content;
    $data    = $content->get_content($_POST['id']);
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
        'name'            => '',
        'menus'           => array(),
        'url'             => '',
        'permalink'       => '',
        'permalink_clean' => '',
        'full_link'       => PP_URL,
    );
    $cid       = 'new';
    $editing   = '0';

}

?>





<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('content-redirect-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('content-redirect-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">

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

    <h1>Redirection Management</h1>

    <div class="fullForm popupbody">

            <p class="highlight">A redirection is a placeholder link that will redirect users to a separate paeg when clicked. This is generally used to "mask" an external link that you are selling access to.</p>

            <div class="col50l">

                <fieldset>
                    <div class="pad">

                        <label>What should this redirect be called?</label>
                        <?php
                        echo $af
                            ->setDescription('This is what users will see when it is added to a menu.')
                            ->string('name', $data['name'], 'req');
                        ?>

                        <label>What link should the user see before they are redirected?</label>
                        <?php
                        echo $af
                            ->setDescription($data['full_link'])
                            ->setId('permalink')
                            ->string('permalink', $data['permalink_clean'], 'req');
                        ?>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#permalink').keyup(function() {
                                    return check_permalink();
                                });
                            });
                        </script>

                        <label>Where should the user be redirected to after clicking the link?</label>
                        <?php
                        echo $af
                            ->setDescription('This is what users will see when it is added to a menu.')
                            ->setPlaceholder('http://www.someothersite.com/')
                            ->string('url', $data['url'], 'req');
                        ?>

                    </div>
                </fieldset>

            </div>
            <div class="col50r">

                <fieldset>
                    <div class="pad">

                        <fieldset>
                            <div class="pad">
                                <label>What menus should this appear in?</label>
                                <?php
                                echo $admin->get_menus($data['menus']);
                                ?>
                            </div>
                        </fieldset>

                    </div>
                </fieldset>

            </div>

    </div>

</form>


<script type="text/javascript">

    function check_permalink() {
        send_data = 'section=&id=<?php echo $cid; ?>&permalink=' + $('#permalink').val();
        $.post('cp-functions/preview_permalink.php', send_data, function (theResponse) {
            $('#preview_permalink').html(theResponse);
        });
        return false;
    }

</script>