<?php
    require "framework/Natework.php";
    $namespace  = $argv[1];
    $options    = array_splice($argv, 2);

    $task = explode(":", $argv[1]);

    $core = framework\Natework::getInstance();
    switch($task[0]) {
        case "db" :
            require __DIR__ . '/framework/bisa/bisaDB.php';
            $scope = new natework\bisa\BisaDB($options);
            $scope->{$task[1]}();
        break;
    }
