<?php

class IndexAction extends CAction {

    private function getReceivedTodo($state) {
        return new CActiveDataProvider('Todo', array(
          'criteria' => array(
            'with' => array('assignee', 'assigner', 'student'),
            'condition' => 'assignee_id = :assignee_id
                            AND state = :state
                            AND approved = 1',
            'params' => array(
                            ':assignee_id' => Yii::app()->user->id,
                            ':state' => Todo::getStateId($state),
                        ),
            'order' => '
                        seen_by_assignee,
                        CASE WHEN last_activity_time IS NULL THEN 0 ELSE 1 END DESC, last_activity_time DESC,
                        CASE WHEN complete_time IS NULL THEN 0 ELSE 1 END DESC, complete_time DESC,
                        CASE WHEN deadline IS NULL THEN 1 ELSE 0 END, deadline,
                        initiate_time',
            //'order' => 'deadline ASC, initiate_time ASC',
          ),
        ));
    }

    private function getSentTodo($state) {
        return new CActiveDataProvider('Todo', array(
          'criteria' => array(
            'with' => array('assignee', 'assigner', 'student'),
            'condition' => 'assigner_id = :assigner_id
                            AND state = :state',
            'params' => array(
                            ':assigner_id' => Yii::app()->user->id,
                            ':state' => Todo::getStateId($state),
                        ),
            'order' => '
                        CASE WHEN last_activity_time IS NULL THEN 0 ELSE 1 END DESC, last_activity_time DESC,
                        CASE WHEN complete_time IS NULL THEN 0 ELSE 1 END DESC, complete_time DESC,
                        CASE WHEN deadline IS NULL THEN 1 ELSE 0 END, deadline,
                        initiate_time',
          ),
        ));
    }

    public function run() {
        $recvd = array();
        $sent = array();
        $states = array('not-started', 'in-progress', 'complete');

        // todo
        foreach($states as $state)
            $recvd[$state] = $this->getReceivedTodo($state);
        foreach($states as $state)
            $sent[$state] = $this->getSentTodo($state);

        $this->controller->layout = '//layouts/column1';
        $this->controller->render('index', array(
            'recvd' => $recvd,
            'sent' => $sent,
            'states' => $state,
        ));
    }
}
