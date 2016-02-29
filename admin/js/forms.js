function check_username_availability(e,t){url=zen_url+"/pp-functions/check_username.php";send_data="username="+e;$.post(url,send_data,function(e){if(e==1){error_found=1;applyError(t,"Username already in use.")}})}function match_passwords(e){if($("input[name=repeat_pwd]").val()!=$("input[name=password]").val()){error_found=1;applyError(e,"Passwords do not match.")}}function password_strength(e){var t=0;var n=e.length;var r=n-7;t+=r;var i=0;if(e.match(/(?=.*[a-z])/))i+=1;if(e.match(/(?=.*[A-Z])/))i+=1;if(e.match(/(?=.*\d)/))i+=1;if(e.match(/(?=.*[_\W])/))i+=1;if(i==4){t+=3}else if(i==3){t+=2}else if(i==2){t+=1}else{t-=3}return t}function check_form(e){if(!e){e="slider_form"}error_found=0;error_display="";$("#"+e+" input.req, #"+e+" select.req, #"+e+" textarea.req").each(function(e){id=$(this).attr("id");type=$(this).attr("type");$(this).removeClass("warning");if(type=="checkbox"){}else{name=$(this).attr("name");if($(this).val().length===0){if(name!="password"){id=$(this).attr("id");applyError(id)}}}});$(".zen_num").each(function(e){removeError(id);if($(this).hasClass("req")||$(this).val().length>0){id=$(this).attr("id");name=$(this).attr("name");if(/^[0-9]+$/.test($(this).val())!==true){error_found=1;applyError(id,"Numbers only!")}}});$(".zen_letnum").each(function(e){removeError(id);if($(this).hasClass("req")||$(this).val().length>0){id=$(this).attr("id");name=$(this).attr("name");if(/^[0-9a-zA-Z�����������������������������������������������������]+$/.test($(this).val())!==true){error_found=1;applyError(id,"Letters and numbers only!")}}});$(".zen_let").each(function(e){removeError(id);if($(this).hasClass("req")||$(this).val().length>0){id=$(this).attr("id");name=$(this).attr("name");if(/^[a-zA-Z�����������������������������������������������������]+$/.test($(this).val())!==true){error_found=1;applyError(id,"Letters only!")}}});$(".zen_money").each(function(e){removeError(id);if($(this).hasClass("req")||$(this).val().length>0){id=$(this).attr("id");name=$(this).attr("name");if(/^[0-9.]+$/.test($(this).val())!==true){error_found=1;applyError(id,"Input a proper value.")}}});$("#"+e+" input.email").each(function(e){if($(this).hasClass("req")||$(this).val().length>0){check_em=check_email($(this).val());id=$(this).attr("id");name=$(this).attr("name");if(check_em!="1"){error_found=1;applyError(id,"Incorrect email format!")}else{removeError(id)}}});if(error_found==1){var t="An error occurred with the following fields:<ul>"+error_display+"</ul>";handle_error(t);return false}else{return true}}function zen_check_length(e,t){removeError(t);if($("#"+t).val().length<e){error_found=1;applyError(t,"Must be greater than "+e+" characters in length.")}}function applyError(e,t){error_found=1;$("#"+e).addClass("warning");$("#blockerror"+e).html(t);var n=$("#"+e).attr("name");error_display+="<li>"+n+"</li>";if(t){showDiv("blockerror"+e)}}function removeError(e){$("#"+e).removeClass("warning");hideDiv("blockerror"+e)}function check_email(e){var t=new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);if(t.test(e)===false){return"0"}else{return"1"}}function showDiv(e){$("#"+e).fadeIn("50")}function hideDiv(e){$("#"+e).fadeOut("50")}function removeDiv(e){$("#"+e).remove()}var error_found=0;var error_display="";$(document).ready(function(){$("input.req, select.req, textarea.req").blur(function(){$(this).removeClass("warning");id=$(this).attr("id");name=$(this).attr("name");if($(this).val().length===0){if(name!="password"){id=$(this).attr("id");applyError(id)}}else{removeError(id)}});$("input.email").blur(function(e){if($(this).hasClass("req")||$(this).val().length>0){check_em=check_email($(this).val());id=$(this).attr("id");if(check_em!="1"){error_found=1;applyError(id,"Incorrect email format!")}else{removeError(id)}}});$("li.zen_hoverable").hover(function(){$(this).parent().find("ul").slideDown()},function(){$(this).parent().find("ul").slideUp()});$("input[name=username]").blur(function(e){check_username_availability(this.value,this.id)});$("input[name=repeat_pwd]").blur(function(e){match_passwords(this.id)})});