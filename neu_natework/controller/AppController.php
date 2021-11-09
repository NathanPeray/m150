<?php

use natework\core\mvc\View;
use natework\core\db\Builder;
use natework\model\User;

class AppController {

    function indexAction() {
        new View('home.index');
    }
}
?>
