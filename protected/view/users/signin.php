<?php

/**
 * @copyright (C) 2012 TheRexStudio
 * @author Robert Strutts
 */

?>

<div id="signin">
<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<form method="post">
    
<div class="field-item short row">    
    <input type="text" name="email" id="email" class="login-box login-style login-email-dark" value="" />
</div>
<div class="field-item short row">    
    <input type="password" name="password" id="password" class="login-box login-style login-pwd-dark" value="" /> 
</div>
<div class="spacer"></div>
<div class="field-item row">
    <input type="submit" name="login" value="Login" />
</div>
<div class="row">
    <a href="?route=/users/users&m=forgotpwd">Forgot Password</a>
</div>    
</form>    
</div>    