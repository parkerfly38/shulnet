<?php/** * * * Zenbership Membership Software * Copyright (C) 2013-2016 Castlamp, LLC * * This program is free software: you can redistribute it and/or modify * it under the terms of the GNU General Public License as published by * the Free Software Foundation, either version 3 of the License, or * (at your option) any later version. * * This program is distributed in the hope that it will be useful, * but WITHOUT ANY WARRANTY; without even the implied warranty of * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the * GNU General Public License for more details. * * You should have received a copy of the GNU General Public License * along with this program.  If not, see <http://www.gnu.org/licenses/>. * * @author      Castlamp * @link        http://www.castlamp.com/ * @link        http://www.zenbership.com/ * @copyright   (c) 2013-2016 Castlamp * @license     http://www.gnu.org/licenses/gpl-3.0.en.html * @project     Zenbership Membership Software */?><h1>Create a Custom Hook</h1><div class="fullForm popupbody">    <p class="highlight">Hooks allow you to run tasks and send emails when a user interacts with the program in a specific way.</p>    <div class="pad">    <div class="col50l">        <div class="nontable_section_inner margbot">            <div class="pad line_bot">                <h2><img src="imgs/icon-lg-custom_actions.png" width="32" height="32" alt="PHP Code Inclusion"                         title="PHP Code Inclusion" class="iconlg"/><a href="returnnull.php"                                                                   onclick="return switch_popup('hook','type=1','1');">PHP Code Execution</a>                </h2>                <p class="nobotmargin">Execute a PHP script when a specific task is triggered.</p>            </div>        </div>    </div>    <div class="col50r">        <div class="nontable_section_inner">            <div class="pad line_bot">                <h2><img src="imgs/icon-email.png" width="32" height="32" alt="E-Mail Dispatcher"                         title="E-Mail Dispatcher" class="iconlg"/><a href="returnnull.php"                                                                    onclick="return switch_popup('hook','type=2','1');">E-Mail Dispatcher</a>                </h2>                <p class="nobotmargin">Send a custom e-mail when a specific task is triggered.</p>            </div>        </div>    </div>    <div class="clear" style="height:24px;"></div>    <div class="col50l">        <div class="nontable_section_inner margbot">            <div class="pad line_bot">                <h2><img src="imgs/icon-lg-fields.png" width="32" height="32" alt="MySQL Command Execution"                         title="MySQL Command Execution" class="iconlg"/><a href="returnnull.php"                                                                       onclick="return switch_popup('hook','type=3','1');">MySQL Command Execution</a>                </h2>                <p class="nobotmargin">Connect to a database and run one or more MySQL commands when a specific task is triggered.</p>            </div>        </div>    </div>    <div class="col50r">        <div class="nontable_section_inner">            <div class="pad line_bot">                <h2><img src="imgs/icon-lg-curl.png" width="32" height="32" alt="Outside Connection"                         title="Outside Connection" class="iconlg"/><a href="returnnull.php"                                                                      onclick="return switch_popup('hook','type=5','1');">Outside Connection</a>                </h2>                <p class="nobotmargin">Connect using a cURL connection to an outside web page when a specific task is triggered.</p>            </div>        </div>    </div>    <div class="clear"></div>    </div></div>