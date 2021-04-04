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


$depts = explode(',', $db->get_option('departments'));

?>

<script type="text/javascript">
    $.ctrl('S', function () {
        return json_add('department-add', 'x', '0', 'popupform');
    });
</script>


<form action="" method="post" id="popupform" onsubmit="return json_add('department-add','x','0','popupform');">

    <div id="popupsave">
        <input type="submit" value="Save" class="save"/>
    </div>
    <h1>Section Management</h1>

    <div class="fullForm popupbody">

        <p class="highlight">Create, edit, or remove departments to which your employees will be assigned.</p>

        <fieldset>
            <div class="pad">

                <div id="thedepts">
                    <?php
                    foreach ($depts as $aDep) {
                        ?>

                        <div class="field">
                            <input type="text" name="department[<?php echo $aDep; ?>]" style="width:100%;"
                                   value="<?php echo $aDep; ?>"/>
                        </div>

                    <?php
                    }
                    ?>
                </div>

                <div class="field">
                    <a href="null.php" onclick="return add_dept();">[+] Add New Department</a>
                </div>

            </div>
        </fieldset>

    </div>

</form>

<script type="text/javascript">
    function add_dept() {
        var html = '<div class="field">';
        html += '<input type="text" name="department[]" style="width:100%;" value="" />';
        html += '</div>';
        $('#thedepts').append(html);
        return false;
    }
</script>