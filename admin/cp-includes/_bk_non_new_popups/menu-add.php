<?phpif (! empty($_POST['id'])) {    $cid = $_POST['id'];    $widget = $db->widget_data($_POST['id']);    $name = $widget['name'];    $edit = '1';} else {    $cid = 'new';    $edit = '0';    $name = '';}?><script type="text/javascript">    $.ctrl('S', function () {        return json_add('menu-add', '<?php echo $cid; ?>', '<?php echo $edit; ?>', 'popupform');    });</script><form action="" method="post" id="popupform" onsubmit="return json_add('menu-add','<?php echo $cid; ?>','<?php echo $edit; ?>');"><div id="popupsave">    <input type="submit" value="Save" class="save"/>    <input type="hidden" name="id" value="<?php echo $cid; ?>"/></div><h1>Menu Management</h1><div class="pad24t popupbody">    <div class="field">        <label>Name</label>        <div class="field_entry">            <input type="text" name="name" value="<?php echo $name; ?>" style="width:100%;" />        </div>    </div>    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="generic" id="menu">        <thead>        <tr>            <th>Name</th>            <th>Link or Content Page</th>            <th>Window</th>            <th width="24">&nbsp;</th>        </tr>        </thead>        <tbody>        <?php        if (! empty($cid)) {            // Loop and add menu items.            $admin = new admin;            $STH = $db->run_query("                SELECT `id`                FROM `ppSD_widgets_menus`                WHERE `widget_id`='" . $db->mysql_clean($cid) . "'                ORDER BY `position` ASC            ");            while ($item = $STH->fetch()) {                $add = $admin->cell_menu_item($item['id']);                echo $add;            }        }        ?>        </tbody>    </table>    <p><a href="null.php" onclick="return add_menu_item();">[+] Add New Link</a></p></div></form><script type="text/javascript">    function add_menu_item(id) {        show_loading();        send_data = 'action=menu_item&id=' + id;        $.post('cp-functions/product_addition.php', send_data, function (repSo) {            $('#menu tbody').append(repSo);            close_loading();            update_popup_height();        });        return false;    }    /*    $("#menu tbody tr").sortable({        placeholder: "ui-state-highlight"    }).disableSelection();    */    var fixHelper = function(e, ui) {        ui.children().each(function() {            $(this).width($(this).width());        });        return ui;    };    $("#menu tbody").sortable({        helper: fixHelper    }); // .disableSelection();    function remove_menu_item(id)    {        $('#menu_item_' + id).remove();    }</script>