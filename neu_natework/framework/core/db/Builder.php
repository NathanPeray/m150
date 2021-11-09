<?php

namespace natework\core\db;

use natework\core\db\Db;
use natework\core\db\Table;
use natework\Natework;
use natework\model;

class Builder {

    public function __construct() {
        $this->db = Db::getInstance();
        $this->models = Natework::getModels();
        $this->tables = [];
        foreach($this->models as $model) {
            require __DIR__."/../../../model/" . ucfirst($model);
            $model = "natework\\model\\". explode(".", $model)[0];
            array_push($this->tables, new Table($model));
        }
        foreach($this->tables as $table) {
            $this->db->queryRaw($table->query);
        }
    }

}
?>
