<?php

class IndexAction extends CAction {
    /**
     * Lists applications for a student
     * @param  int $student_id Primary Key of student user
     */
    public function run($student_id) {
        $student = $this->controller->loadUser($student_id);

        // access check
        if(!Yii::app()->user->checkAccess('viewApplications', array(
            'student' => $student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        // get applications
        $appData = array();

        foreach(Application::getStates() as $stateId => $stateName) {
            $condition = 't.student_id = :student_id
                            AND t.state = :state';

            $params = array(
                ':student_id' => $student_id,
                ':state' => $stateId,
            );

            $applications = new CActiveDataProvider('Application', array(
                'criteria' => array(
                    'with' => array('applicationTasks', 'documents'),
                    'condition' => $condition,
                    'params' => $params,
                    'order' => '
                                CASE WHEN t.deadline IS NULL THEN 1 ELSE 0 END, t.deadline,
                                t.university, t.course',
                ),
                'pagination' => array('pageSize' => 20),
            ));

            $appData[$stateName] = $applications;
        }

        $this->controller->render('index', array(
            'student' => $student,
            'appData' => $appData,
            //'s' => $s,
        ));
    }
}
