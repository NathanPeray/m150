<?php

namespace natework\core\db;


class Attribute {

    private $name;
    private $type;

    public function __construct($name, $datatype) {
        $this->name = $name;
        $this->type = $datatype;
    }
    public function getName() {
        return $this->name;
    }
    public function getType() {
        return $this->type;
    }
}
?>
