<?php/** * * * Zenbership Membership Software * Copyright (C) 2013-2016 Castlamp, LLC * * This program is free software: you can redistribute it and/or modify * it under the terms of the GNU General Public License as published by * the Free Software Foundation, either version 3 of the License, or * (at your option) any later version. * * This program is distributed in the hope that it will be useful, * but WITHOUT ANY WARRANTY; without even the implied warranty of * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the * GNU General Public License for more details. * * You should have received a copy of the GNU General Public License * along with this program.  If not, see <http://www.gnu.org/licenses/>. * * @author      Castlamp * @link        http://www.castlamp.com/ * @link        http://www.zenbership.com/ * @copyright   (c) 2013-2016 Castlamp * @license     http://www.gnu.org/licenses/gpl-3.0.en.html * @project     Zenbership Membership Software */$campaign = new campaign($_POST['campaign_id']);$data = $campaign->get_campaign();$cid = $_POST['campaign_id'];?><script type="text/javascript">    $.ctrl('S', function () {        return json_add('campaign_subscribe-add', '<?php echo $cid; ?>', '0', 'popupform');    });</script><form action="" method="post" id="popupform"      onsubmit="return json_add('campaign_subscribe-add','<?php echo $cid; ?>','0','popupform');">    <div id="popupsave">        <input type="submit" value="Subscribe" class="save"/>        <input type="hidden" name="campaign_id" value="<?php echo $cid; ?>"/>    </div>    <h1>Subscribe User</h1>    <div id="pop_inner" class="fullForm popupbody">        <script type="text/javascript">            $("input[type=radio]['data[member_type]']").change(function() {                switch(this.value) {                    case 'member':                        return swap_multi_div('member','contact,new_contact');                    case 'contact':                        return swap_multi_div('contact','member,new_contact');                    case 'new_contact':                        return swap_multi_div('new_contact','contact,member');                }            });        </script>        <fieldset>            <div class="pad">                <label>Who are you subscribing to the campaign?</label>                <?php                echo $af->radio('user_type', 'member', array(                    'member' => 'Existing Member',                    'contact' => 'Existing Contact',                    'new_contact' => 'New Contact',                ));                ?>                <div id="member" style="display:block;">                    <label class="">Find the member you want to subscribe</label>                    <?php                    echo $af->memberList('member[id]', '');                    ?>                </div>                <div id="contact" style="display:none;">                    <label class="">Find the contact you want to subscribe</label>                    <?php                    echo $af->contactList('contact[id]', '');                    ?>                </div>                <div id="new_contact" style="display:none;">                    <label class="">Create your new contact below...</label>                    <?php                    echo $af->contactForm('new', '');                    ?>                </div>            </div>        </fieldset>    </div></form>