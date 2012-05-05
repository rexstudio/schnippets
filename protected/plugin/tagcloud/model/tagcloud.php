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

define('MAX_TAG_CLOUDS_RESULTS', '30');
//Total number of tag clouds to get

/**
 * Based on code by Steve Thomas
 * @link http://stevethomas.com.au/php/how-to-make-a-tag-cloud-in-php-mysql-and-css.html
 */

class TagCloud extends Model {
    protected $dbTable = 'search';
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
     * getTerm used to get current search term if it exists in database
     * @param $searchTerm search keyword to lookup
     * @return primaryKey
     */
    public function getTerm($searchTerm) {
        $sql = "SELECT {$this->primaryKey} FROM {$this->table} WHERE `term` = ? LIMIT 1";
        $query = $this -> db -> prepare($sql);
        $query -> execute(array($searchTerm));
        $result = $query -> fetch();
        return $result[$this -> primaryKey];
    }

    /**
     * startup used to render tagcloud
     * @return array maximum tag count, and terms contains search term and counter
     */
    public function startup() {
        $terms = array();
        // create empty array
        $maximum = 0;
        $sql = "SELECT term, counter FROM {$this->table} ORDER BY counter DESC, term ASC LIMIT " . MAX_TAG_CLOUDS_RESULTS;
        $query = $this -> db -> prepare($sql);
        $query -> execute();
        while ($row = $query -> fetch()) {
            $term = $row['term'];
            $counter = $row['counter'];
            if ($counter > $maximum)
                $maximum = $counter;
            $terms[] = array('term' => $term, 'counter' => $counter);
        }
        return array($maximum, $terms);
    }

}
?>