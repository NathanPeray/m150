<?php
    class PortraitController {

        function indexAction() {
            return new View("portrait.index", "Grimm - Portrait", [
                "activePage" => "portrait"
            ]);
        }
    }
?>
