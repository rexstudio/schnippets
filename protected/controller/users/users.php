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

class usersusers extends Application {
    const power_user = 20;

    public function index() {
        $this -> loadModel(SLASH . 'users' . SLASH . 'user');
        $user = new User;
        $status = 0;
        $status = $user -> validate_login();

        switch ($status) {
            case LOGIN_INVALID :
                if (isset($_POST['login'])) {
                    setMessage("Username or Password is incorrect.");
                }
                $this -> addJS('/js/login.js');
                $this -> loadView(SLASH . 'users' . SLASH . 'signin');
                exit ;
                break;
            case LOGIN_DISABLED :
                setMessage("User account has been disabled.");
                gotoUrl('/?route=/users/users&m=logout');
                exit ;
                break;
            case LOGIN_RESET :
                setMessage("A password reset has been requested.");
                gotoUrl('/?route=/users/users&m=changepwd');
                exit ;
                break;
            case LOGIN_SUCCESS :
                // successful login, do nothing;
                break;
            default :
                setMessage("Something bad has happened.  Head for the hills.");
                gotoUrl('/');
                exit ;
                break;
        }

        if (isset($_SESSION[APP_SES . 'route']) && !empty($_SESSION[APP_SES . 'route'])) {
            gotoUrl('/?route=' . $_SESSION[APP_SES . 'route']);
        }
        $this -> setTitle("User Options");
        if ($_SESSION[APP_SES . 'user_type'] > self::power_user) {
            $this -> loadPartView(SLASH . 'users' . SLASH . 'admin_pages', TRUE);
            $this -> loadPartView(SLASH . 'users' . SLASH . 'user_pages', FALSE);

        } else {
            $this -> loadPartView(SLASH . 'users' . SLASH . 'user_pages', TRUE);
        }
        $this -> loadPartView(SLASH . 'users' . SLASH . 'index', FALSE);
        $this -> endView();
    }

    public function logout() {
        unset($_SESSION[APP_SES . 'id']);
        unset($_SESSION[APP_SES . 'fname']);
        unset($_SESSION[APP_SES . 'lname']);
        $message = $_SESSION['message'];
        session_destroy();
        session_start();
        $_SESSION['message'] = $message;
        setMessage('You have been successfully logged out.');
        gotoUrl('/?route=/users/users');
        exit ;
    }

    public function adduser() {
        if (!isset($_SESSION[APP_SES . 'id']) || $_SESSION[APP_SES . 'id'] == 0) {
            gotoUrl('/?route=/users/users');
            exit ;
        }

        if ($_SESSION[APP_SES . 'user_type'] < self::power_user) {
            $this -> loadView(SLASH . 'users' . SLASH . 'access_denied');
            exit ;
        }

        if (isset($_POST['addnewuser'])) {
            $this -> loadModel(SLASH . 'users' . SLASH . 'user');
            $user = new User;
            if ($user -> email_exists()) {
                $this -> loadView(SLASH . 'users' . SLASH . 'email_already_exists');
            } else {
                $pwd = md5(SALT . $_POST['password']);
                $user -> setMembers(array('email' => $_POST['email'], 'fname' => $_POST['fname'], 'lname' => $_POST['lname'], 'password' => $pwd, 'temp_pwd' => '0', 'user_type' => $_POST['accesslevel']));
                $user -> save();
                setMessage("User has been successfully added.");
                gotoUrl('/?route=/users/users&m=listusers');
                exit ;
            }
        } else {
            $this -> setTitle('Add User');
            $this -> loadView(SLASH . 'users' . SLASH . 'adduser');
        }
    }

    public function forgotpwd() {
        if (isset($_POST['forgotpwd'])) {
            $this -> loadModel(SLASH . 'users' . SLASH . 'user');
            $user = new User;
            $system_id = $user -> get_email_id();
            if ($system_id > 0) {
                $user -> load($system_id);
                $pwd_clear_text = generatePassword();
                $pwd = md5(SALT . $pwd_clear_text);
                $user -> setMember('password', $pwd);
                $user -> setMember('temp_pwd', '1');
                //Force password change on next login
                $user -> save();
                $email = $_REQUEST['email'];
                $subject = "Your password has been reset";
                $msg = "Hello, Your temporary password is now {$pwd_clear_text}.";
                $from = FROM_EMAIL_ADDRESS;
                send_email($email, $subject, $msg, $from);
                $this -> loadView(SLASH . 'users' . SLASH . 'pwd_email_sent');
            } else {
                $this -> loadView(SLASH . 'users' . SLASH . 'user_does_not_exist');
            }
        } else {
            $this -> loadView(SLASH . 'users' . SLASH . 'forgot');
        }
    }

    /**
     * @todo add password complexity meter
     */
    public function changepwd() {
        if (!isset($_SESSION[APP_SES . 'id']) || $_SESSION[APP_SES . 'id'] == 0) {
            gotoUrl('/?route=/users/users');
            exit ;
        }
        if (isset($_POST['changepwd'])) {
            $this -> loadModel(SLASH . 'users' . SLASH . 'user');
            $user = new User;
            if ($user -> still_authorized()) {

                $user -> load($_SESSION[APP_SES . 'id']);
                $pwd = md5(SALT . $_POST['password']);
                $user -> setMember('password', $pwd);
                $user -> setMember('temp_pwd', '0');
                $user -> save();
                setMessage("Your Password Has Been Successfully Updated");
                gotoUrl('/?route=/users/users&m=pagelist');
                exit ;
            } else {
                $this -> setTitle('Change Password');
                $this -> loadView(SLASH . 'users' . SLASH . 'change_pwd');
            }

        } else {
            $this -> setTitle('Change Password');
            $this -> loadView(SLASH . 'users' . SLASH . 'change_pwd');
        }
    }

    public function changename() {
        if (!isset($_SESSION[APP_SES . 'id']) || $_SESSION[APP_SES . 'id'] == 0) {
            gotoUrl('/?route=/users/users');
            exit ;
        }
        if (isset($_POST['changedetails'])) {
            $this -> loadModel(SLASH . 'users' . SLASH . 'user');
            $user = new User;
            $user -> load($_SESSION[APP_SES . 'id']);

            if (isset($_POST['email']) && !empty($_POST['email'])) {
                if ($user -> email_exists()) {
                    $this -> setTitle('Update Profile');
                    $this -> loadView(SLASH . 'users' . SLASH . 'email_already_exists');
                    exit ;
                }
                $user -> setMember('email', $_POST['email']);
                $_SESSION[APP_SES . 'email'] = $_POST['email'];
            }
            $user -> setMember('fname', $_POST['fname']);
            $user -> setMember('lname', $_POST['lname']);
            $_SESSION[APP_SES . 'fname'] = $_POST['fname'];
            $_SESSION[APP_SES . 'lname'] = $_POST['lname'];
            $user -> save();
            setMessage('User profile has been updated.');
            gotoUrl('/?route=/users/users&m=pagelist');
        } else {
            $this -> setTitle('Update Profile');
            $this -> loadView(SLASH . 'users' . SLASH . 'change_details');
        }
    }

    public function changeprofile() {
        if (!isset($_SESSION[APP_SES . 'id']) || $_SESSION[APP_SES . 'id'] == 0) {
            gotoUrl('/?route=/users/users');
            exit ;
        }
        if (!isset($_GET['id']) || $_GET['id'] == 0) {
            $this -> loadView(SLASH . 'users' . SLASH . 'invalid_profile');
            exit ;
        }
        $this -> setTitle('Update Profile');
        $this -> loadModel(SLASH . 'users' . SLASH . 'user');
        $user = new User;
        $user -> load($_GET['id']);

        if (isset($_POST['changedetails'])) {
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                if ($user -> email_exists()) {
                    $this -> setTitle('Update Profile');
                    $this -> loadView(SLASH . 'users' . SLASH . 'email_already_exists');
                    exit ;
                }
                $user -> setMember('email', $_POST['email']);
            }
            if ($_SESSION[APP_SES . 'id'] != $profile['id'] && isset($_POST['user_type'])) {
                $user -> setMember('user_type', $_POST['user_type']);
            }
            $user -> setMember('fname', $_POST['fname']);
            $user -> setMember('lname', $_POST['lname']);
            $user -> save();
            setMessage('User profile has been updated.');
            gotoUrl('/?route=/users/users&m=pagelist');
            exit ;
        } else {
            $data['profile'] = $user -> getMembers();
            $this -> setTitle('Update Profile');
            $this -> loadView(SLASH . 'users' . SLASH . 'change_profile', TRUE, $data);
        }
    }

    public function listusers() {
        if (!isset($_SESSION[APP_SES . 'id']) || $_SESSION[APP_SES . 'id'] == 0) {
            gotoUrl('/?route=/users/users');
            exit ;
        }
        $this -> loadModel(SLASH . 'users' . SLASH . 'user');
        $user = new User;
        $data['list_of_users'] = $user -> get_users();
        $this -> setTitle('Users');
        $this -> loadView(SLASH . 'users' . SLASH . 'display_users', TRUE, $data);
    }

    public function pagelist() {
        // if (!isset($_SESSION[APP_SES . 'id']) || $_SESSION[APP_SES . 'id'] == 0) {
        // gotoUrl('/?route=/users/users');
        // exit ;
        // }
        $this -> setTitle("User Options");
        if ($_SESSION[APP_SES . 'user_type'] > self::power_user) {
            $this -> loadPartView(SLASH . 'users' . SLASH . 'admin_pages', TRUE);
            $this -> loadPartView(SLASH . 'users' . SLASH . 'user_pages', FALSE);
        } else {
            $this -> loadPartView(SLASH . 'users' . SLASH . 'user_pages', TRUE);
        }
        $this -> loadPartView(SLASH . 'users' . SLASH . 'index', FALSE);
        $this -> endView();
    }

}
?>