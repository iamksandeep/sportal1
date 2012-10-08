<?php

class AnyNewTasksAction extends CAction {

    public function run() {
        echo Todo::model()->count('assignee_id = :assigneeId AND seen_by_assignee = 0 AND approved = 1', array(
            ':assigneeId' => Yii::app()->user->id,
        ));
    }
}
