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
$forms = new form;
$data = $forms->get_form($_POST['id']);
if (empty($data['id'])) {
    echo $admin->show_popup_error('Form not found');

} else {
    // $field_preface = '',$add_form = '0',$step = '',$session = '',$force_ssl = '0',$form_type = '',$hide_fields = '0') {
    $field    = new field('', '1');

    $url_base = PP_URL;
    $pass = $db->get_option('required_password_strength');
    $url_base = str_replace('http://','//',$url_base);
    $url_base = str_replace('https://','//',$url_base);
    $theme = $db->get_theme();
    $formdata = <<<QQ
<script type="text/javascript">var zen_url='{$url_base}'; var zen_theme='{$theme['name']}'; var check_pwd_strength='{$pass}';</script>
<script src="{$url_base}/pp-templates/html/{$theme['name']}/js/functions.js" type="text/javascript"></script>
<script src="{$url_base}/clients/pp-js/general.js" type="text/javascript"></script>
<script src="{$url_base}/clients/pp-js/form_functions.js" type="text/javascript"></script>
QQ;
    $formdata .= $field->generate_form('register-' . $_POST['id'] . '-1', '', '1');

    ?>

    <div id="popupsave">
        <!--<input type="button" onclick="return prev();" value="&laquo; Previous" />
	<input type="button" onclick="return next();" value="Next &raquo;" />-->
        <input type="button" onclick="return switch_popup('forms-edit','id=<?php echo $_POST['id']; ?>','1');"
               value="Edit Form"/>
    </div>

    <h1>Creating Form</h1>
    <div class="popupbody">
        <div class="pad24t">
            <h3>Within a Content Page</h3>
            <p class="highlight">If you are placing this form directly on a page generated within Zenbership, please use the widget caller:</p>

            <p class="code">{-form_<?php echo $_POST['id']; ?>-}</p>

            <h3>Outside of Zenbership's CMS</h3>

            <p class="highlight">If you are placing this form outside of the Zenbership CMS, or need full control over the layout, use this code:</p>

            <textarea name="" style="width:100%;height:600px;"><?php
                echo htmlspecialchars($formdata, ENT_QUOTES);
            ?></textarea>
        </div>
    </div>

<?php
}
?>