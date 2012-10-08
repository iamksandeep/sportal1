<?php

class IndexAction extends CAction {

    public function run() {
        // first get all student ids
        $studentIds = Yii::app()->db->createCommand()
                      ->select('activity.student_id')
                      ->from('notification')
                      ->leftJoin('activity', 'notification.activity_id = activity.id')
                      ->leftJoin('user', 'activity.student_id = user.id')
                      ->where('notification.target_id = :userId', array(
                            ':userId' => Yii::app()->user->id,
                        ))
                      ->group('activity.student_id')
                      ->order('user.name_first, user.name_last')
                      ->queryAll();

        // build dataprovider array
        $notifications = array();
        foreach($studentIds as $s) {
            $sId = $s['student_id'];

            $notifications[$sId] = new CActiveDataProvider('Notification', array(
              'criteria' => array(
                'with' => array(
                    'target',
                    'activity',
                    'activity.student',
                    'activity.application',
                    'activity.applicationTask',
                ),
                'condition' => 't.ack = 0
                                AND t.target_id = :targetId
                                AND activity.student_id = :studentId',
                'params' => array(
                                ':targetId' => Yii::app()->user->id,
                                ':studentId' => $sId,
                            ),
                'order' => 'activity.time DESC',
              ),

              'pagination' => array(
                    'pageSize' => 5,
                ),
            ));
        }

        // render page
        $this->controller->render('index', array(
            'notifications' => $notifications,
        ));
    }
}
