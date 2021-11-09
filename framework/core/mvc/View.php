<?php

namespace natework\core\mvc;

use natework\core\auth\Auth;
use natework\core\mvc\parser\Parser;

    class View {
        function __construct($viewname, $content = []) {
            $this->parser = new Parser($this);
            $this->parser->parse($this->getView($viewname));
        }
        private function getView($viewName) {
            $path = explode(".", $viewName);
            if (sizeof($path) > 1) {
                $dir = implode("/", array_slice($path, 0, sizeof($path) - 1, false));
                $file = $path[sizeof($path) - 1];
            } else {
                $dir = $this->currentDir;
                $view = $view[0];
            }
            return fopen("./../view/$dir/$file.view.php", "r");
        }

    }
?>
