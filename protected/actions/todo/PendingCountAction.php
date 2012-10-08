<?php

class PendingCountAction extends CAction {

    public function run() {
        echo Todo::model()->count('assignee_id = :assigneeId AND (state = :s1 OR state = :s2) AND approved = 1', array(
            ':assigneeId' => Yii::app()->user->id,
            ':s1' => Todo::getStateId('not-started'),
            ':s2' => Todo::getStateId('in-progress'),
        ));
    }
}
