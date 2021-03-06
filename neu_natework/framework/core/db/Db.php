<?php

namespace natework\core\db;

use  natework\core\auth\Auth;
class Db {

    protected $mysqli;

    public function init($data) {

        $this->mysqli = new mysqli($data['host'], $data['user'], $data['pw'], $data['db']);
        if ($this->mysqli -> connect_error) {
            // TODO: PROPPER ERROR
        }
        if (!$this->mysqli -> set_charset("utf8")) {
            // TODO: PROPPER ERROR
        }
    }
    public function select($modelName, $id = null) {
        $models = [];
        $query = "SELECT * FROM " . strtolower($modelName) . "s";
        $query .= $id ? " WHERE id = ?" : "";
        $stmt = $this->mysqli->prepare($query);
        if ($id) {
            $stmt->bind_param('i', $id);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $model = new $modelName($row);
            array_push($models, $model);
        }
        $stmt->close();
        return $models;
    }
    public function selectProtected($modelName, $id = null) {
        $models = [];
        $authID = Auth::getInstance()->getUser()->id;
        $query = "SELECT * FROM " . strtolower($modelName) . "s";
        if ($id) {
            $query .= " WHERE id = ? AND user_fk = ? ";
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('ii', $id, $authID);
        } else {
            $query .= " WHERE user_fk = ? ";
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $authID);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $model = new $modelName;
            $model->fromAssoc($row);
            array_push($models, $model);
        }
        $stmt->close();
        return $models;
    }
    public function insert($modelName, $model) {
        $keys = array_keys(get_class_vars($modelName));
        $fields= array_splice($keys, 1);
        $ph = implode(", ", $fields);
        $valType = "";
        foreach ($fields as $field) {
            $ph = str_replace($field, "?", $ph);
            $valType .= "s";
        }
        $query = "INSERT INTO " . strtolower($modelName) . "s (" . implode(", ", $fields) . ") VALUES ($ph)";
        $stmt = $this->mysqli->prepare($query);
        $values = array_values($model->getProperties(false));
        $stmt->bind_param($valType, ...$values);
        $stmt->execute();
        $stmt->close();
    }
    public function update($model) {
        $table = strtolower(get_class($model)) . "s";
        $query = "UPDATE $table SET ";
        $props = $model->getProperties(false);
        $attributes = [];
        $types = "";
        foreach ($props as $prop => $val) {
            array_push($attributes, "$prop = ?");
            $types .= is_int($val) ? 'i' : 's';
        }
        $query .= implode(", ", $attributes);
        $query .= " WHERE user_fk = " . Auth::getInstance()->getUser()->id;
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param($types, ...array_values($props));
        $stmt->execute();
        $stmt->close();
    }
    public function delete($modelName, $id) {
        $query = "DELETE FROM " .  strtolower($modelName) . "s WHERE id = " . $id;
    }
    public function getAuthString($userid) {
        global $confArray;
        $query = "SELECT hash, salt FROM users WHERE id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();
        $stmt->bind_result($hash, $salt);
        $stmt->close();
        return hash('sha512', $confArray['pepper'] . $hash . $salt . $_SERVER['HTTP_USER_AGENT']);
    }
    public function verifyUser($email, $hash) {
        global $confArray;
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user;
        if($row = $result->fetch_assoc()) {
            $user = new User($row);
        } else {
            $stmt->close();
            return false;
        }
        $dbHash = User::hashPW($hash , $user->salt);
        if ($dbHash == $user->hash) {
            return $user;
            $stmt->close();
        }
        return false;
    }

    public function query($query, $modelName) {
        $models = [];
        $stmt = $this->mysqli->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $model = new $modelName;
            $model->fromAssoc($row);
            array_push($models, $model);
        }
        $stmt->close();
        return $models;
    }
    public function queryRaw($query) {
        $stmt->prepare($query);
        $stmt->execute();
    }
    public function getConnection() {
        return $mysql;
    }
    /* Singleton */
    private static $inst = null;
    private function __construct() {}
    public static function getInstance() {
        if (null === self::$inst) {
            self::$inst = new self;
        }
        return self::$inst;
    }
}
?>
