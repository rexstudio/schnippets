<?php

/*
 *  * Copyright (C) 2012 Rex Studio Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact Rex Studio Inc at 607 E. Second Ave. Suite 40 Flint, MI 48502 or
 * at email address support@therexstudio.com
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Rex Studio Designed
 *  and Built" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Rex Studio Designed and Built".
 *
 * @author Andy Lawrence (alawrence@therexstudio.com)
 * @author Robert Strutts (rstrutts@therexstudio.com)
 */

/**
 * Convert database lang to file extension
 *
 * @param type $type
 * @return string
 */
function getExt($type) {
    switch ($type) {
        case 'php' :
            $ext = 'php';
            break;
        case 'javascript' :
            $ext = 'js';
            break;
        case 'css' :
            $ext = 'css';
            break;
        case 'sql' :
            $ext = 'sql';
            break;
        case 'bash' :
            $ext = 'sh';
            break;
        case 'text' :
            $ext = 'txt';
            break;
        default :
            $ext = 'txt';
    }
    return $ext;
}

/**
 * remove non-alphanumeric chars and replace whitespace with underscores
 *
 * @param type $string
 * @return type
 */
function cleanString($string) {
    $string = preg_replace("/[^a-zA-Z0-9\s]/", " ", $string);
    return preg_replace("/\s+/", "_", $string);
}

/**
 * Check string and return "none" if empty
 *
 * @param type $string
 */
function emptyString($string) {
    if (strlen(cleanString($string)) == 0) {
        return '<span class="empty">none</span>';
    }
    return $string;
}

/**
 * Redirect page to given URL
 *
 * @param unknown_type $url
 * @param unknown_type $http_response_code
 */
function gotoUrl($url, $http_response_code = 302) {
    header('Location: ' . $url, TRUE, $http_response_code);
}

/**
 * wrap css file in tag
 */
function wrapCSS($file, $media = 'all') {
    return '<link rel="stylesheet" href="' . $file . '" type="text/css" media="' . $media . '" />';
}

/**
 * wrap js file in tag
 */
function wrapJS($file) {
    return '<script src="' . $file . '" type="text/javascript"></script>';
}

/**
 * wrap menu item in proper div
 */
function wrapMenu($plugin, $title) {
    return "<li><a href='?route=/{$plugin}/{$plugin}'>{$title}</a></li>";
}

function generatePassword($length = 8) {

    // start with a blank password
    $password = "";

    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);

    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
        $length = $maxlength;
    }

    // set up a counter for how many characters are in the password so far
    $i = 0;

    // add random characters to $password until $length is reached
    while ($i < $length) {
        // pick a random character from the possible ones
        $char = substr($possible, mt_rand(0, $maxlength - 1), 1);

        // have we already used this character in $password?
        if (!strstr($password, $char)) {
            // no, so it's OK to add it onto the end of whatever we've already got...
            $password .= $char;
            // ... and increase the counter by one
            $i++;
        }

    }
    // done!
    return $password;

}

/**
 * send email function
 */
function send_email($email, $subject, $msg, $from) {
    if (defined("DEBUG_MAIL") && DEBUG_MAIL == true) {
        echo "Email Debugging mode: ON!<br/>";
        echo "{$email} {$subject}";
        echo '<pre>';
        print_r($msg);
        echo '</pre>';
    } else {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        // Additional headers
        $headers .= 'To: ' . $email . ' <' . $email . '>' . "\r\n";
        $headers .= 'From: Fournex <' . $from . '>' . "\r\n";
        mail($email, $subject, $msg, $headers);
    }
}

/**
 * set system message to be displayed on next page load
 */
function setMessage($message) {
    $_SESSION['message'] .= '<div class="message-item">' . $message . '</div>';
}
?>
