<?php


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

