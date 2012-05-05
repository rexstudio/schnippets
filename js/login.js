$(document).ready(function(){
    
    $("#email").focus(function(){
        if ($(this).val() == '') {
            $(this).removeClass('login-email-dark');
            $(this).addClass('login-email-light');
        }
    });
    
    $("#email").blur(function(){
        if ($(this).val() == '') {
            $(this).removeClass('login-email-light');
            $(this).addClass('login-email-dark');
        }
    });
    
    $("#email").keydown(function(){
        $(this).removeClass('login-email-light');
        if ($(this).val().length == 1 && (event.keyCode == 8 || event.keyCode == 46)) {
            $(this).addClass('login-email-light');
        }
    });
    
    $("#password").focus(function(){
        if ($(this).val() == '') {
            $(this).removeClass('login-pwd-dark');
            $(this).addClass('login-pwd-light');
        }
    });
    
    $("#password").blur(function(){
        if ($(this).val() == '') {
            $(this).removeClass('login-pwd-light');
            $(this).addClass('login-pwd-dark');
        }
    });
    
    $("#password").keydown(function(){
        $(this).removeClass('login-pwd-light');
        if ($(this).val().length == 1 && (event.keyCode == 8 || event.keyCode == 46)) {
            $(this).addClass('login-pwd-light');
        }
    });

});