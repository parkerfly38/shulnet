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
if (empty($_POST['form_id'])) {
    echo $admin->show_popup_error('No form submitted.');

} else {
    $cid = $_POST['form_id'];
    if (empty($_POST['page'])) {
        $page = 1;

    } else {
        $page = $_POST['page'];

    }
    if ($page == 1) {
        $prev_page = 1;
        $next_page = 2;

    } else {
        $prev_page = $page - 1;
        $next_page = $page + 1;

    }



    ?>



    <h1>Managing Codes</h1>



    <div class="popupbody fullForm">


    <ul id="theStepList">

        <li class="on" onclick="return goToStep('0');">Import Codes</li>

        <li onclick="return goToStep('1');">Existing Codes</li>

    </ul>


    <ul id="formlist">

    <li class="form_step">


        <script type="text/javascript">

            $.ctrl('S', function () {
                return json_add('reg_codes-add', '<?php echo $cid; ?>', '0', 'popupform');
            });

        </script>


        <form action="" method="post" id="popupform"
              onsubmit="return json_add('reg_codes-add','<?php echo $cid; ?>','0','popupform');">


            <fieldset>
            <div class="pad24t">


                <div class="field">

                    <label>Type</label>

                    <div class="field_entry">

                        <input type="radio" onclick="return swap_div('code_gen','code_list');" name="code_type"
                               value="gen"/> Generate Unassigned Codes<br/>

                        <input type="radio" onclick="return swap_div('code_list','code_gen');" name="code_type"
                               value="email" checked="checked"/> Import list with assigned e-mails

                    </div>

                </div>


                <div class="field">

                    <label>Format</label>

                    <div class="field_entry">

                        <input type="text" name="format" value="random" maxlength="29" style="width:250px;"/>

                        <p class="field_desc">If you would like to set a fixed format for IDs generated, do so
                            above.<br/>L = Upper case letter.<br/>l = lower case letter<br/>n = number<br/>random =
                            Randomly generated codes</p>

                    </div>

                </div>


                <div id="code_list" style="display:block;">


                    <div class="field">

                        <label class="top">E-Mail List</label>

                        <div class="field_entry_top">

                            <textarea name="codes" cols="50" rows="40" style="width:100%;height:500px;"></textarea>

                            <p class="field_desc">Input e-mails, one per line. Each email will receive a registration
                                link with a code embedded.</p>

                        </div>

                    </div>


                </div>

                <div id="code_gen" style="display:none;">


                    <div class="field">

                        <label>Number</label>

                        <div class="field_entry">

                            <input type="text" name="qty" value="" class="zen_num" style="width:100px;"/>

                        </div>

                    </div>


                </div>


                <div class="submit">

                    <input type="submit" class="save" value="Generate Codes"/>

                </div>

            </div>
            </fieldset>

        </form>


    </li>

    <li class="form_step">


        <form action="" id="popuptable">


            <div id="popup_table_top">

                <div id="popup_table_right">

                    <a href="returnnull.php"
                       onclick="return switch_popup('form_codes','form_id=<?php echo $_POST['form_id']; ?>&page=<?php echo $prev_page; ?>&load_tab=1');"
                       class="l">&laquo; Previous</a>

                    <a href="returnnull.php"
                       onclick="return switch_popup('form_codes','form_id=<?php echo $_POST['form_id']; ?>&page=<?php echo $next_page; ?>&load_tab=1');"
                       class="l">Next &raquo;</a>

                </div>

                <div id="popup_table_left">

                    <a href="returnnull.php"
                       onclick="return switch_popup('form_codes','form_id=<?php echo $_POST['form_id']; ?>&page=1&load_tab=1');"
                       class="r">All</a>

                    <a href="returnnull.php"
                       onclick="return switch_popup('form_codes','form_id=<?php echo $_POST['form_id']; ?>&page=1&filter=unused&load_tab=1');"
                       class="r">Unused</a>

                    <a href="returnnull.php"
                       onclick="return switch_popup('form_codes','form_id=<?php echo $_POST['form_id']; ?>&page=1&filter=used&load_tab=1');"
                       class="r">Used</a>

                </div>

                <div class="clear"></div>

            </div>


            <table class="tablesorter listings popuptable" id="active_table" border="0" id="poptable">
                <thead>

                <th class="first" width="24"><a href="null.php" onclick="return check_all('poptable');"><img
                            src="<?php echo PP_ADMIN; ?>/imgs/icon-tick.png" width="10" height="7" border="0"
                            alt="Check All" title="Check All"/></a></th>

                <th>Code</th>

                <th>Used?</th>

                <th>Sent To</th>

                <th width="24">&nbsp;</th>

                </thead>

                <tbody>

                <?php





                if (!empty($_POST['filter'])) {
                    if ($_POST['filter'] == 'used') {
                        $where_add = " AND `used`!='1'";

                    } else if ($_POST['filter'] == 'unused') {
                        $where_add = " AND `used`='1'";

                    }

                } else {
                    $where_add = '';

                }

                $limit = $page * 30 - 30;

                $q1 = $db->run_query("

                    SELECT *

                    FROM `ppSD_form_closed_sessions`

                    WHERE `form_id`='" . $db->mysql_clean($_POST['form_id']) . "'$where_add

                    ORDER BY `date_issued` DESC

                    LIMIT $limit,30

                ");

                $found = 0;

                while ($row = $q1->fetch()) {
                    $found++;
                    if ($row['used'] == '1') {
                        $status = format_date($row['date_used']);
                        $class  = "dead";

                    } else {
                        $status = 'No';
                        $class  = "";

                    }
                    echo "<tr id=\"td-cell-" . $row['code'] . "\" class=\"$class\">

                    <td><input type=\"checkbox\" name=\"" . $row['code'] . "\" value=\"1\" /></td>

                    <td>" . $row['code'] . "</td>

                    <td>" . $status . "</td>

                    <td>" . $row['sent_to'] . "</td>

                    <td><a href=\"return_null.php\" onclick=\"return delete_item('ppSD_form_closed_sessions','" . $row['code'] . "');\"><img src=\"imgs/icon-delete.png\" width=\"16\" height=\"16\" border=\"0\" class=\"option_icon\" alt=\"Delete\" title=\"Delete\" /></a></td>

                    </tr>";

                }

                if ($found <= 0) {
                    echo "<tr>

                    <td colspan=\"5\" class=\"weak\">No codes have been issued for this form.</td>

                    </tr>";

                }



                ?>

                </tbody>

            </table>

            <div id="bottom_delete">
                <div class="pad16"><span class="small gray caps bold"
                                         style="margin-right:24px;">With Selected:</span><input type="button"
                                                                                                value="Delete"
                                                                                                class="del"
                                                                                                onclick="return compile_delete('ppSD_form_closed_sessions','popuptable');"/>
                </div>
            </div>


        </form>


    </li>

    </ul>

    <script src="js/form_rotator.js" type="text/javascript"></script>


    </div>



    <?php







    if (!empty($_POST['load_tab'])) {
        echo "<script type=\"text/javascript=\">

        $(document).ready(function() {

            return goToStep('" . $_POST['load_tab'] . "');

        });

        </script>";

    }

}

?>