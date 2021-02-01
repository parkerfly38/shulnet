<?php

if (!empty($_POST['id'])) {
    $source = new source;
    $data = $source->get_source($_POST['id']);
    // $data = new history($_POST['id'],'','','','','','ppSD_cart_terms');
    $cid     = $_POST['id'];
    $editing = '1';
} else {
    $data    = array('source' => '', 'redirect' => '', 'redirect_b' => '', 'trigger' => '');
    $editing = '0';
    $cid = 'new';
}

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('sources-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('sources-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>

    </div>

    <h1>Source</h1>

    <div class="fullForm popupbody">

        <p class="highlight">
            Use this form to create/edit a source for tracking acquision and value of contacts and members.
        </p>

        <fieldset>
            <div class="pad24t">


                <div class="field">

                    <label>Title</label>

                    <div class="field_entry">

                        <input type="text" value="<?php echo $data['source']; ?>" name="source" id="source" style="width:100%;"
                               class="req"/>

                    </div>

                </div>

                <div class="field">

                    <label>Redirect</label>

                    <div class="field_entry">

                        <input type="text" value="<?php echo $data['redirect']; ?>" name="redirect" id="redirect" style="width:100%;"
                               class=""/>

                    </div>
                    <p class="field_desc">If you are using inbound tracking with this source and wish to redirect this user to a particular web page after arriving on your site, such as
                        a targeted landing page, input the full URL to that page above.</p>

                </div>

                <div class="field">

                    <label>Redirect Alternative</label>

                    <div class="field_entry">

                        <input type="text" value="<?php echo $data['redirect_b']; ?>" name="redirect_b" id="redirect_b" style="width:100%;"
                               class=""/>

                    </div>
                    <p class="field_desc">If you want to do some basic A/B testing, Zenbership will automatically send users to either the control (redirect above)
                     or the redirect alternative (this field). It will also track conversions based on both.</p>

                </div>

            </div>
        </fieldset>

    </div>


</form>