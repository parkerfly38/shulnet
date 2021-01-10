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
if (! empty($_POST['id'])) {

    $contact = new contact;
    $get = $contact->get_contact($_POST['id']);

?>


    <script type="text/javascript">

        $.ctrl('S', function () {
            return json_add('contact-merge', '<?php echo $_POST['id']; ?>', '<?php echo $editing; ?>', 'popupform');
        });

    </script>


    <form action="" method="post" id="popupform"
          onsubmit="return json_add('contact-merge','<?php echo $_POST['id']; ?>','<?php echo $editing; ?>','popupform');">


        <div id="popupsave">
            <input type="hidden" name="dud_quick_add" value="1"/>
            <input type="submit" value="Save" class="save"/>
        </div>

        <h1>Merge Contacts</h1>

        <div class="popupbody">

            <p class="highlight">Use this form to merge one or more contacts into a primary contact.</p>

            <div class="col-2">

                <fieldset>
                    <div class="pad fullForm">

                        <h3>Primary Contact</h3>

                        <p>Contacts to the right are being merged into this contact below.</p>

                        <dl>
                            <dt>ID</dt>
                            <dd><?php echo $get['data']['id']; ?></dd>
                            <dt>Name</dt>
                            <dd><?php echo $get['data']['last_name'] . ', ' . $get['data']['first_name']; ?></dd>
                            <dt>Created</dt>
                            <dd><?php echo $get['dates']['created'] . ' (' . $get['dates']['created_time'] . ')'; ?></dd>
                            <dt>Last Action</dt>
                            <dd><?php echo $get['dates']['last_action']; ?></dd>
                            <dt>Next Action</dt>
                            <dd><?php echo $get['dates']['next_action']; ?></dd>
                        </dl>

                    </div>
                </fieldset>

            </div>
            <div class="col-2">

                <fieldset>
                    <div class="pad fullForm">

                        <h3>Contacts Being Merged Into</h3>

                        <p>These contacts will be merged into the contact on the left. Information already associated with the contact on the left remains, missing information will be used from these contacts to "fill in the gaps". Fields that are searchable include first name, last name, and company name.</p>

                        <input type="text" name="_dud_contacts" id="merge_into" style="width:100%;"
                               autocomplete="off" onkeyup="return autocom('merge_into', 'contact_id', 'contact_id,last_name,first_name', 'ppSD_contact_data', 'first_name,last_name,company_name', '', '1');" value=""/>

                    </div>
                </fieldset>

            </div>


    </form>

<?php
} else {

    echo 'Error - you need to select a primary contact to merge other contacts into.';

}
?>