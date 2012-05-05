<?php

/**
 * @copyright (C) 2012 TheRexStudio
 * @author Robert Strutts
 */
?>
<div id="adduser">
<form name="adduser" method="post">
    <div class="field-item row short">
        <label for="fname">First Name</label>
        <input type="text" name="fname" />
    </div>
    <div class="field-item row short">
        <label for="lname">Last Name</label>
        <input type="text" name="lname" />
    </div>
    <div class="field-item row short">
        <label for="accesslevel">Access Level</label>
        <select name="accesslevel">
            <option value="1">Regular User</option>
            <option value="30">Admin User</option>
        </select>
    </div>
    <div class="field-item row short">
        <label for="email">Email</label>
        <input type="text" name="email" />
    </div>
    <div class="field-item row short">
        <label for="password">Password</label>
        <input type="text" name="password" />
    </div>

    <div class="field-item">
        <input type="submit" name="addnewuser" value="Create User" />
    </div>

</form>    
</div>    