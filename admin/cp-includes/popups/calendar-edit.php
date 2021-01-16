<?php ShulNET
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
if (!empty($_POST['id'])) {
    $event = new event;
    $data  = $event->get_calendar($_POST['id']);
    // $data = new history($_POST['id'],'','','','','','ppSD_cart_terms');
    $cid     = $_POST['id'];
    $editing = '1';
} else {
    $data    = array(
        'name'         => '',
        'template'     => '',
        'members_only' => '0',
        'owner'        => '',
        'style'        => '1',
    );
    $cid     = generate_id('random', '8');
    $editing = '0';
}
?>
<script type="text/javascript">
    $.ctrl('S', function () {
        return json_add('calendar-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>');
    });
</script>
<form action="" method="post" id="popupform"
      onsubmit="return json_add('calendar-add','<?php echo $cid; ?>','<?php echo $editing; ?>');">
    <div id="popupsave">
        <input type="submit" value="Save" class="save"/>
    </div>
    <h1>Calendar Management</h1>

    <div class="popupbody fullForm">
        <p class="highlight">Calendars allow you to group events.</p>

        <fieldset>
            <div class="pad24t">

                    <label>Name</label>
                    <?php
                    echo $af->string('name', $data['name'], 'req');
                    ?>

                    <label>Who can view this calendar?</label>
                    <?php
                    echo $af
                        ->setDescription('Determines whether only members can view this calendar online.')
                        ->radio('members_only', $data['members_only'], array(
                        '0' => 'Members and non-members',
                        '1' => 'Members only',
                    ));
                    ?>

                    <label>How should this calendar be laid out?</label>
                    <?php
                    echo $af
                        ->setDescription('Month view is the traditional calendar layour, while long list view displays events as a list.')
                        ->radio('style', $data['style'], array(
                            '1' => 'Standard Month View',
                            '2' => 'Long List View',
                        ));
                    ?>

                <label>Would you like to use a custom template to render this calendar?</label>
                <?php
                $custom_templates = $db->custom_templates('', 'array');

                echo $af
                    ->setDescription('Zenbership gives you the ability to create a custom HTML template and then use it to render the calendar, replacing the standard calendar template in the process.')
                    ->select('template', $data['template'], $custom_templates);
                ?>

            </div>
        </fieldset>

    </div>

</form>