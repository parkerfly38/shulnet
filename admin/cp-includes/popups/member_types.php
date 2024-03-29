<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('member_types-add', 'x', '1');
    });
    $(function () {
        $("#note_labels").sortable();
    });

</script>


<form action="" method="post" id="popupform" onsubmit="return json_add('member_types-add','x','1');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>

    </div>

    <h1>Membership Types</h1>


    <div class="pad24t popupbody">


        <ul id="note_labels" class="popup_longlist">

            <?php
            $q1 = $db->run_query("
                SELECT *
                FROM `ppSD_member_types`
                ORDER BY `order` ASC
            ");
            while ($item = $q1->fetch()) {
            ?>

                <li id="td-cell-<?php echo $item['id'] ?>">
                    <a href="null.php" onclick="return delete_item('ppSD_member_types','<?php echo $item['id'] ?>');"
                       class="floatright">
                        <img src="imgs/icon-delete.png" width="16" height="16" border="0" class="option_icon hover"
                             alt="Delete" title="Delete"/>
                    </a>
                    <input type="text" name="type[<?php echo $item['id']; ?>][name]" style="width:300px;"
                           value="<?php echo $item['name'] ?>"/> (ID: <?php echo $item['id']; ?> | <a href="null.php" onclick="return switch_popup('member_types-edit','id=<?php echo $item['id']; ?>');">Edit Content Package</a>)
                    <input type="hidden" name="type[<?php echo $item['id']; ?>][id]" value="<?php echo $item['id'] ?>"/>
                </li>

            <?php
            }
            ?>

        </ul>

        <div class="submit">
            <a href="null.php" onclick="return add_type();">[+] Add New Type</a>
        </div>

    </div>

</form>

<script type="text/javascript">
    function add_type() {
        show_loading();
        send_data = 'action=member_type_entry';
        $.post('cp-functions/event_addition.php', send_data, function (theResponse) {
            $('#note_labels').append(theResponse);
            close_loading();
        });
        return false;
    }
</script>