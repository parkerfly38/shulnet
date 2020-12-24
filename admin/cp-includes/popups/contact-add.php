<?php

if (! empty($_POST['id'])) {
    $ccdata  = new history($_POST['id'], '', '', '', '', '', 'ppSD_accounts');
    $cid     = $_POST['id'];
    $editing = '1';
    $data    = array(
        'name' => $ccdata->final_content['name'],
        'id'   => $ccdata->final_content['id'],
    );
} else {
    $account = new account;
    $data    = $account->get_account($_POST['account']);
    $cid     = generate_id('random', '8');
    $editing = '0';
}

?>

<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('contact-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('contact-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


    <div id="popupsave">
        <input type="hidden" name="dud_quick_add" value="1"/>
        <input type="submit" value="Save" class="save"/>
    </div>

    <h1>Create a New Contact</h1>

    <div class="popupbody">

        <p class="highlight">Use this form to quickly create a new contact.</p>

        <fieldset>
            <div class="pad fullForm">
                <?php
                $dataIn = array(
                    'account' => $data['id'],
                    'company_name' => $data['company_name'],
                    'url' => $data['url'],
                );
                echo $af->contactForm('', $dataIn);
                ?>
            </div>
        </fieldset>

    </div>


</form>