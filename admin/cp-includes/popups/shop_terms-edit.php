<?php/** * * * Zenbership Membership Software * Copyright (C) 2013-2016 Castlamp, LLC * * This program is free software: you can redistribute it and/or modify * it under the terms of the GNU General Public License as published by * the Free Software Foundation, either version 3 of the License, or * (at your option) any later version. * * This program is distributed in the hope that it will be useful, * but WITHOUT ANY WARRANTY; without even the implied warranty of * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the * GNU General Public License for more details. * * You should have received a copy of the GNU General Public License * along with this program.  If not, see <http://www.gnu.org/licenses/>. * * @author      Castlamp * @link        http://www.castlamp.com/ * @link        http://www.zenbership.com/ * @copyright   (c) 2013-2016 Castlamp * @license     http://www.gnu.org/licenses/gpl-3.0.en.html * @project     Zenbership Membership Software */if (!empty($_POST['id'])) {    $cart = new cart;    $data = $cart->get_terms($_POST['id']);    // $data = new history($_POST['id'],'','','','','','ppSD_cart_terms');    $cid     = $_POST['id'];    $editing = '1';} else {    $data    = array('name' => '', 'terms' => '');    $cid     = generate_id('random', '8');    $editing = '0';}?><script type="text/javascript">    $.ctrl('S', function () {        return json_add('shop_terms-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');    });</script><form action="" method="post" id="popupform"      onsubmit="return json_add('shop_terms-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">    <div id="popupsave">        <input type="submit" value="Save" class="save"/>    </div>    <h1>Cart Terms and Conditions</h1>    <div class="fullForm popupbody">        <p class="highlight">Terms can be applied to individual products after being created here. Once applied to a            product, users will have to agree to these terms before purchasing the product in question.</p>        <fieldset>            <div class="pad24t">                <div class="field">                    <label>Title</label>                    <div class="field_entry">                        <input type="text" value="<?php echo $data['name']; ?>" name="name" id="name" style="width:400px;"                               class="req"/>                    </div>                </div>                <div class="field">                    <label class="top">Terms</label>                    <div class="clear"></div>                    <div class="field_entry_top">                <textarea name="terms" class="richtext" id="t12ff"                          style="width:100%;height:500px;"><?php if (!empty($data['terms'])) {                        echo $data['terms'];                    } ?></textarea>                    </div>                    <?php                    echo $admin->richtext('100%', '500px', 't12ff');                    ?>                </div>            </div>        </fieldset>    </div></form>