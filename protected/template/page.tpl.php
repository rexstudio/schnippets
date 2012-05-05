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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html>
    <head profile="http://www.w3.org/1999/xhtml/vocab">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="https://www.therexstudio.com/sites/all/themes/rexstudio_theme/favicon.ico" type="image/vnd.microsoft.icon" />
        <link href='http://fonts.googleapis.com/css?family=Iceland' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="/css/reset.css" type="text/css" media="all" />
        <link rel="stylesheet" href="/css/text.css" type="text/css" media="all" />
        <link rel="stylesheet" href="/css/jquery-ui.css" type="text/css" media="all" />
        <link rel="stylesheet" href="/css/style.css" type="text/css" media="all" />
        <link rel="stylesheet" href="/css/print.css" type="text/css" media="print" />
        <?php echo $this -> styles; ?>
        <script src="/js/jquery.min.js" type="text/javascript"></script>
        <script src="/js/jquery-ui.min.js" type="text/javascript"></script>
        <script src="/js/jquery.tablesorter.min.js" type="text/javascript"></script>
        <script src="/js/index.js" type="text/javascript"></script>
        <?php echo $this -> scripts; ?>
        <title><?php echo (isset($this->title)) ? $this->title . " | Schnippets" : 'Schnippets';
            ?></title>
    </head>
    <body>
        <div id="header-wrapper">
            <div id="header">
                <a href="index.php"><h1 class="title">Schnippets<span>{}</span></h1></a>
            </div>
        </div>
        <div id="spacer-header"></div>
        <div id="container" class="drop-shadow">
            <?php if (isset($_SESSION['message'])): ?>
            <div id="message">
                <div id="message-close"></div>
                <div id="message-content">
                    <?php echo $_SESSION['message']; ?>
                </div>
            </div>
            <?php
            unset($_SESSION['message']);
            endif;
            ?>
            <div id="main-menu">
                <ul>
                    <li>
                        <a href="/?route=/application/schnippets&m=insert">Add</a>
                    </li>
                    <li>
                        <a href="index.php">Search</a>
                    </li>
                    <li>
                        <a href="javascript:showSearchResults('all');">Latest</a>
                    </li>
                    <?php echo $this -> menu; ?>
                    <?php if (!isset($_SESSION[APP_SES.'id']) || $_SESSION[APP_SES.'id'] == 0) :
                    ?>
                    <li>
                        <a href="/?route=/users/users">Log in</a>
                    </li>
                    <?php else : ?>
                    <li>
                        <a href="/?route=/users/users&m=pagelist">User Options</a>
                    </li>
                    <li>
                        <a href="/?route=/users/users&m=logout">Log out</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div id="main">
                <div id="expand">
                    Expand
                </div>
                <?php
                    echo (isset($this->title)) ? '<h1>' . $this->title . '</h1>' : '';
                    print $this->output;
                ?>
            </div>

            <div class="clear"></div>
        </div>
        <div id="spacer-footer"></div>
        <div id="footer-wrapper">
            <div id="footer">
                <div class="left">
                    &copy; <?php echo date('Y'); ?>
                    Rex Studio Inc. All rights reserved.
                </div>
                <div class="right">
                    <a href="https://www.therexstudio.com" title="Designed and Built by Rex Studio Inc."><img src="images/rex_stamp.png" /></a>
                </div>
            </div>
        </div>
        <div id="overlay">
            <div id="overlay-inner">
                <div id="overlay-close"></div>
                <div id="overlay-content"><img id="loader" src="images/loader.gif" />
                </div>
            </div>
        </div>
    </body>
</html>