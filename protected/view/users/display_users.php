<?php

/**
 * @copyright (C) 2012 TheRexStudio
 * @author Robert Strutts
 */

foreach($list_of_users as $usr) {
    echo "<a class='menu' href='?route=/users/users&m=changeprofile&id={$usr['id']}'>{$usr['fname']} {$usr['lname']}</a><br/>";
}
?>