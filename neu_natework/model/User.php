<?php
namespace natework\model;

use natework\model\Model;
use natework\core\auth\Hash;
use natework\core\db\M2M;

class User extends Model {

    public int $id;
    public string $email;
    public string $prename;
    public string $lastname;
    public Hash $hash;
    public Hash $salt;

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public static function up() {

    }
}
?>
