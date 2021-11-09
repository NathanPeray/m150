<?php
    class WeddingController {

        function indexAction() {
            return new View("wedding.index", "Grimm - Hochzeitsfotograf", [
                "activePage" => "wedding"
            ]);
        }
    }
?>
