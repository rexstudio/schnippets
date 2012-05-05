<?php

/**
 * @copyright (C) 2012 TheRexStudio
 * @author Robert Strutts
 */
?>
<form name="change_details" method="post">
    <div class="field-item row short">
        <label for="fname">First Name</label>
        <input type="text" name="fname" value="<?php echo $_SESSION[APP_SES.'fname']; ?>" />
    </div>
    <div class="field-item row short">
        <label for="lname">Last Name</label>
        <input type="text" name="lname" value="<?php echo $_SESSION[APP_SES.'lname']; ?>" />
    </div>
    <div class="field-item row short">
        <label for="email">Update Email</label>
        <input type="text" name="email" value="" />
        <em><?php echo $_SESSION[APP_SES.'email']; ?></em>
    </div>
    <div class="spacer"></div>
    <div class="field-item">
        <input type="submit" name="changedetails" value="Update Profile" />
    </div>

</form>