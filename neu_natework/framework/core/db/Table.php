<?php

namespace natework\core\db;

use natework\core\db\Attribute;
use natework\core\db\Type;

class Table {

    public $query;

    public function __construct($model) {
        $this->attributes = [];
        $tmp = explode("\\", strtolower($model));
        $this->tableName = $tmp[sizeof($tmp) - 1];
        $fields = $model::getBluePrint();
        foreach ($fields as $key => $field) {
            $this->addAttribute($key, $field);
        }
        $this->query = $this->buildQuery();
    }
    private function addAttribute($name, $datatype) {
        $this->attributes[$name] = new Attribute($name, $datatype);
    }
    private function buildQuery() {
        $query = "CREATE TABLE " . $this->tableName . " ({fields})";
        $queryFields = [];
        foreach ($this->attributes as $attribute) {
            array_push($queryFields, $this->buildField($attribute));
        }
        $query = str_replace("{fields}", implode(", ", $queryFields), $query);
        return $query;
    }
    private function buildField($attribute) {
        $name = $attribute->getName();
        $type = $attribute->getType();
        $fieldString = $name;
        $fieldString .= $this->mapType($type);
        return $fieldString;
    }
    private function mapType($type) {
        switch ($type) {
            case 'string'   : return " VARCHAR(255)";
            case 'int'      : return " INT";
            case 'float'    : return " DECIMAL";
            case 'bool'     : return " BOOLEAN";
            default         : return $this->mapObject($type);
        }
    }
    private function mapObject($type) {
        return " " . $type::db();
    }

}

?>
