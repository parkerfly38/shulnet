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

$def_lang = $db->get_option('language');

if (! empty($_POST['lang'])) {
    $lang = $_POST['lang'];
} else {
    $lang = $def_lang;
}

$type = 'page';
if (! empty($_POST['id'])) {

    $changes = array();
    $header = new template('header', $changes, '0', '', '', '', '2');
    $footer = new template('footer', $changes, '0', '', '', '', '2');

    $content = new content;
    $data    = $content->get_content($_POST['id']);

    $meta_title = $data['template']['meta_title'];
    if (! empty($_POST['lang']) && $_POST['lang'] != $def_lang) {
        $data['template']['content'] = $header . $content->language_content($_POST['id'], $lang) . $footer;
        $meta_title = $content->language_title($_POST['id'], $lang);
    } else {
        $data['template']['content'] = $header . $data['template']['content'] . $footer;
    }
    if ($data['error'] == '1') {
        $admin->show_popup_error($data['error_details']);
        exit;
    } else {
        $cid     = $_POST['id'];
        $editing = '1';
    }
} else {

    // contentsCss : 'http://cheaper.com.hk/admin/try.css'
    // Template
    if (empty($_POST['template_selected'])) {
        $templ = 'default_page';
    } else {
        $templ = $_POST['template_selected'];
    }
    $changes = array();
    $template = new template($templ, $changes, '1', '', '', '', '2');

    $temp_data = '';
    $data      = array(
        'name'            => '',
        'template'        => array(
            'content' => $template,
            'secure'  => '0',
            'section' => '1',
            'encrypt' => '0',
        ),
        'menus'           => array(),
        'permalink'       => '',
        'display_on_usercp' => '0',
        'permalink_clean' => '',
        'full_link'       => PP_URL,
    );
    $meta_title = '';
    $cid       = 'new';
    $editing   = '0';
}

?>


<script type="text/javascript">
    $.ctrl('S', function () {
        return json_add('content-page-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });
</script>

<script src="js/form_rotator.js" type="text/javascript"></script>
<form action="" method="post" id="popupform"
      onsubmit="return json_add('content-page-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">

<div id="popupsave">
    <?php
    if (! empty($_POST['id'])) {
    ?>
    <input type="submit" value="Grant Access From Criteria" onclick="return switch_popup('build_criteria','type=member&act=content_access&act_id=<?php echo $cid; ?>','');" />
    <?php
    }
    ?>
    <input type="button" onclick="return switch_popup('content_type','','1');" value="Back to Content Creation"/>
    <input type="submit" value="Save" class="save"/>
    <input type="hidden" name="type" value="<?php echo $type; ?>"/>
    <input type="hidden" name="lang" value="<?php echo $lang; ?>"/>
</div>

<h1>Content Management</h1>

    <ul id="theStepList">
        <li class="on" onclick="return goToStep('0');">
            Content
        </li><li onclick="return goToStep('1');">
            Options
        </li>
    </ul>

<div class="fullForm popupbody">

    <ul id="formlist">
        <li class="form_step">

            <p class="highlight">Use this step to design your page. Remember to click on "Options" for more important steps.</p>

            <fieldset>
                <div class="pad">

                    <div class="floatright smaller"><input type="submit" value="Preview Page" onclick="return preview_template('','');"/></div>

                    <div class="float_left"><?php
                        if (! empty($_POST['id'])) {
                            foreach ($def_languages as $code => $name) {
                                echo "<span class=\"language_option\"><a href=\"null.php\" onclick=\"return switch_popup('content-add-page','id=" . $_POST['id'] . "&lang=" . $code . "');\">$name</a></span>";
                            }
                        }
                        ?>
                    </div>
                    <div class="clear"></div>

                    <?php
                    echo $af->richtext('template', $data['template']['content'], '600');
                    ?>

                </div>
            </fieldset>

        </li>
        <li class="form_step">

            <p class="highlight">Use this step to establish your page's options, which control how people can interact with the content.</p>

            <div class="col50l">

                <fieldset>
                    <div class="pad">

                        <label>What section should this content be placed in?</label>
                        <?php
                        $sections = $admin->get_sections('', 'array');
                        echo $af
                            ->setId('section')
                            ->select('section', $data['template']['section'], $sections);
                        ?>


                        <label>What should this content be called?</label>
                        <?php
                        $sections = $admin->get_sections('', 'array');
                        echo $af->string('name', $data['name'], 'req');
                        ?>

                        <label>What should the permalink be for this page?</label>
                        <?php
                        echo $af
                            ->setId('permalink')
                            ->setPlaceholder('My_Pages_Permalink')
                            ->string('permalink', $data['permalink_clean'], 'req');
                        ?>
                        <p class="field_desc" id="preview_permalink"><?php echo $data['full_link']; ?></p>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#permalink').keyup(function() {
                                    return check_permalink();
                                });
                            });
                        </script>

                    </div>
                </fieldset>

            </div>
            <div class="col50r">

                <fieldset>
                    <div class="pad">

                        <label>Would you like this to be secure "Members Only" content?</label>
                        <?php
                        echo $af
                            ->setDescription('Open: anyone can view this page. Note that is the page is placed in a secure section, the
                            member will need access to the section to access this page. This would make it "open within a secure
                            section" rather than secure on its own on top of the secure section.')
                            ->radio('secure', $data['template']['secure'], array(
                                '1' => 'Only members with access to this page can view it',
                                '0' => 'Accessible to non-members',
                            ));
                        ?>

                        <label>Meta Title</label>
                        <?php
                        echo $af
                            ->setMaxlength('65')
                            ->setPlaceholder('Title that search engines see')
                            ->setDescription('This is what appears as your content\'s title in the browser tab. It is also what search engines will use to index your page.')
                            ->string('meta_title', $meta_title, '');
                        ?>

                        <label>Would you like to display a link to this content in the member dashboard?</label>
                        <?php
                        echo $af->radio('display_on_usercp', $data['display_on_usercp'], array(
                            '1' => 'Yes, include it on the member\'s content list.',
                            '0' => 'No, do not add it to the member\'s content list.',
                        ));
                        ?>

                    </div>
                </fieldset>

                <!--
            <div class="field">
                <label>Encrypt HTML?</label>
                <div class="field_entry">
                    <input type="radio" name="encrypt" value="1" <?php if ($data['template']['encrypt'] == '1') {
                    echo " checked=\"checked\"";
                } ?> /> Encrypted Source: recommended only for embedding external content. Please see the documentation for a discussion on this "encryption".<br/>

                    <input type="radio" name="encrypt" value="0" <?php if ($data['template']['encrypt'] != '1') {
                    echo " checked=\"checked\"";
                } ?> /> Open: recommended in almost all cases.
                </div>
            </div>
            -->

    </li>
    <li class="form_step">

        <fieldset>
            <div class="pad">
                <label>What menus should this appear in?</label>
                <?php
                echo $admin->get_menus($data['menus']);
                ?>
            </div>
        </fieldset>

    </li>
    </ul>

</div>


</form>


<script type="text/javascript">

    function check_permalink() {
        send_data = 'section=' + $('#section').val() + '&id=<?php echo $cid; ?>&permalink=' + $('#name').val();
        $.post('cp-functions/preview_permalink.php', send_data, function (theResponse) {
            $('#preview_permalink').html(theResponse);
        });
        return false;
    }

</script>