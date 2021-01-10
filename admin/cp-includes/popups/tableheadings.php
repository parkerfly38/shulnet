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

?>


<script type="text/javascript">
    $.ctrl('S', function () {
        return json_add('tableheadings-add', 'x', '1', 'popupform');
    });
</script>


<form action="" method="post" id="popupform" onsubmit="return json_add('tableheadings-add','x','1','popupform');">

    <div id="popupsave">
        <input type="submit" value="Save" class="save"/>
        <input type="hidden" name="perm" value="<?php echo $_POST['type']; ?>"/>
    </div>
    <h1>Customize Tableheadings</h1>
    <div class="pad24t popupbody">
        <ul class="popup_tableheadings">
            <?php
            // Table headings
            $permission = $_POST['type'];
            $headings = $db->get_option($permission . '_headings_' . $employee['id']);

            // Get this user's headings.
            if (!empty($headings)) {
                $menu = explode(',', $headings);
            } else {
                if ($employee['permissions']['admin'] == '1') {
                    $opt = $db->get_option($permission . '_headings_admin');
                }
                if (empty($opt)) {
                    $opt = $db->get_option($permission . '_headings');
                }
                $menu = explode(',', $db->get_option($permission . '_headings'));
            }

            // Get possible options.
            //
            // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
            // Note: 2014-06-12
            // fields_in_scope() doesn't work because it doesn't
            // include the primary fields for the scope. This needs to
            // be added in future versions of the program.
            if ($_POST['type'] == 'contact') {
                $show       = '1';

                /*
                $contact = new contact();
                $primary_fields = $contact->get_primary_fields();
                unset($primary_fields['converted_id']);
                unset($primary_fields['email_pref']);
                unset($primary_fields['public']);
                $secondary_fields = $db->fields_in_scope('contact');
                $scope_data = array_merge($primary_fields, $secondary_fields);
                */

                $eav        = $db->get_eav_value('options', 'contact_print');
                $more       = $db->fields_in_scope('contact');
                $scope_data = array_unique(array_merge(explode(',', $eav), $more));
            }
            else if ($_POST['type'] == 'member') {
                $show       = '1';

                /*
                $user = new user();
                $primary_fields = $user->get_primary_fields();
                unset($primary_fields['salt']);
                unset($primary_fields['password']);
                unset($primary_fields['email_pref']);
                unset($primary_fields['member_id']);
                $secondary_fields = $db->fields_in_scope('member');
                $scope_data = array_merge($primary_fields, $secondary_fields);
                */

                $eav        = $db->get_eav_value('options', 'member_print');
                // $scope_data = explode(',', $eav);
                $more       = $db->fields_in_scope('member');
                $scope_data = array_unique(array_merge(explode(',', $eav), $more));
            }
            else if ($_POST['type'] == 'account') {
                $show       = '1';
                //$scope_data     = $db->fields_in_scope('account');
                $eav        = $db->get_eav_value('options', 'account_print');
                // $scope_data = explode(',', $eav);
                $more       = $db->fields_in_scope('account');
                $scope_data = array_unique(array_merge(explode(',', $eav), $more));
            }
            else if ($_POST['type'] == 'event') {
                $show       = '1';
                $eav        = $db->get_eav_value('options', 'event_headings');
                $scope_data = explode(',', $eav);
            }
            else if ($_POST['type'] == 'rsvp') {
                $show       = '1';
                //$scope_data     = $db->fields_in_scope('rsvp');
                $eav        = $db->get_eav_value('options', 'rsvp_print');
                // $scope_data = explode(',', $eav);
                $more       = $db->fields_in_scope('rsvp');
                $scope_data = array_unique(array_merge(explode(',', $eav), $more));
            }
            else if ($_POST['type'] == 'note') {
                $show       = '1';
                $eav        = $db->get_eav_value('options', 'note_print');
                $scope_data = explode(',', $eav);
            }
            else if ($_POST['type'] == 'transaction') {
                $show       = '1';
                $eav        = $db->get_eav_value('options', 'transaction_headings');
                $scope_data = explode(',', $eav);
            }
            else {
                $show = '0';
                echo "<li>No options for this table.</li>";
            }

            // Loop options.
            if ($show == '1') {
                foreach ($scope_data as $item) {
                    if (in_array($item, $menu)) {
                        echo "<li><input type=\"checkbox\" name=\"" . $item . "\" value=\"1\" checked=\"checked\" /> " . $item . "</li>";
                    } else {
                        echo "<li><input type=\"checkbox\" name=\"" . $item . "\" value=\"1\" /> " . $item . "</li>";
                    }
                }
            }

            ?>

        </ul>

        <div class="clear"></div>


    </div>


</form>