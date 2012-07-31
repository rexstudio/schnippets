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

// Debug Mode
ini_set("display_errors", 0);                       // PHP Debug Mode
 
//App vars
define('SALT','QuC6d0XJLiqiXiLh');                  // Salt the user passwords to make them harder to reverse the stored hash
define('COOKIE_SALT', 'HJGHGFDSGIU3273247abju@@#'); // Salt for cookie logins
define('APP_SES','schnippets');                     // Give the session variables a name
define('DEBUG_MAIL',true);                          // If Debug is true will just echo out, If False it will Send out real emails
define('FROM_EMAIL_ADDRESS','Changeme@ISP.com');    // System FROM email address

// Database Connection Information
define('DB_TYPE', 'mysql');			                // Database Type
define('DB_USER', 'schnippets');                    // Database Username
define('DB_PASS', 'your_database_password');        // Database Password
define('DB_HOST', 'localhost');                     // Database Hostname 
define('DB_NAME', 'schnippets');                    // Database Name

// get base directory of install
define('BASE_DIR', dirname(__FILE__));
define('SLASH', '/');

// required files
require(BASE_DIR . '/application.php');
require(BASE_DIR . '/library/geshi/geshi.php');
require(BASE_DIR . '/include/functions.php');
require(BASE_DIR . '/include/constants.php');

// Define assets for plugins
$enabled_plugins = array(
	'tagcloud'=>array('js'=>'tagcloud.js','css'=>'tagcloud.css','menu'=>'TagCloud'),
);

?>
