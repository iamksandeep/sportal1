<?php

class AcknowledgeAllAction extends CAction {

    public function run($student_id) {
        $sql = <<<EOD
            UPDATE (notification
            LEFT JOIN activity ON notification.activity_id = activity.id)
            LEFT JOIN user ON activity.student_id = user.id

            SET notification.ack = 1

            WHERE notification.ack = 0
            AND activity.student_id = :studentId
            AND notification.target_id = :targetId
EOD;

        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindValue(':targetId', Yii::app()->user->id, PDO::PARAM_INT);
        $cmd->bindValue(':studentId', $student_id, PDO::PARAM_INT);
        $res = $cmd->execute();

        if($res > 0)
            Yii::app()->user->setFlash('warning', '<strong>'.$res.'</strong> notifications dismissed.');
        else
            Yii::app()->user->setFlash('warning', 'No notifications to dismiss.');

        $this->controller->redirect(array('notification/index'));
    }
}
