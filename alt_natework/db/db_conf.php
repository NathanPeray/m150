<?php
    $mysqli = new mysqli("localhost", "root", "", "timez");
    // $mysqli = new mysqli("localhost", "u91977db3", "7m#co7ijtv;l'6>0", "u91977db3");
    if ($mysqli -> connect_error) {
        respond(array(false, 501));
    }
    if (!$mysqli -> set_charset("utf8")) {
        respond (array(false, 509));
    }
?>
