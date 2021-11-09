<?php
    session_start();
    require '../framework/Natework.php';

    use natework\Natework;
    use natework\core\mvc\Router;
    $dir = explode("\\", __DIR__);
    array_pop($dir);
    Natework::$dir = implode("\\", $dir);
    $core = Natework::getInstance()->boot();

    Router::getInstance()->route($core->conf['base_url']);
?>
