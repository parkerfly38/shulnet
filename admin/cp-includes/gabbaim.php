<?php
$permission = 'gabbaim';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions();

} else {


	$date = current_date();

	$exp_date = explode(' ',$date);

	$time = strtotime($date);

	$day7 = date('Y-m-d',$time-604800);

	$day14 = date('Y-m-d',$time-1209600);

	$day30 = date('Y-m-d',$time-2592000);

	$day7f = date('Y-m-d',$time+604800);

	$day14f = date('Y-m-d',$time+1209600);

	$day30f = date('Y-m-d',$time+2592000);


    ?>



    <div id="topblue" class="fonts small">
        <div class="holder">

            <div class="floatright" id="tb_right">

                &nbsp;

            </div>

            <div class="floatleft" id="tb_left">

                <b>Gabbaim</b>

            </div>

            <div class="clear"></div>

        </div>
    </div>



    <div id="mainsection">

        <div class="nontable_section">
            <div class="pad24">

                <h1>Aliyot and Kibbudim Queue</h1>

                <div class="nontable_section_inner">

                    <div class="pad24 line_bot">

                        <div class="col50">

                            <h2><img src="imgs/icon-sales.png" width="32" height="32" alt="aliyot"
                                     title="Aliyot" class="iconlg"/><a href="index.php?l=aliyot">Aliyot
                                    Logs</a></h2>

                            <p>View aliyot and kibbudim by event.</p>

                            

                        </div>

                        
                        <div class="col50">

                            <h2><img src="imgs/icon-invoices.png" width="32" height="32" alt="updateluach" title="updateluach"
                                     class="iconlg"/><a href="index.php?l=updateluach">Update Parashat</a></h2>

                            <p>Update parashat and holidays.</p>

                            

                        </div>

                        <div class="clear"></div>

                    </div>

                    <!--

                    <div class="pad24 line_top">

                        <div class="col33">

                            <h2><img src="imgs/icon-credit_cards.png" width="32" height="32" alt="Credit Cards" title="Credit Cards" class="iconlg" /><a href="index.php?l=credit_cards">Credit Cards</a></h2>

                            <p>List of credit cards on file.</p>

                        </div>

                        <div class="col33">



                        </div>

                        <div class="col33">



                        </div>

                        <div class="clear"></div>

                    </div>

                    -->

                </div>

            </div>
        </div>


    </div>



<?php

}