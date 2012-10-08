<?php
class ListAllAction extends CAction {
    public function run() {
        // access check
        if(!Yii::app()->user->checkAccess('viewAllApplications', array(
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        $this->controller->layout = '//layouts/column1';

        // time config
        $time_start = FriendlyTime::getMysqlFormat('today');
        if(isset($_POST['time_start']))
            $time_start = FriendlyTime::getMysqlFormat($_POST['time_start']);
        $time_end = FriendlyTime::getMysqlFormat('+1 month');
        if(isset($_POST['time_end']))
            $time_end = FriendlyTime::getMysqlFormat($_POST['time_end']);

        // condition
        $condition = '';
        $condition .= ' deadline >= :time_start AND deadline <= :time_end';
        $condition .= ' AND state = :state';

        // get applications
        $appData = array();

        foreach(Application::getStates() as $stateId => $stateName) {
            $applications = new CActiveDataProvider('Application', array(
                'criteria' => array(
                    'with' => array('student'),
                    'condition' => $condition,
                    'params' => array(
                        ':time_start' => $time_start,
                        ':time_end' => $time_end,
                        ':state' => $stateId,
                    ),
                    'order' => '
                                CASE WHEN deadline IS NULL THEN 1 ELSE 0 END, t.deadline,
                                t.university, t.course',
                ),
                'pagination' => array(
                    'pageSize' => 25,
                ),
            ));

            $appData[$stateName] = $applications;
        }

        $this->controller->render('listAll', array(
            'appData' => $appData,
            'time_start' => date('d M Y', strtotime($time_start)),
            'time_end' => date('d M Y', strtotime($time_end)),
        ));
    }
}
