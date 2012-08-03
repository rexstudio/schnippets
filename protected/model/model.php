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
 * Model Class
 */
class Model extends Application {

    /**
     * Model members
     *
     * @var PDO Object $db
     * @var string $table
     * @var array $members
     * @var string $primaryKey
     */
    protected $db;
    protected $table;
    protected $members;
    protected $primaryKey;

    /**
     * Model constructor
     *
     * Must pass table name and primary key from child class
     * @method __construct
     * @param $table of database, $primaryKey name of id
     * @return void
     */
    function __construct($table, $primaryKey) {
        $this -> connectDatabase();
        $this -> table = $table;
        $this -> primaryKey = $primaryKey;
        $this -> generateMembers();
    }

    /**
     * Connect to Database
     * @method connnectDatabase
     * @return void
     */
    protected function connectDatabase() {
        try {
            $this -> db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            print $e -> getMessage();
            die();
        }
    }

    /**
     * Disconnect from Database
     * @method disconnectDatabase
     * @return void
     */
    protected function disconnectDatabase() {
        $this -> db = null;
    }

    /**
     * Read database table and set members for class
     * @method generateMembers
     * @return void
     */
    protected function generateMembers() {
        $query = $this -> db -> prepare("DESCRIBE {$this->table}");
        $query -> execute();
        $fields = $query -> fetchAll(PDO::FETCH_COLUMN);
        foreach ($fields as $key => $value) {
            $this -> members[$value] = NULL;
        }
    }

    /**
     * Setter for class members
     *
     * @return void
     */
    public function setMember($name, $value) { 
        if (is_array($this->members) && !array_key_exists($name, $this->members) && $name <> $this->primaryKey) {
            return;
        }
        if (is_array($value)) {
            $this->members[$name] = serialize($value);
        } else {
            $this->members[$name] = $value;    
        }
    }
    /**
     * Array Setter for class members
     *
     * @return void
     */
    public function setMembers($namesValues) {
        foreach ($namesValues as $name => $value) {
            $this -> setMember($name, $value);
        }
    }

    /**
     * Getter for class members
     *
     * @return void
     */
    public function getMember($name) {
        if (!array_key_exists($name, $this -> members)) {
            return;
        }
        return $this -> members[$name];
    }

    /**
     * Array Getter for class members
     *
     * @return void
     */
    public function getMembers() {
        return $this -> members;
    }

    /**
     *  return value of current object's primary key
     *
     * @return int
     */
    public function getPrimaryKey() {
        return $this -> members[$this -> primaryKey];
    }

    /**
     * Validate current class members
     * @TODO write this code!
     * @method valudate
     * @return bool
     */
    public function validate() {
        return TRUE;
    }

    /**
     * @author Andy Lawrence
     * @method load
     * @param $id - primary key
     */
    public function load($id) {

        if (method_exists($this, 'preLoad')) {
            $this -> preLoad();
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = {$id}";
        $query = $this -> db -> prepare($sql);
        $query -> execute();
        $this -> members = array_merge($this -> members, $query -> fetch(PDO::FETCH_ASSOC));

        if (method_exists($this, 'postLoad')) {
            $this -> postLoad();
        }
    }

    /**
     * Save current object to database
     *
     * Insert if primary key not set
     * Update if primary key set
     * @author Andy Lawrence
     * @method save
     * @return void
     */
    public function save() {

        if (method_exists($this, 'preSave')) {
            $this -> preSave();
        }

        if (!$this -> validate()) {
            return;
        }

        $fields = '';
        $values = '';
        $placeholders = '';
        $fieldsPlaceholders = '';

        if (empty($this -> members[$this -> primaryKey])) {
            foreach ($this->members as $key => $value) {
                if ($key == $this -> primaryKey) {
                    continue;
                }
                $fields .= $key . ',';
                $placeholders .= '?,';
                $values[] = $value;
            }
            $fields = rtrim($fields, ',');
            $placeholders = rtrim($placeholders, ',');
            $sql = "
                INSERT into {$this->table}
                ({$fields})
                VALUES ({$placeholders})
            ";
            $query = $this -> db -> prepare($sql);
            $success = $query -> execute($values);
            $this -> members[$this -> primaryKey] = $this -> db -> lastInsertId();

        } else {
            foreach ($this->members as $key => $value) {
                if ($key == $this -> primaryKey) {
                    continue;
                }
                $fieldsPlaceholders .= $key . '=?,';
                $values[] = $value;
            }
            $fieldsPlaceholders = rtrim($fieldsPlaceholders, ',');
            $sql = "
                UPDATE {$this->table}
                SET {$fieldsPlaceholders} 
                WHERE {$this->primaryKey}={$this->members[$this->primaryKey]}
            ";
            $query = $this -> db -> prepare($sql);
            $success = $query -> execute($values);
        }

        if (method_exists($this, 'postSave')) {
            $this -> postSave();
        }
        return $success;

    }

    /**
     * Debugging method to print out current object
     * @method printObject
     * @return void
     */
    public function printObject() {
        echo '<pre>';
        print_r($this);
        echo '</pre>';
    }

}
?>