<?php
    class Task extends Model {

        public $id;
        public $user_fk;
        public $ident;
        public $description;

        public function __construct($data = null) {
            parent::__construct($data);
        }
    }
?>
