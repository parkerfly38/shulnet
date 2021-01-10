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

if (!empty($_POST['id'])) {
    $data         = new history($_POST['id'], '', '', '', '', '', 'ppSD_cart_categories');
    $editing      = '1';
    $cid          = $_POST['id'];
    $hide         = $data->final_content['hide'];
    $members_only = $data->final_content['members_only'];
} else {
    $date         = current_date();
    $deadline     = '';
    $editing      = '0';
    $hide         = '0';
    $members_only = '0';
    $cid          = 'x'; // auto_increment
}

$name = (! empty($data->{'final_content'}['name'])) ? $data->{'final_content'}['name'] : '';
$desc = (! empty($data->{'final_content'}['description'])) ? $data->{'final_content'}['description'] : '';
$sindex = (! empty($data->{'final_content'}['search_index'])) ? $data->{'final_content'}['search_index'] : '1';
$mtitle = (! empty($data->{'final_content'}['meta_title'])) ? $data->{'final_content'}['meta_title'] : '';
$mdesc = (! empty($data->{'final_content'}['meta_desc'])) ? $data->{'final_content'}['meta_desc'] : '';
$mkeys = (! empty($data->{'final_content'}['meta_keywords'])) ? $data->{'final_content'}['meta_keywords'] : '';
$cols = (! empty($data->{'final_content'}['cols'])) ? $data->{'final_content'}['cols'] : '2';

?>
<script src="js/form_rotator.js" type="text/javascript"></script>
<script type="text/javascript">
    $.ctrl('S', function () {
        return json_add('category-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });
</script>
<form action="" method="post" id="popupform"
      onsubmit="return json_add('category-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">
    <div id="popupsave">
        <input type="submit" value="Save" class="save"/>
        <input type="hidden" name="id" value="<?php echo $cid; ?>"/>
    </div>
    <h1>Cart Category</h1>

    <ul id="theStepList">
        <li class="on" onclick="return goToStep('0');">
            Overview
        </li><li class="" onclick="return goToStep('1');">
            Settings
        </li><?php
        if ($editing == '1') {
        ?><li onclick="return goToStep('2');">
            Re-order Products
        </li>
        <?php
        }
        ?>
    </ul>

        <div class="pad24t popupbody">


        <ul id="formlist">
        <li class="form_step">

            <p class="highlight">Create the basic display settings for the category.</p>

            <div class="col50l">

                <fieldset>
                    <div class="pad">
                        <h2>What Users See</h2>

                        <label class="">What is the name of this category?</label>
                        <?php
                        echo $af->string('name', $name, 'req');
                        ?>

                        <label class="less">What category should this category be a sub-category of?</label>
                        <?php
                        $cates = $admin->cart_category_select('', 'array');

                        if (!empty($data->{'final_content'}['subcategory'])) {
                            $subcat = $data->{'final_content'}['subcategory'];
                        } else {
                            $subcat = '1';
                        }

                        echo $af->select('subcategory', $subcat, $cates);
                        ?>

                        <label class="">Provide a brief description of the category below.</label>
                        <?php
                        echo $af
                            ->setId('f21')
                            ->richtext('description', $desc, '250', '1');
                        ?>

                    </div>
                </fieldset>


            </div>
            <div class="col50r">

                <fieldset>
                    <div class="pad">
                        <h2>What Search Engines See</h2>

                        <label>Would you like to allow search engines to index this category?</label>
                        <?php
                        echo $af->checkbox('search_index', array(
                            '1' => 'Yes',
                        ), $sindex)
                        ?>

                        <label>What should the meta title for the category be?</label>
                        <?php
                        echo $af
                            ->setMaxlength('66')
                            ->string('meta_title', $mtitle);
                        ?>

                        <label>What should the meta description for the category be?</label>
                        <?php
                        echo $af
                            ->setMaxlength('175')
                            ->string('meta_desc', $mdesc);
                        ?>

                        <label>What should the meta keywords for the category be?</label>
                        <?php
                        echo $af
                            ->setDescription('Input as a comma separated list: keyword1, keyword2, etc.')
                            ->setMaxlength('175')
                            ->string('meta_keywords', $mkeys);
                        ?>
                    </div>
                </fieldset>

            </div>
            <div class="clear"></div>

        </li>
            <li class="form_step">

                <p class="highlight">These are general settings that control who and how the category can be accessed.</p>

                <fieldset>
                    <div class="pad">
                        <label class="less">Status</label>
                        <?php
                        echo $af->radio('hide', $hide, array(
                            '0' => 'Visible',
                            '1' => 'Hidden',
                        ));
                        ?>

                        <label class="less">Accessibility</label>
                        <?php
                        echo $af->radio('members_only', $members_only, array(
                            '1' => 'Membership required to access',
                            '0' => 'No membership required to access',
                        ));
                        ?>

                        <label class="less">How many products should be displayed per row?</label>
                        <?php
                        echo $af->string('cols', $cols);
                        ?>

                    </div>
                </fieldset>

            </li>

            <?php
            if ($editing == '1') {
            ?>
                <li class="form_step">

                    <p class="highlight">Drag and drop products to re-order them within the category.</p>

                    <div class="pad">

                        <link type="text/css" rel="stylesheet" media="all" href="css/fields_sortable.css"/>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $("#prod_list").sortable({
                                    placeholder: "ui-state-highlight"
                                }).disableSelection();
                            });
                        </script>

                        <ul id="prod_list" class="colfields ui-sortable">
                            <?php
                            $prods = $db->run_query("
                                SELECT
                                    `id`,`name`
                                FROM
                                    `ppSD_products`
                                WHERE
                                    `category`='" . $db->mysql_clean($_POST['id']) . "'
                                ORDER BY
                                    `cart_ordering` ASC
                            ");
                            while ($row = $prods->fetch()) {
                                echo "<li><input type=\"hidden\" name=\"reorder[" . $row['id'] . "]\" value=\"1\" />" . $row['name'] . "<div class=\"move\"></div></li>";
                            }
                            ?>
                        </ul>

                    </div>

        </li>
            <?php
            }
            ?>
        </ul>

    </div>

</form>