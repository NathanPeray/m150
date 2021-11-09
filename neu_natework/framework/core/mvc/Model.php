<?php

namespace natework\model;

use natework\core\db\Db as Database;

class Model {

    private static $stmt;

    private function escapeHTML() {
        $vars = get_object_vars($this);
        foreach ($vars as $key => $var) {
            if (is_string($var)) {
                $this->{$key} = htmlspecialchars($var);
            }
        }
    }

    public function __construct($data) {

        if (!isset($data['id'])) {
            $this->fromAssoc($data, false);
            $this->insert($this);
        } else {
            $this->fromAssoc($data);
        }
        $this->escapeHTML();
    }
    function save() {
        return Database::getInstance()->update($this);
    }
    static function get($id = null) {
        return $id ? Database::getInstance()->select(get_called_class(), $id)[0] : Database::getInstance()->select(get_called_class(), $id);
    }
    static function getAll() {
        return Database::getInstance()->select(get_called_class());
    }
    static function getFromAuth($id = null) {
        return Database::getInstance()->selectProtected(get_called_class(), $id);
    }
    private function insert($model) {
        $modelName = get_called_class();
        if ($model instanceof $modelName) {
            return Db::getInstance()->insert($modelName, $model);
        } else {
            echo "INVALID MODEL";
        }
    }
    function delete() {
        return Database::getInstance()->delete(get_called_class(), $this->id);
    }
    function fromAssoc($assoc, $getForeign = true) {
        if ($assoc) {
            foreach ($assoc as $key => $attribute) {
                if (strpos($key, "_FK") && $getForeign) {
                    $model = ucfirst(explode("_", $key)[0]);
                    $tmp =  $model::get($attribute);
                    $this->{strtolower($model)} = $tmp;
                } else {
                    $this->{$key} = $attribute;
                }
            }
        }
    }
    function getProperties($getId = true) {
        $vars = get_object_vars($this);
        return $getId ? $vars : array_splice($vars, 1);
    }
    public static function getBlueprint() {
        $reflection = new \ReflectionClass(get_called_class());
        $props = $reflection->getProperties();
        $fields = [];
        foreach($props as $prop) {
            $declaration = $prop->__toString();
            $declaration = substr($declaration, strpos($declaration, "["));
            $regex = "/public|private|[\[\]]| |\\n/";
            $declaration = preg_replace($regex, "", $declaration);
            $splitted = explode("$", $declaration);
            $fields[$splitted[1]] = $splitted[0];
        }
        return $fields;
    }
}
?>
