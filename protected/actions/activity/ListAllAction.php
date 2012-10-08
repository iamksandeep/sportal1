<?php
class ListAllAction extends CAction {
    public function run() {
        $this->controller->layout = '//layouts/column1';

        // access check
        if(!Yii::app()->user->checkAccess('viewAllActivity', array(
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        // activity
        $activityData = new CActiveDataProvider('Activity', array(
          'criteria' => array(
            'with' => array('student', 'author', 'application', 'applicationTask'),
            'order' => 'time DESC',
          ),

          'pagination' => array(
                'pageSize' => 50,
            ),
        ));

        $this->controller->render('listAll', array(
            'activityData' => $activityData,
        ));
    }
}
