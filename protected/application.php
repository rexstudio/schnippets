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
 * Application Class
 */
class Application {
    /**
     * @var $file controller file to load
     * @var $class controller class to load
     * @var $method controller method to load
     * @var $var controller variable to load
     * @var $output to render view
     * @var $styles to create CSS for Plug-ins
     * @var $scripts to create JavaScript for Plug-ins
     */
    private $file;
    private $class;
    private $method;
    private $var;
    private $title;
    private $output;
    private $styles;
    private $scripts;
    private $menu;
    /**
     * Get controller name from route get variable
     * Also, find method name from m get variable
     * And find variables from v get variable
     * @method __construct
     * @return void
     */
    function __construct() {
        if (isset($_GET['route']))
            $uri = $_GET['route'];
        else
            $uri = "/application/schnippets";

        $this -> loadAssets();
        $uri = $this -> filterURI($uri);
        $parts = explode('/', $uri);

        //check for default site controller first
        if (is_dir('protected' . SLASH . 'controller' . SLASH . $parts[1])) {
            if (is_file('protected' . SLASH . 'controller' . SLASH . $parts[1] . SLASH . $parts[2] . '.php')) {
                $this -> file = 'protected' . SLASH . 'controller' . SLASH . $parts[1] . SLASH . $parts[2] . '.php';
                $this -> class = $this -> filterClass($parts[1] . $parts[2]);
            }
        } else {
            //check for plugin site controller next
            if (is_dir('protected' . SLASH . 'plugin' . SLASH . $parts[1])) {
                if (is_file('protected' . SLASH . 'plugin' . SLASH . $parts[1] . SLASH . 'controller' . SLASH . $parts[2] . '.php')) {
                    $this -> file = 'protected' . SLASH . 'plugin' . SLASH . $parts[1] . SLASH . 'controller' . SLASH . $parts[2] . '.php';
                    $this -> class = $this -> filterClass($parts[1] . $parts[2]);
                }
            }
        }

        if (isset($_GET['m']))
            $this -> method = $_GET['m'];
        else
            $this -> method = "";
        if (isset($_GET['v']))
            $this -> var = $_GET['v'];
    }

    /**
     * These are security feature for this class
     * @method filterURI
     * @param uri of route
     * @return path without .. in it
     */
    private function filterURI($uri) {
        return str_replace('..', '', $uri);
    }

    /**
     * @method filterClass
     * @param type $class
     * @return type string of safe class name
     */
    private function filterClass($class) {
        return preg_replace('/[^a-zA-Z0-9]/', '', $class);
    }

    /**
     * This is used by the constructor to route to the correct method in the controller script
     * @return void
     */
    public function loadController() {
        if (!file_exists($this -> file)) {
            $this -> loadView(SLASH . 'application' . SLASH . '404', true);
            //404 page not found error
            exit ;
        }

        require_once ($this -> file);

        $controller = new $this->class();

        if (!empty($this -> method) && method_exists($controller, $this -> method)) {
            $controller -> {$this->method}($this -> var);
        } else {
            $controller -> index();
        }
    }

    /**
     * @method loadView
     * outputs full page
     * @param view web page to view
     * @param renderPage, if true will use the standard template for site, if false will output your view only
     * @param vars, the data array that is extracted into the view page for rendering
     * @return void
     */
    public function loadView($view, $renderPage = TRUE, $vars = "") {
        if (is_array($vars) && count($vars) > 0)
            /* For extract example see: http://php.net/manual/en/function.extract.php
             * For wddx info see: http://php.net/manual/en/function.wddx-deserialize.php
             */
            extract($vars, EXTR_PREFIX_SAME, "wddx");

        ob_start();
        require_once ('view' . SLASH . $view . '.php');
        $this -> output = ob_get_clean();

        if ($renderPage) {
            require_once ('template' . SLASH . 'page.tpl.php');
            // standard template for site
        } else {
            print $this -> output;
        }
    }

    /**
     * loads half page, require EndView to output
     * @param type $view file to render
     * @param type $start is first file
     * @param type $vars optionally pass variables
     */
    public function loadPartView($view, $start = TRUE, $vars = '') {
        if (is_array($vars) && count($vars) > 0)
            /* For extract example see: http://php.net/manual/en/function.extract.php
             * For wddx info see: http://php.net/manual/en/function.wddx-deserialize.php
             */
            extract($vars, EXTR_PREFIX_SAME, "wddx");

        if ($start)
            ob_start();
        require_once ('view' . SLASH . $view . '.php');
    }

    /**
     * outputs pages loaded with loadPartView
     * @param type $renderPage use template
     */
    public function endView($renderPage = TRUE) {
        $this -> output = ob_get_clean();
        if ($renderPage) {
            require_once ('template' . SLASH . 'page.tpl.php');
            // standard template for site
        } else {
            print $this -> output;
        }
    }

    /**
     * @method loadPartPluginView
     * render plugin view requires EndView
     * @param view web page to view
     * @param start is first file
     * @param type $vars optionally pass variables
     * @return type void
     */
    public function loadPartPluginView($view, $start = TRUE, $vars = '') {
        if (is_array($vars) && count($vars) > 0)
            extract($vars, EXTR_PREFIX_SAME, "wddx");

        if ($start)
            ob_start();
        require_once ('plugin' . SLASH . $plugin_path . SLASH . 'view' . SLASH . $view . '.php');

    }

    /**
     * @method loadPluginView
     * render full plugin view requires EndView
     * @param view web page to view
     * @param start is first file
     * @param type $vars optionally pass variables
     * @return type void
     */
    public function loadPluginView($view, $plugin_path, $renderPage = TRUE, $vars = "") {
        if (is_array($vars) && count($vars) > 0)
            /* For extract example see: http://php.net/manual/en/function.extract.php
             * For wddx info see: http://php.net/manual/en/function.wddx-deserialize.php
             */
            extract($vars, EXTR_PREFIX_SAME, "wddx");

        ob_start();
        require_once ('plugin' . SLASH . $plugin_path . SLASH . 'view' . SLASH . $view . '.php');
        $this -> output = ob_get_clean();
        if ($renderPage) {
            require_once ('template' . SLASH . 'page.tpl.php');
            // standard template for site
        } else {
            print $this -> output;
        }
    }

    /**
     * @method loadModel
     * @param type $model, the data model to use for your view
     * @param optionaly takes type $plugin_path the path to a plug in to use instead of the standard model
     */
    public function loadModel($model, $plugin_path = '') {
        require_once ('model' . SLASH . 'model.php');
        // load base model class for other models
        if (!empty($plugin_path)) {
            require_once ('plugin' . SLASH . $plugin_path . SLASH . 'model' . SLASH . $model . '.php');
        } else {
            require_once ('model' . SLASH . $model . '.php');
        }
    }

    /**
     * @method loadPlugIn
     * @param type $plugin the name of the script to use
     * @param type $plugin_path the folder the script is in
     */
    public function loadPlugIn($plugin, $plugin_path) {
        if ($this -> is_plugin_enabled($plugin)) {
            require_once ('model' . SLASH . 'model.php');
            // load base model class for plugins
            require_once ('plugin' . SLASH . $plugin_path . SLASH . $plugin . '.php');
        }
    }

    /**
     * @method is_plugin_enabled
     * @global type $enabled_plugins
     * @param current_plugin the plugin name to check against to see if its enabled in the config file
     * @return true if enabled
     */
    public function is_plugin_enabled($current_plugin) {
        global $enabled_plugins;
        foreach ($enabled_plugins as $plugin => $junk) {
            if (strtolower($current_plugin) == strtolower($plugin)) {
                return true;
            }
        }
        return false;
        //            $plugin_name = 'PLUGIN_'.strtoupper($plugin);
        //            if (defined($plugin_name) && constant($plugin_name) == TRUE) return true; else return false;
    }

    /**
     * @method loadAssets
     * Will load the plugins javascript and css on app load
     * @global type $enabled_plugins
     * @return type void
     */
    private function loadAssets() {
        global $enabled_plugins;
        foreach ($enabled_plugins as $plugin => $assets) {
            foreach ($assets as $type => $value) {
                if ($type == 'css') {
                    $this -> styles .= wrapCSS(SLASH . 'protected' . SLASH . 'plugin' . SLASH . $plugin . SLASH . 'css' . SLASH . $value);
                } else if ($type == 'js') {
                    $this -> scripts .= wrapJS(SLASH . 'protected' . SLASH . 'plugin' . SLASH . $plugin . SLASH . 'js' . SLASH . $value);
                } else if ($type == 'menu') {
                    $this -> menu .= wrapMenu($plugin, $value);
                }
            }
        }
    }

    protected function setTitle($title) {
        $this -> title = $title;
    }

    /**
     * @method addCSS
     * @param file path to the css file being added
     */
    protected function addCSS($file) {
        $this -> styles .= wrapCSS($file);
    }

    /**
     * @method addJS
     * @param file path to the JS file being added
     */
    protected function addJS($file) {
        $this -> scripts .= wrapJS($file);
    }

}
?>