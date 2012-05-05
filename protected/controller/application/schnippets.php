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

class applicationschnippets extends Application {
    public $temp = array();

    public function index() {
        $this -> loadModel(SLASH . 'users' . SLASH . 'user');
        $user = new User;
        $data['users'] = $user -> get_users();
        $this -> loadView(SLASH . 'application' . SLASH . 'schnippets', TRUE, $data);
    }

    public function download() {
        $id = intval($_GET['id']);

        $this -> loadModel('schnippet');
        $schnippet = new Schnippet;
        $schnippet -> load($id);

        if ($schnippet -> getMember('protected') == 'on' && (!isset($_SESSION[APP_SES . 'id']) || $_SESSION[APP_SES . 'id'] == 0)) {
            $_SESSION[APP_SES . 'route'] = '/application/schnippets&m=edit&id=' . $_GET['id'];
            gotoUrl('/?route=/users/users');
            exit ;
        }

        // remove all non-alphanumeric characters from title to make filename then replace whitespace with underscores
        $title = cleanString($schnippet -> getMember('title'));

        // get file extension
        $ext = getExt($schnippet -> getMember('lang'));

        header("Content-Type: plain/text");
        header("Content-Disposition: Attachment; filename={$title}.{$ext}");
        header("Pragma: no-cache");

        echo $schnippet -> getMember('code');
    }

    public function insert() {
        if (!isset($_SESSION[APP_SES . 'id']) || $_SESSION[APP_SES . 'id'] == 0) {
            $_SESSION[APP_SES . 'route'] = '/application/schnippets&m=insert';
            gotoUrl('/?route=/users/users');
            exit ;
        }
        if (!isset($_POST['save'])) {
            $this -> setTitle("Add a Schnippet");
            $this -> loadView(SLASH . 'application' . SLASH . 'insert');
        } else {
            $this -> loadModel('schnippet');
            $schnippet = new Schnippet;
            $schnippet -> setMembers($_POST);
            $schnippet -> save();
            gotoUrl('/?route=/application/schnippets&m=get&id=' . $schnippet -> getPrimaryKey());
        }
    }

    public function edit() {
        if (!isset($_SESSION[APP_SES . 'id']) || $_SESSION[APP_SES . 'id'] == 0) {
            $_SESSION[APP_SES . 'route'] = '/application/schnippets&m=edit&id=' . $_GET['id'];
            gotoUrl('/?route=/users/users');
            exit ;
        }
        $this -> loadModel('schnippet');
        $id = intval($_GET['id']);
        $schnippet = new Schnippet;
        $schnippet -> load($id);
        $data['schnippet'] = $schnippet -> getMembers();
        if (!isset($_POST['save'])) {
            $this -> setTitle('Update a Schnippet');
            $this -> loadView(SLASH . 'application' . SLASH . 'edit', TRUE, $data);
        } else {
            $schnippet -> setMembers($_POST);
            $schnippet -> save();
            gotoUrl('/?route=/application/schnippets&m=get&id=' . $schnippet -> getPrimaryKey());
        }
    }

    public function get() {
        $id = intval($_GET['id']);

        $this -> loadModel('schnippet');
        $schnippet = new Schnippet;
        $schnippet -> load($id);

        if ($schnippet -> getMember('protected') == 'on' && (!isset($_SESSION[APP_SES . 'id']) || $_SESSION[APP_SES . 'id'] == 0)) {
            $_SESSION[APP_SES . 'route'] = '/application/schnippets&m=edit&id=' . $_GET['id'];
            gotoUrl('/?route=/users/users');
            exit ;
        }

        $this -> loadModel(SLASH . 'users' . SLASH . 'user');
        $data['user'] = new User;

        $data['schnippet'] = $schnippet -> getMembers();

        $this -> setTitle($schnippet -> getMember('title'));
        $this -> loadView(SLASH . 'application' . SLASH . 'get', TRUE, $data);
    }

    public function search() {
        $this -> loadModel('schnippet');
        $schnippet = new Schnippet;

        if ($_GET['search'] == 'latest') {
            $data['title'] = 'Latest Schnippets';
            $searchObject = new stdClass;
            $order = 'time DESC';
            $limit = '0, 25';
        } else if ($_GET['search'] == 'search') {
            $data['title'] = 'Search Results';
            $searchObject = (object)$_GET;
            $order = 'title ASC';
            $limit = '0, 18446744073709551615';
        }
        $this -> loadModel(SLASH . 'users' . SLASH . 'user');
        $data['user'] = new User;

        $result = $schnippet -> search($searchObject, $order, $limit);
        $data['result'] = $result;
        $this -> loadView(SLASH . 'application' . SLASH . 'search', FALSE, $data);
    }

}
?>