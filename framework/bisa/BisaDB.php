<?php

namespace natework\bisa;

use natework\Natework;
use natework\core\db\Db;
use natework\core\db\Builder;

class BisaDB {

    function __construct($args) {
        $this->options = $args;
    }
    function create() {
        new Builder();
    }
}
