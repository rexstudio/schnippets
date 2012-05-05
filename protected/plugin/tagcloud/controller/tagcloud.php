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

class tagcloudtagcloud extends Application {

    public function index() {
        if ($this -> live()) {
            $this -> loadModel('tagcloud', 'tagcloud');
            $tagcloud = new TagCloud;
            $data['tags'] = $tagcloud -> startup();
            $this -> setTitle('Popular Searches');
            $this -> loadPlugInView('popular_searchs', 'tagcloud', TRUE, $data);
        }
    }

    public function save() {
        $title = (isset($_POST['title'])) ? $_POST['title'] : '';
        if ($this -> live() && !empty($title)) {
            $this -> loadModel('tagcloud', 'tagcloud');
            $tagcloud = new TagCloud;
            $term_id = $tagcloud -> getTerm($title);
            if (empty($term_id)) {
                $tagcloud -> setMembers(array('term' => $title, 'counter' => '1', 'last_search' => date('U')));
                $tagcloud -> save();
            } else {
                $tagcloud -> load($term_id);
                $count = $tagcloud -> getMember('counter') + 1;
                $tagcloud -> setMember('counter', $count);
                $tagcloud -> setMember('last_search', date('U'));
                $tagcloud -> save();
            }
        }
    }

    private function live() {
        if ($this -> is_plugin_enabled('tagcloud')) {
            return true;
        } else {
            $this -> loadPlugInView('disabled', 'tagcloud', TRUE);
            return false;
        }
    }

}
?>