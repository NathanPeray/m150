<?php

namespace natework;

class Natework {

    public $conf;

    public static $dir;

    public function boot() {
        return $this;
    }

    private function init() {
        $this->modules = [];
        $this->conf = json_decode(file_get_contents('../conf.json'), true);
        $this->loadPackage('core');
        foreach($this->conf['packages'] as $package) {
            $this->loadPackage($package);
        }
        $this->loadModels();
    }
    private function loadPackage($package) {
        $conf = json_decode(file_get_contents(__DIR__."/$package/conf.json"), true);
        foreach($conf['modules'] as $module => $content) {
            $this->loadModule($package, $module, $content);
        }
    }
    private function loadModule($package, $module, $content) {
        $this->modules[$module] = [];
        foreach($content as $c) {
            array_push($this->modules[$module], "natework\\$package\\$module\\$c");
            require __DIR__."/$package/$module/$c.php";
        }
    }
    private function loadModels() {
        $models = static::getModels();
        foreach($models as $model) {
            require __DIR__."/../model/$model";
        }
    }
    public static function getModels() {
        return array_slice(scandir(__dir__."/../model"), 2);
    }
    /* Singleton */
    private static $inst = null;
    private function __construct() {
        $this->init();
    }
    public static function getInstance() {
        if (null === self::$inst) {
            self::$inst = new self;
        }
        return self::$inst;
    }
}

?>
