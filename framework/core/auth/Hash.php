<?php

namespace natework\core\auth;

use natework\core\db\Type;

class Hash extends Type {
    private static $db = "CHAR(128)";

    public static function db() {
        return self::$db;
    }
}

?>
