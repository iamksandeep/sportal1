<?php

class ActivityLogger {

    static public function log($msg, $studentId, $applicationId = null, $applicationTaskId = null) {
        $activity = new Activity();

        $activity->comment = $msg;
        $activity->log = true;
        $activity->student_id = $studentId;
        $activity->application_id = $applicationId;
        $activity->application_task_id = $applicationTaskId;
        $activity->author_id = Yii::app()->user->id;

        return $activity->save() ? $activity : null;
    }

    static public function todoLog($msg, $todoId) {
        $tdActivity = new TDActivity();

        $tdActivity->comment = $msg;
        $tdActivity->log = true;
        $tdActivity->todo_id = $todoId;
        $tdActivity->author_id = Yii::app()->user->id;

        return $tdActivity->save();
    }
}
