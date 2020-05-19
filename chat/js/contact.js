/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.3                   # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

$(document).ready(function(){var working=false;$('.jak-ajaxform').submit(function(e){e.preventDefault();if(working)return false;working=true;var lsform=$(this);var button=$(this).find('.ls-submit');$(this).find('input').removeClass("is-invalid");$(this).find('input').removeClass("is-valid");$(this).find('#name-help').html("");$(button).html(ls.ls_submitwait);var request=$.ajax({url:ls.main_url+ls.lsrequest_uri,type:"POST",data:$(this).serialize(),dataType:"json",processData:false,cache:false});request.done(function(msg){working=false;$(button).html(ls.ls_submit);if(msg.status){$('.jak-thankyou').addClass("alert alert-success").fadeIn(1000).html(msg.html);$(lsform)[0].reset();$(lsform).fadeOut().delay('500')}else if(msg.login){window.location.replace(msg.link)}else{$.each(msg.errors,function(k,v){$('#'+k).addClass("is-invalid");$(lsform).find('#name-help').html(v)})}working=false})})});