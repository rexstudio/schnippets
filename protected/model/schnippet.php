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
 * Schnippet Class extends Model
 */
class Schnippet extends Model {

    /**
     * Schnippet members
     *
     * @var string $dbTable
     * @var string $dbPrimaryKey
     */
    protected $dbTable = 'schnippets';
    // set table name to connect to for this model
    protected $dbPrimaryKey = 'id';

    /**
     * Schnippet constructor
     *
     * Must pass table name and primary key to Model class
     *
     * @return void
     */
    function __construct() {
        parent::__construct($this -> dbTable, $this -> dbPrimaryKey);
    }

    /**
     * Implementation of hook preSave()
     */
    protected function preSave() {
        if (!isset($_SESSION[APP_SES . 'id']) || $_SESSION[APP_SES . 'id'] == 0) {
            $this -> setMember('user', 'anon');
        } else {
            //$this->setMember('user', $_SERVER[PHP_AUTH_USER]);
            $this -> setMember('user', $_SESSION[APP_SES . 'id']);
        }
        $this -> setMember('protected', (isset($_POST['protected']) ? 'on' : 'off'));
        $this -> setMember('time', date('U'));
    }

    /**
     * Search functionality
     *
     * takes an object with optional members set and returns an array of matching objects
     *
     * @var stdClass $searchObject
     * @var string $order
     * @var string
     *
     * @return array
     */
    public function search($searchObject, $order = "{Schnippet::dbPrimaryKey} ASC", $limit = "0, 18446744073709551615") {

        $where = '1 = 1';
        $prepArray = array();

        if (isset($searchObject -> user) && !empty($searchObject -> user) && $searchObject -> user != 'all') {
            $where .= " AND user = ?";
            $prepArray[] = $searchObject -> user;
        }

        if (isset($searchObject -> lang) && !empty($searchObject -> lang) && $searchObject -> lang != 'all') {
            $where .= " AND lang = ?";
            $prepArray[] = $searchObject -> lang;
        }

        if (isset($searchObject -> title) && !empty($searchObject -> title)) {
            $where .= " AND title like ?";
            $prepArray[] = "%{$searchObject->title}%";
        }

        if (isset($searchObject -> code) && !empty($searchObject -> code)) {
            $where .= " AND MATCH(code) AGAINST(?)";
            $prepArray[] = $searchObject -> code;
        }

        if (isset($searchObject -> start_date) && isset($searchObject -> end_date) && !empty($searchObject -> start_date) && !empty($searchObject -> end_date)) {
            $where .= " AND `time` BETWEEN ? AND ?";
            $prepArray[] = strtotime($searchObject -> start_date);
            $prepArray[] = strtotime($searchObject -> end_date);
        }

        if (!isset($_SESSION[APP_SES . 'id']) || $_SESSION[APP_SES . 'id'] == 0) {
            $where .= " AND `protected` = 'off'";
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$order} LIMIT {$limit}";
        $query = $this -> db -> prepare($sql);
        $query -> execute($prepArray);

        $result = array();
        while ($row = $query -> fetch()) {
            $schnippet = new Schnippet;
            $schnippet -> load($row['id']);
            $result[] = $schnippet;
            unset($schnippet);
        }
        return $result;
    }

}
?>