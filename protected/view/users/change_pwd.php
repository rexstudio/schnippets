<?php

/**
 * @copyright (C) 2012 TheRexStudio
 * @author Robert Strutts
 */
?>
<script type="text/javascript">
function checkpwd() {
    pwd = document.getElementById('password').value;
    confirm = document.getElementById('confirm').value;
    if (pwd == '') {
        alert('Please enter your new password');
        return false;
    }
    if (pwd != confirm) {
        alert('Password and Confirm password must match.');
        return false;
    } else {
        return true;
    }
} 
</script>    
<div id="changepwd">
<form name="changepassword" method="post">
    <div class="field-item row short">
        <label for="current">Current Password</label>
        <input type="password" name="current" />
    </div>
    <div class="field-item row short">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" />
    </div>
    <div class="field-item row short">
        <label for="confirm">Confirm Password</label>
        <input type="password" name="confirm" id="confirm" />
    </div>

<div class="spacer"></div>
<div class="field-item row">
    <input type="submit" name="changepwd" value="Reset Password" onclick="return checkpwd();"/>
</div>

</form>    
</div>   