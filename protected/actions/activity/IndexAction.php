<?php
class IndexAction extends CAction {
    public function run($student_id) {
        $student = $this->controller->loadUser($student_id);

        // access check
        if(!Yii::app()->user->checkAccess('viewActivity', array(
            'student' => $student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        // activity
        $activityData = new CActiveDataProvider('Activity', array(
          'criteria' => array(
            'with' => array('student', 'author', 'application', 'applicationTask'),
            'condition' => 't.student_id = :student_id',
            'params' => array(':student_id' => $student_id),
            'order' => 'time DESC',
          ),

          'pagination' => array(
                'pageSize' => 20,
            ),
        ));

        $this->controller->render('index', array(
            'activityData' => $activityData,
            'student' => $student,
        ));
    }
}
