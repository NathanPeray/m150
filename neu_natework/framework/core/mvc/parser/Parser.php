<?php

namespace natework\core\mvc\parser;

class Parser extends Viewlang {

    protected $layout = "";

    public function __construct($view) {
        $this->conf = json_decode(file_get_contents(__DIR__."/parser.json"), true);
        $this->view = $view;
        $this->matches = [];
    }

    public function parse($file) {
        $actions = [];
        $lineNR = 1;
        $indent = 1;
        while ($line = fgets($file)) {
            foreach($this->conf as $key => $syntax) {
                if (boolval($syntax[1])) {
                    if (!isset($actions[$indent])) {
                        $actions[$indent] = [];
                    }
                    array_push()
                } else if (str_replace("end", "", $key) == $actions[$indent][sizeof($actions[$indent]) - 1]) {
                    echo
                }
                if(!isset($actions[$key])) {
                    $actions[$key] = [];
                }
                preg_match_all($regex, $line, $matches, PREG_OFFSET_CAPTURE);
                foreach($matches[0] as $match) {
                    array_push($actions[$key], [$lineNR, $match[1], $match[0]]);
                }
            }
            $lineNR++;
        }
        foreach($actions as $key => $actions) {
            echo json_encode($actions) . " <br>";
        }
    }

}

?>
