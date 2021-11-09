<?php
    class Timestamp extends Model {

        public $id;
        public $user_fk;
        public $task_fk;
        public $day;
        public $stampin;
        public $stampout;

        public function __construct($data = null) {
            parent::__construct($data);
        }
        public function hasActive() {
            $userid = Auth::getInstance()->getUser()->id;
            $query = "SELECT * FROM timestamps WHERE day = CURRENT_DATE() AND stampout IS NULL AND user_fk = $userid ";
            $stamp = Database::getInstance()->query($query, get_called_class());
            if (sizeof($stamp) > 0) {
                return $stamp[0];
            } else {
                return false;
            }
        }
        public function getTask() {
            if ($this->task_fk) {
                return Task::get($this->task_fk);
            } else {
                return false;
            }
        }
    }
?>
