<?php

/**
 * @copyright (C) 2012 TheRexStudio
 * @author Robert Strutts
 */
?>
<form name="change_details" method="post">
    <div class="field-item row short">
        <label for="fname">First Name</label>
        <input type="text" name="fname" value="<?php echo $profile['fname']; ?>" />
    </div>
    <div class="field-item row short">
        <label for="lname">Last Name</label>
        <input type="text" name="lname" value="<?php echo $profile['lname']; ?>" />
    </div>
    <div class="field-item row short">
        <label for="email">Update Email</label>
        <input type="text" name="email" value="" />
        <em><?php echo $profile['email']; ?></em>
    </div>

<?php if ($_SESSION[APP_SES.'id'] != $profile['id']) : ?>

<div class="field-item row short">
    <label for="user_type">Access Level</label>
    <select name="user_type">
        <option value="1">Regular User</option>
        <option value="30" <?php if ($profile['user_type']=='30') echo 'selected'; ?>>Admin User</option>
        <option value="0" <?php if ($profile['user_type']=='0') echo 'selected'; ?>>Disabled User</option>
    </select>
</div>

<?php endif; ?>

<div class="spacer"></div>

<div class="field-item">
    <input type="submit" name="changedetails" value="Update Profile" />    
</div>
</form>