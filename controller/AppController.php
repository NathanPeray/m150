<?php
    class AppController {

        function indexAction() {
            return new View("home.index", "Grimm Photography");
        }
        function notFoundAction() {

        }
    }
?>
