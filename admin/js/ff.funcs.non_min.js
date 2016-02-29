var use_col_count = 0;var col_id = '1';function add_field(type) {    use_col_count++;    if (type == 'text') {        field_html = get_field_text(col_id, use_col_count);        $('#col').append('<li id="' + col_id + '_' + use_col_count + '">' + field_html + '</li>');    }    // Textarea    else if (type == 'textarea') {        field_html = get_field_textarea(col_id, use_col_count);        $('#col').append('<li id="' + col_id + '_' + use_col_count + '">' + field_html + '</li>');    }    // Select    else if (type == 'select') {        field_html = get_field_select(col_id, use_col_count);        $('#col').append('<li id="' + col_id + '_' + use_col_count + '">' + field_html + '</li>');    }    // Radio    else if (type == 'radio') {        field_html = get_field_radio(col_id, use_col_count);        $('#col').append('<li id="' + col_id + '_' + use_col_count + '">' + field_html + '</li>');    }    // Checkbox    else if (type == 'checkbox') {        field_html = get_field_checkbox(col_id, use_col_count);        $('#col').append('<li id="' + col_id + '_' + use_col_count + '">' + field_html + '</li>');    }    // Date    else if (type == 'date') {        field_html = get_field_date(col_id, use_col_count);        $('#col').append('<li id="' + col_id + '_' + use_col_count + '">' + field_html + '</li>');    }    // Field Section    else if (type == 'section') {        field_html = get_field_section(col_id, use_col_count);        $('#col').append('<li id="' + col_id + '_' + use_col_count + '">' + field_html + '</li>');    }    // Page Break    else if (type == 'page') {        field_html = get_field_page(col_id, use_col_count);        $('#col').append('<li id="' + col_id + '_' + use_col_count + '">' + field_html + '</li>');    }    // Nothing    else {        // Ignore event    }    // Find remove    $('#removecol').remove();}/** * <---------------------------- *    Field: Text */function get_field_text(col_id, use_col_count) {    // Setup    var full_div = 'fld' + col_id + '_' + use_col_count;    var option_div_id = 'options_fld' + col_id + '_' + use_col_count;    var logic_div_id = 'logic_fld' + col_id + '_' + use_col_count;    var field_id = 'fld_' + col_id + '_' + use_col_count;    var field_name_div = 'fldname_' + col_id + '_' + use_col_count;    var field_label_div = 'fldlabel_' + col_id + '_' + use_col_count;    var field_label_id = 'fldlabel2_' + col_id + '_' + use_col_count;    var field_left_div = 'fldleft_' + col_id + '_' + use_col_count;    var fffield_desc_div = 'flddesc_' + col_id + '_' + use_col_count;    var field_label_req = 'fldreq_' + col_id + '_' + use_col_count;    // ----------------------------    //		 DISPLAY    var info = '<!--start:field_block--><div class="aflddiv" id="' + full_div + '">';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + ']" value="1" />';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + '][type]" value="text" />';    info += '<div class="fffield_entry">';    info += '<label id="' + field_label_id + '" class="ffleft"><span id="' + field_label_div + '">Untitled</span><span class="req_star" id="' + field_label_req + '">*</span></label>';    info += '<div id="' + field_left_div + '" class="fffield_left"><input type="text" id="' + field_id + '" value="" style="width:250px;" /><div class="fffield_desc" id="' + fffield_desc_div + '"></div></div><div class="clear"></div></div>';    // ----------------------------    // 		DESCRIPTION    info += '</div><div id="' + option_div_id + '" class="option_div"><div class="delete"><a href="null.php" onclick="return deleteField(\'' + col_id + '_' + use_col_count + '\');">Delete</a></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Name</label>';    info += '  <div class="fffield_left"><input name="' + col_id + '[fld' + use_col_count + '][display_name]" style="width:250px;" onkeyup="return updateDiv(\'' + field_label_div + '\',this.value)" /></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Description</label>';    info += '  <div class="fffield_left"><textarea name="' + col_id + '[fld' + use_col_count + '][desc]" style="width:450px;height:50px;" onkeyup="return updateDiv(\'' + fffield_desc_div + '\',this.value)"></textarea></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Label Position</label>';    info += '  <div class="fffield_left"><input type="radio" name="' + col_id + '[fld' + use_col_count + '][label_position]" value="left" checked="checked" class="labelchange" onClick="return updateLabel(\'left\',\'' + field_label_id + '\',\'' + field_left_div + '\');" /> Left <input type="radio" name="' + col_id + '[fld' + use_col_count + '][label_position]" value="top" onClick="return updateLabel(\'top\',\'' + field_label_id + '\',\'' + field_left_div + '\');" /> Above';    info += '  </div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Special Type</label>';    info += '    <div class="fffield_left"><input type="radio" name="' + col_id + '[fld' + use_col_count + '][special_type]" value="" checked="checked" /> -<br />';    info += '    <input type="radio" name="' + col_id + '[fld' + use_col_count + '][special_type]" value="url" /> Website URL<br />';    info += '    <input type="radio" name="' + col_id + '[fld' + use_col_count + '][special_type]" value="email" /> E-Mail Address<br />';    info += '    <input type="radio" name="' + col_id + '[fld' + use_col_count + '][special_type]" value="phone" /> Phone Number<br />';    info += '    <input type="radio" name="' + col_id + '[fld' + use_col_count + '][special_type]" value="password" /> Password';    info += '  </div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Restrictions</label>';    info += '    <div class="fffield_left"><input type="radio" name="' + col_id + '[fld' + use_col_count + '][class]" value="" checked="checked" /> -<br />';    info += '    <input type="radio" name="' + col_id + '[fld' + use_col_count + '][class]" value="zen_let" /> Alpha (A-Z, a-z)<br />';    info += '    <input type="radio" name="' + col_id + '[fld' + use_col_count + '][class]" value="zen_num" /> Numeric (0-9)<br />';    info += '    <input type="radio" name="' + col_id + '[fld' + use_col_count + '][class]" value="zen_letnum" /> Alphanumeric (A-Z, a-z, 0-9)<br />';    info += '    <input type="radio" name="' + col_id + '[fld' + use_col_count + '][class]" value="zen_money" /> Monetary (0-9, .)';    info += '  </div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Encrypt?</label>';    info += '    <div class="fffield_left"><input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][encrypt]" value="1" /> Encrypt this data in the database.</div>';    info += '  </div>';    info += '  <div class="fffield_entry"><label class="ffleft">Maxlength</label>';    info += '    <div class="fffield_left"><input type="text" name="' + col_id + '[fld' + use_col_count + '][maxlength]" value="" style="width:80px;" /></div>';    info += '  </div>';    info += '  <div class="fffield_entry"><label class="ffleft">Width (px)</label>';    info += '    <div class="fffield_left"><input type="text" name="' + col_id + '[fld' + use_col_count + '][width]" value="250" style="width:80px;" onblur="return resize_field(\'' + field_id + '\',this.value);" /></div>';    info += '  </div>';    info += '  <div class="fffield_entry"><label class="ffleft">Indexes</label>';    info += '    <div class="fffield_left">';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_member]" value="1" /> Member Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_contact]" value="1" /> Contact Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_event]" value="1" /> Event Registration Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_account]" value="1" /> Account Database<br />';    info += '  </div>';    info += '  </div>';    info += '</div><!--end:options-->';    return info;}/** *    end:text * ----------------------------> *//** * <---------------------------- *    Field: Textarea */function get_field_textarea(col_id, use_col_count) {    // Setup    var full_div = 'fld' + col_id + '_' + use_col_count;    var option_div_id = 'options_fld' + col_id + '_' + use_col_count;    var logic_div_id = 'logic_fld' + col_id + '_' + use_col_count;    var field_id = 'fld_' + col_id + '_' + use_col_count;    var field_name_div = 'fldname_' + col_id + '_' + use_col_count;    var field_label_div = 'fldlabel_' + col_id + '_' + use_col_count;    var field_label_id = 'fldlabel2_' + col_id + '_' + use_col_count;    var field_left_div = 'fldleft_' + col_id + '_' + use_col_count;    var fffield_desc_div = 'flddesc_' + col_id + '_' + use_col_count;    var field_label_req = 'fldreq_' + col_id + '_' + use_col_count;    // ----------------------------    //		 DISPLAY    var info = '<!--start:field_block--><div class="aflddiv" id="' + full_div + '">';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + ']" value="1" />';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + '][type]" value="textarea" />';    info += '<div class="fffield_entry">';    info += '<label id="' + field_label_id + '" class="ffleft"><span id="' + field_label_div + '">Untitled</span><span class="req_star" id="' + field_label_req + '">*</span></label>';    info += '<div id="' + field_left_div + '" class="fffield_left"><textarea id="' + field_id + '" value="" style="width:100%;height:60px;"></textarea><div class="fffield_desc" id="' + fffield_desc_div + '"></div></div></div>';    // ----------------------------    // 		DESCRIPTION    info += '</div><div id="' + option_div_id + '" class="option_div"><div class="delete"><a href="null.php" onclick="return deleteField(\'' + col_id + '_' + use_col_count + '\');">Delete</a></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Name</label>';    info += '  <div class="fffield_left"><input name="' + col_id + '[fld' + use_col_count + '][display_name]" style="width:250px;" onkeyup="return updateDiv(\'' + field_label_div + '\',this.value)" /></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Description</label>';    info += '  <div class="fffield_left"><textarea name="' + col_id + '[fld' + use_col_count + '][desc]" style="width:450px;height:50px;" onkeyup="return updateDiv(\'' + fffield_desc_div + '\',this.value)"></textarea></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Label Position</label>';    info += '  <div class="fffield_left"><input type="radio" name="' + col_id + '[fld' + use_col_count + '][label_position]" value="left" checked="checked" class="labelchange" onClick="return updateLabel(\'left\',\'' + field_label_id + '\',\'' + field_left_div + '\');" /> Left <input type="radio" name="' + col_id + '[fld' + use_col_count + '][label_position]" value="top" onClick="return updateLabel(\'top\',\'' + field_label_id + '\',\'' + field_left_div + '\');" /> Above';    info += '  </div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Maxlength</label>';    info += '    <div class="fffield_left"><input type="text" name="' + col_id + '[fld' + use_col_count + '][maxlength]" value="" style="width:80px;" /></div>';    info += '  </div>';    info += '  <div class="fffield_entry"><label class="ffleft">Dimensions (px)</label>';    info += '    <div class="fffield_left"><input type="text" name="' + col_id + '[fld' + use_col_count + '][width]" value="250" style="width:80px;" onblur="return resize_field(\'' + field_id + '\',this.value);" /> x <input type="text" name="' + col_id + '[fld' + use_col_count + '][height]" value="60" style="width:80px;" onblur="return resize_field_height(\'' + field_id + '\',this.value);" /></div>';    info += '  </div>';    info += '  <div class="fffield_entry"><label class="ffleft">Indexes</label>';    info += '    <div class="fffield_left">';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_member]" value="1" /> Member Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_contact]" value="1" /> Contact Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_event]" value="1" /> Event Registration Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_account]" value="1" /> Account Database<br />';    info += '  </div>';    info += '  </div>';    info += '</div><!--end:options-->';    return info;}/** *    end:textarea * ----------------------------> *//** * <---------------------------- *    Field: Upload */function get_field_upload(col_id, use_col_count) {    // Setup    var full_div = 'fld' + col_id + '_' + use_col_count;    var option_div_id = 'options_fld' + col_id + '_' + use_col_count;    var logic_div_id = 'logic_fld' + col_id + '_' + use_col_count;    var field_id = 'fld_' + col_id + '_' + use_col_count;    var field_name_div = 'fldname_' + col_id + '_' + use_col_count;    var field_label_div = 'fldlabel_' + col_id + '_' + use_col_count;    var field_label_id = 'fldlabel2_' + col_id + '_' + use_col_count;    var field_left_div = 'fldleft_' + col_id + '_' + use_col_count;    var fffield_desc_div = 'flddesc_' + col_id + '_' + use_col_count;    var field_label_req = 'fldreq_' + col_id + '_' + use_col_count;    // ----------------------------    //		 DISPLAY    var info = '<!--start:field_block--><div class="aflddiv" id="' + full_div + '">';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + ']" value="1" />';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + '][type]" value="attachment" />';    info += '<div class="fffield_entry">';    info += '<label id="' + field_label_id + '" class="ffleft"><span id="' + field_label_div + '">Untitled</span><span class="req_star" id="' + field_label_req + '">*</span></label>';    info += '<div id="' + field_left_div + '" class="fffield_left"><textarea id="' + field_id + '" value="" style="width:100%;height:60px;"></textarea><div class="fffield_desc" id="' + fffield_desc_div + '"></div></div></div>';    // ----------------------------    // 		DESCRIPTION    info += '</div><div id="' + option_div_id + '" class="option_div"><div class="delete"><a href="null.php" onclick="return deleteField(\'' + col_id + '_' + use_col_count + '\');">Delete</a></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Name</label>';    info += '  <div class="fffield_left"><input name="' + col_id + '[fld' + use_col_count + '][display_name]" style="width:250px;" onkeyup="return updateDiv(\'' + field_label_div + '\',this.value)" /></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Description</label>';    info += '  <div class="fffield_left"><textarea name="' + col_id + '[fld' + use_col_count + '][desc]" style="width:450px;height:50px;" onkeyup="return updateDiv(\'' + fffield_desc_div + '\',this.value)"></textarea></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Label Position</label>';    info += '  <div class="fffield_left"><input type="radio" name="' + col_id + '[fld' + use_col_count + '][label_position]" value="left" checked="checked" class="labelchange" onClick="return updateLabel(\'left\',\'' + field_label_id + '\',\'' + field_left_div + '\');" /> Left <input type="radio" name="' + col_id + '[fld' + use_col_count + '][label_position]" value="top" onClick="return updateLabel(\'top\',\'' + field_label_id + '\',\'' + field_left_div + '\');" /> Above';    info += '  </div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Upload Label</label>';    info += '    <div class="fffield_left"><input type="text" name="' + col_id + '[fld' + use_col_count + '][label]" value="" style="width:250px;" /></div>';    info += '  </div>';    info += '</div><!--end:options-->';    return info;}/** *    end:upload * ----------------------------> *//** * <---------------------------- *    Field: Select */function get_field_select(col_id, use_col_count) {    // Setup    var full_div = 'fld' + col_id + '_' + use_col_count;    var option_div_id = 'options_fld' + col_id + '_' + use_col_count;    var logic_div_id = 'logic_fld' + col_id + '_' + use_col_count;    var field_id = 'fld_' + col_id + '_' + use_col_count;    var field_name_div = 'fldname_' + col_id + '_' + use_col_count;    var field_label_div = 'fldlabel_' + col_id + '_' + use_col_count;    var field_label_id = 'fldlabel2_' + col_id + '_' + use_col_count;    var field_left_div = 'fldleft_' + col_id + '_' + use_col_count;    var fffield_desc_div = 'flddesc_' + col_id + '_' + use_col_count;    var field_label_req = 'fldreq_' + col_id + '_' + use_col_count;    // ----------------------------    //		 DISPLAY    var info = '<!--start:field_block--><div class="aflddiv" id="' + full_div + '">';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + ']" value="1" />';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + '][type]" value="select" />';    info += '<div class="fffield_entry">';    info += '<label id="' + field_label_id + '" class="ffleft"><span id="' + field_label_div + '">Untitled</span><span class="req_star" id="' + field_label_req + '">*</span></label>';    info += '<div id="' + field_left_div + '" class="fffield_left"><select id="' + field_id + '" style="width:250px;"></select><div class="fffield_desc" id="' + fffield_desc_div + '"></div></div></div>';    // ----------------------------    // 		DESCRIPTION    info += '</div><div id="' + option_div_id + '" class="option_div"><div class="delete"><a href="null.php" onclick="return deleteField(\'' + col_id + '_' + use_col_count + '\');">Delete</a></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Name</label>';    info += '  <div class="fffield_left"><input name="' + col_id + '[fld' + use_col_count + '][display_name]" style="width:250px;" onkeyup="return updateDiv(\'' + field_label_div + '\',this.value)" /></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Description</label>';    info += '  <div class="fffield_left"><textarea name="' + col_id + '[fld' + use_col_count + '][desc]" style="width:450px;height:50px;" onkeyup="return updateDiv(\'' + fffield_desc_div + '\',this.value)"></textarea></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Field Type</label>';    info += '    <div class="fffield_left"><input type="radio" name="' + col_id + '[fld' + use_col_count + '][special_type]" value="" checked="checked" /> -<br />';    info += '    <input type="radio" name="' + col_id + '[fld' + use_col_count + '][special_type]" value="country" /> Country List<br />';    info += '    <input type="radio" name="' + col_id + '[fld' + use_col_count + '][special_type]" value="state" /> State List<br />';    info += '    <input type="radio" name="' + col_id + '[fld' + use_col_count + '][special_type]" value="cell_carriers" /> Cell phone carriers';    info += '  </div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Options<br />(Enter one per line)</label>';    info += '  <div class="fffield_left"><textarea name="' + col_id + '[fld' + use_col_count + '][options]" style="width:450px;height:80px;" onblur="return addoptions(\'' + field_id + '\',this.value)"></textarea></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Label Position</label>';    info += '  <div class="fffield_left"><input type="radio" name="' + col_id + '[fld' + use_col_count + '][label_position]" value="left" checked="checked" class="labelchange" onClick="return updateLabel(\'left\',\'' + field_label_id + '\',\'' + field_left_div + '\');" /> Left <input type="radio" name="' + col_id + '[fld' + use_col_count + '][label_position]" value="top" onClick="return updateLabel(\'top\',\'' + field_label_id + '\',\'' + field_left_div + '\');" /> Above';    info += '  </div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Encrypt?</label>';    info += '    <div class="fffield_left"><input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][encrypt]" value="1" /> Encrypt this data in the database.</div>';    info += '  </div>';    info += '  <div class="fffield_entry"><label class="ffleft">Dimensions</label>';    info += '    <div class="fffield_left"><input type="text" name="' + col_id + '[fld' + use_col_count + '][width]" value="" style="width:80px;" onblur="return resize_field(\'' + field_id + '\',this.value);" />px</div>';    info += '  </div>';    info += '  <div class="fffield_entry"><label class="ffleft">Indexes</label>';    info += '    <div class="fffield_left">';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_member]" value="1" /> Member Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_contact]" value="1" /> Contact Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_event]" value="1" /> Event Registration Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_account]" value="1" /> Account Database<br />';    info += '  </div>';    info += '  </div>';    info += '</div><!--end:options-->';    return info;}/** *    end:select * ----------------------------> *//** * <---------------------------- *    Field: radio */function get_field_radio(col_id, use_col_count) {    // Setup    var full_div = 'fld' + col_id + '_' + use_col_count;    var option_div_id = 'options_fld' + col_id + '_' + use_col_count;    var logic_div_id = 'logic_fld' + col_id + '_' + use_col_count;    var field_id = 'fld_' + col_id + '_' + use_col_count;    var field_name_div = 'fldname_' + col_id + '_' + use_col_count;    var field_label_div = 'fldlabel_' + col_id + '_' + use_col_count;    var field_label_id = 'fldlabel2_' + col_id + '_' + use_col_count;    var field_left_div = 'fldleft_' + col_id + '_' + use_col_count;    var fffield_desc_div = 'flddesc_' + col_id + '_' + use_col_count;    var field_label_req = 'fldreq_' + col_id + '_' + use_col_count;    // ----------------------------    //		 DISPLAY    var info = '<!--start:field_block--><div class="aflddiv" id="' + full_div + '">';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + ']" value="1" />';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + '][type]" value="radio" />';    info += '<div class="fffield_entry">';    info += '<label id="' + field_label_id + '" class="ffleft"><span id="' + field_label_div + '">Untitled</span><span class="req_star" id="' + field_label_req + '">*</span></label>';    info += '<div id="' + field_left_div + '" class="fffield_left"><input type="radio" val="" /> --</div><div class="fffield_desc" id="' + fffield_desc_div + '"></div></div>';    // ----------------------------    // 		DESCRIPTION    info += '</div><div id="' + option_div_id + '" class="option_div"><div class="delete"><a href="null.php" onclick="return deleteField(\'' + col_id + '_' + use_col_count + '\');">Delete</a></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Name</label>';    info += '  <div class="fffield_left"><input name="' + col_id + '[fld' + use_col_count + '][display_name]" style="width:250px;" onkeyup="return updateDiv(\'' + field_label_div + '\',this.value)" /></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Description</label>';    info += '  <div class="fffield_left"><textarea name="' + col_id + '[fld' + use_col_count + '][desc]" style="width:450px;height:50px;" onkeyup="return updateDiv(\'' + fffield_desc_div + '\',this.value)"></textarea></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Options<br />(Enter one per line)</label>';    info += '  <div class="fffield_left"><textarea name="' + col_id + '[fld' + use_col_count + '][options]" style="width:450px;height:80px;" onblur="return addradoptions(\'' + field_left_div + '\',this.value)"></textarea></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Encrypt?</label>';    info += '    <div class="fffield_left"><input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][encrypt]" value="1" /> Encrypt this data in the database.</div>';    info += '  </div>';    info += '  <div class="fffield_entry"><label class="ffleft">Label Position</label>';    info += '  <div class="fffield_left"><input type="radio" name="' + col_id + '[fld' + use_col_count + '][label_position]" value="left" checked="checked" class="labelchange" onClick="return updateLabel(\'left\',\'' + field_label_id + '\',\'' + field_left_div + '\');" /> Left <input type="radio" name="' + col_id + '[fld' + use_col_count + '][label_position]" value="top" onClick="return updateLabel(\'top\',\'' + field_label_id + '\',\'' + field_left_div + '\');" /> Above';    info += '  </div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Indexes</label>';    info += '    <div class="fffield_left">';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_member]" value="1" /> Member Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_contact]" value="1" /> Contact Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_event]" value="1" /> Event Registration Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_account]" value="1" /> Account Database<br />';    info += '  </div>';    info += '  </div>';    info += '</div><!--end:options-->';    return info;}/** *    end:radio * ----------------------------> *//** * <---------------------------- *    Field: checkbox */function get_field_checkbox(col_id, use_col_count) {    // Setup    var full_div = 'fld' + col_id + '_' + use_col_count;    var option_div_id = 'options_fld' + col_id + '_' + use_col_count;    var logic_div_id = 'logic_fld' + col_id + '_' + use_col_count;    var field_id = 'fld_' + col_id + '_' + use_col_count;    var field_name_div = 'fldname_' + col_id + '_' + use_col_count;    var field_label_div = 'fldlabel_' + col_id + '_' + use_col_count;    var field_label_id = 'fldlabel2_' + col_id + '_' + use_col_count;    var field_left_div = 'fldleft_' + col_id + '_' + use_col_count;    var fffield_desc_div = 'flddesc_' + col_id + '_' + use_col_count;    var field_label_req = 'fldreq_' + col_id + '_' + use_col_count;    // ----------------------------    //		 DISPLAY    var info = '<!--start:field_block--><div class="aflddiv" id="' + full_div + '">';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + ']" value="1" />';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + '][type]" value="checkbox" />';    info += '<div class="fffield_entry">';    info += '<input type="checkbox" name="" val="1" /> <span id="' + field_label_div + '">Untitled</span><span class="req_star" id="' + field_label_req + '">*</span><span class="fffield_desc" id="' + fffield_desc_div + '" style="margin-left: 12px;"></span>';    // ----------------------------    // 		DESCRIPTION    info += '</div><div id="' + option_div_id + '" class="option_div"><div class="delete"><a href="null.php" onclick="return deleteField(\'' + col_id + '_' + use_col_count + '\');">Delete</a></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Name</label>';    info += '  <div class="fffield_left"><input name="' + col_id + '[fld' + use_col_count + '][display_name]" style="width:250px;" onkeyup="return updateDiv(\'' + field_label_div + '\',this.value)" /></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Description</label>';    info += '  <div class="fffield_left"><textarea name="' + col_id + '[fld' + use_col_count + '][desc]" style="width:450px;height:50px;" onkeyup="return updateDiv(\'' + fffield_desc_div + '\',this.value)"></textarea></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Encrypt?</label>';    info += '    <div class="fffield_left"><input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][encrypt]" value="1" /> Encrypt this data in the database.</div>';    info += '  </div>';    info += '  <div class="fffield_entry"><label class="ffleft">Indexes</label>';    info += '    <div class="fffield_left">';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_member]" value="1" /> Member Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_contact]" value="1" /> Contact Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_event]" value="1" /> Event Registration Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_account]" value="1" /> Account Database<br />';    info += '  </div>';    info += '  </div>';    info += '</div><!--end:options-->';    return info;}/** *    end:checkbox * ----------------------------> *//** * <---------------------------- *    Field: date */function get_field_date(col_id, use_col_count) {    // Setup    var full_div = 'fld' + col_id + '_' + use_col_count;    var option_div_id = 'options_fld' + col_id + '_' + use_col_count;    var logic_div_id = 'logic_fld' + col_id + '_' + use_col_count;    var field_id = 'fld_' + col_id + '_' + use_col_count;    var field_name_div = 'fldname_' + col_id + '_' + use_col_count;    var field_label_div = 'fldlabel_' + col_id + '_' + use_col_count;    var field_label_id = 'fldlabel2_' + col_id + '_' + use_col_count;    var field_left_div = 'fldleft_' + col_id + '_' + use_col_count;    var fffield_desc_div = 'flddesc_' + col_id + '_' + use_col_count;    var field_label_req = 'fldreq_' + col_id + '_' + use_col_count;    // ----------------------------    //		 DISPLAY    var info = '<!--start:field_block--><div class="aflddiv" id="' + full_div + '">';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + ']" value="1" />';    info += '<input type="hidden" name="' + col_id + '[fld' + use_col_count + '][type]" value="date" />';    info += '<div class="fffield_entry">';    info += '<label id="' + field_label_id + '" class="ffleft"><span id="' + field_label_div + '">Untitled</span><span class="req_star" id="' + field_label_req + '">*</span></label>';    info += '<div id="' + field_left_div + '" class="fffield_left"><input type="text" name="" value="Preview unavailable" class="remove" /><div class="fffield_desc" id="' + fffield_desc_div + '"></div></div></div>';    // ----------------------------    // 		DESCRIPTION    info += '</div><div id="' + option_div_id + '" class="option_div"><div class="delete"><a href="null.php" onclick="return deleteField(\'' + col_id + '_' + use_col_count + '\');">Delete</a></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Name</label>';    info += '  <div class="fffield_left"><input name="' + col_id + '[fld' + use_col_count + '][display_name]" style="width:250px;" onkeyup="return updateDiv(\'' + field_label_div + '\',this.value)" /></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Description</label>';    info += '  <div class="fffield_left"><textarea name="' + col_id + '[fld' + use_col_count + '][desc]" style="width:450px;height:50px;" onkeyup="return updateDiv(\'' + fffield_desc_div + '\',this.value)"></textarea></div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Label Position</label>';    info += '  <div class="fffield_left"><input type="radio" name="' + col_id + '[fld' + use_col_count + '][label_position]" value="left" checked="checked" class="labelchange" onClick="return updateLabel(\'left\',\'' + field_label_id + '\',\'' + field_left_div + '\');" /> Left <input type="radio" name="' + col_id + '[fld' + use_col_count + '][label_position]" value="top" onClick="return updateLabel(\'top\',\'' + field_label_id + '\',\'' + field_left_div + '\');" /> Above';    info += '  </div></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Year Range</label>';    info += '  <input type="text" name="' + col_id + '[fld' + use_col_count + '][options][year_low]" style="width:80px;"> <input type="text" name="' + col_id + '[fld' + use_col_count + '][options][year_high]" style="width:80px;"></div>';    info += '  <div class="fffield_entry"><label class="ffleft">Indexes</label>';    info += '    <div class="fffield_left">';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_member]" value="1" /> Member Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_contact]" value="1" /> Contact Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_event]" value="1" /> Event Registration Database<br />';    info += '    <input type="checkbox" name="' + col_id + '[fld' + use_col_count + '][index_account]" value="1" /> Account Database<br />';    info += '  </div>';    info += '  </div>';    info += '</div><!--end:options-->';    return info;}/** *    end:date * ----------------------------> */function populate_field(col_id, use_col_count, id) {}function show(id) {    $('#' + id).slideToggle();}function resize_field(id, val) {    if (!val) {        val = '100%';    }    $('#' + id).width(val);}function resize_field_height(id, val) {    if (!val) {        val = '100%';    }    $('#' + id).height(val);}function updateDiv(id, val) {    $('#' + id).html(val);}function updateLabel(pos, label_id, field_div_id) {    if (pos == 'top') {        $('#' + label_id).removeClass('ffleft');        $('#' + label_id).addClass('fftop');        $('#' + field_div_id).removeClass('fffield_left');    } else {        $('#' + label_id).removeClass('fftop');        $('#' + label_id).addClass('ffleft');        $('#' + field_div_id).addClass('fffield_left');    }}function addoptions(listid, val) {    $('#' + listid).find('option').remove();    var opts = val.split(/\n/);    for (var i = 0; i < opts.length; i++) {        $('#' + listid).append('<option>' + opts[i] + '</option>');    }}function addradoptions(listid, val) {    $('#' + listid).html('');    var opts = val.split(/\n/);    var together = '';    for (var i = 0; i < opts.length; i++) {        together += '<input type="radio" name="" value="' + opts[i] + '" /> ' + opts[i] + '<br />';    }    $('#' + listid).html(together);}function toggle_req(id) {    $('#' + id).toggle();}function deleteField(id) {    $('#' + id).fadeOut('100', function () {        $('#' + id).remove();    });    return false;}