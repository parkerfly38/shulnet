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

$contact = new contact;
$data = $contact->get_contact($_POST['id']);

$qz = $db->get_eav_value('options', 'contact_quick_view');
$sp = new special_fields('contact');
$fields = explode(',', $qz);

?>

<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('assign_contact-add', '<?php echo $data['data']['id']; ?>', '1', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('assign_contact-add','<?php echo $data['data']['id']; ?>','1','popupform');">

    <div id="popupsave">
        <input type="submit" value="Save" class="save"/>
    </div>


    <h1>Assign Contact</h1>

    <div class="popupbody fullForm">

        <p class="highlight">Assign this contact to an employee and set expectations using this form.</p>

        <div class="col33l">

        <fieldset>
            <div class="pad">

                <label>Contact Overview</label>
                <dl class="horizontal">
                    <?php
                    foreach ($fields as $item) {
                        $sp->update_row($item);
                        $return = $sp->process($item, $data['data'][$item]);
                        $name   = $sp->clean_name($item);
                        echo "<dt>" . $name . "</dt>
                            <dd>" . $return . "</dd>";
                    }
                    ?>
                </dl>
                <div class="clear"></div>
            </div>
        </fieldset>

        </div>
        <div class="col66r">

        <fieldset>
            <div class="pad">

            <label>Assign To</label>
            <?php
            echo $af->staffList('owner', $data['owner']['id'], 'req');
            ?>

            <label>Account</label>
            <?php
            echo $af->accountList('account', $data['account']['id'], 'req');
            ?>

            <label>Source</label>
            <?php
            echo $af->sourceList('source', $data['data']['source'], 'req');
            ?>

            <label>Expected Value</label>
            <?php
            echo $af->setRightText(CURRENCY_SYMBOL)
                ->string('expected_value', $data['data']['expected_value'], 'req');
            ?>

            <label>Who can manage this contact?</label>
            <?php
            echo $af->radio('public', $data['data']['public'], array(
                '1' => 'All employees',
                '0' => 'Only the assignee and admins',
            ));
            ?>

            </div>
        </fieldset>

    </div>


</form>