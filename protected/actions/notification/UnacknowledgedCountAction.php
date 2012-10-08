<?php

class UnacknowledgedCountAction extends CAction {

    public function run() {
        echo Notification::model()->count('target_id = :targetId AND ack = 0', array(
            ':targetId' => Yii::app()->user->id,
        ));
    }
}
