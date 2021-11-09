<?php
    class Model {

        private static $stmt;

        public function __construct($data) {
            $this->fromAssoc($data);
            if (!$this->id) {
                $this->insert($this);
            }
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
                return Database::getInstance()->insert($modelName, $model);
            } else {
                echo "INVALID MODEL";
            }
        }
        function delete() {
            return Database::getInstance()->delete(get_called_class(), $this->id);
        }
        function fromAssoc($assoc) {
            if ($assoc) {
                foreach ($assoc as $key => $attribute) {
                    $this->{$key} = $attribute;
                }
            }
        }
        function getProperties($getId = true) {
            if ($getId) {
                return get_object_vars($this);
            } else {
                $vars = get_object_vars($this);
                return array_splice($vars, 1);
            }
        }
    }
?>
