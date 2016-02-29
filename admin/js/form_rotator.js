/** * Creates a "step-by-step" form with * only one step visible at a time. */var cur_page = 0;var count = 0;function next() {    temp_page = cur_page;    cur_page += 1;    if (cur_page >= count) {        cur_page = count - 1;    }    ;    goToStep(cur_page, temp_page);}function prev() {    temp_page = cur_page;    cur_page -= 1;    if (cur_page < 0) {        cur_page = 0;    }    ;    goToStep(cur_page, temp_page);}function goToStep(nextStep, onStep) {    if (!onStep && onStep != '0') {        onStep = cur_page;    }    $("#theStepList li").removeClass('on');    $("#formlist li.form_step").hide();    $("#formlist li.form_step:eq(" + nextStep + ")").show();    $("#theStepList li:eq(" + nextStep + ")").addClass('on');    update_popup_height();    return false;}$(document).ready(function () {    $("#formlist li.form_step").hide();    $("#formlist li.form_step:eq(" + cur_page + ")").show();    count = $("#formlist li.form_step").length;});