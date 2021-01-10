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
        return json_add('widget-add', 'new', '0', 'popupform');
    });

</script>


<form action="" method="post" id="popupform" onsubmit="return json_add('widget-add','new','0','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>

        <input type="hidden" name="type" value="html"/>

        <input type="hidden" name="id" value="new"/>

    </div>

    <h1>Creating Widget</h1>

    <div class="fullForm popupbody">

        <p class="highlight">Once created, you can include an widget on any template or page using the {-WIDGET_ID_HERE-} syntax.</p>

        <fieldset>
            <div class="pad24t">

                <div class="field">
                    <label class="less">Name</label>
                    <div class="field_entry_less">
                        <input type="text" name="name" id="name" value="" maxlength="45" class="req" style="width:300px;"/>
                    </div>
                </div>

                <div class="field">
                    <textarea name="content" id="content" style="width:100%;height:400px;" class="req"></textarea>
                </div>

                <?php
                echo $admin->richtext('100%', '500px', 'content');
                ?>

            </div>
        </fieldset>

    </div>

</form>

