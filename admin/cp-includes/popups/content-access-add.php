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

if (!empty($_POST['id'])) {
    $content = new content;
    $data    = $content->get_content_access($_POST['id']);
    $cdata   = $content->get_content($data['content_id']);
    $cid     = $data['id'];
    $user_id = $data['member_id'];
    $cname   = $cdata['name'];
    $editing = '1';
    $expires = $data['expires'];

} else {
    $cid     = '';
    $user_id = $_POST['user_id'];
    $cname   = '';
    $editing = '0';
    $expires = '';
}

?>

<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('content_access-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('content_access-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


    <div id="popupsave">
        <input type="submit" value="Save" class="save"/>
    </div>

    <h1>Manage Content Access</h1>

    <input type="hidden" name="member_id" value="<?php echo $user_id; ?>"/>
    <input type="hidden" name="id" value="<?php echo $cid; ?>"/>

    <div class="pad24t popupbody fullForm">

        <p class="highlight">Granting access to content allows a member to view that content until a specific date.</p>

        <fieldset>
            <div class="pad">
                <label>What content should this member be given access to?</label>
                <?php
                echo $af->contentList('content_id', $cid);
                ?>

                <label>When should access to the content expire?</label>
                <?php
                echo $af
                    ->setSpecialType('date')
                    ->string('expires', $expires);
                ?>
            </div>
        </fieldset>

    </div>

</form>