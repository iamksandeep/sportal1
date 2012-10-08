<?php

class ViewAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

        $currentUser = User::model()->findByPk(Yii::app()->user->id);

        // access control
        if($currentUser->type0 === 'student' && $model->student->id !== $currentUser->id)
          throw new CHttpException(403, 'You are not authorized to make this request!');


        // details
        $applicationDetailData = new CActiveDataProvider('ApplicationDetail', array(
          'criteria' => array(
            'condition' => 'application_id = :application_id',
            'params' => array(':application_id' => $model->id),
          ),
        ));

        // tasks
        $taskData = array();

        foreach(ApplicationTask::getStates() as $stateId => $stateName) {
            $condition = 't.application_id = :application_id
                            AND t.state = :state';

            $params = array(
                ':application_id' => $model->id,
                ':state' => $stateId,
            );

            $tasks = new CActiveDataProvider('ApplicationTask', array(
                'criteria' => array(
                    'condition' => $condition,
                    'params' => $params,
                    'order' => 't.title',
                ),
                'pagination' => array('pageSize' => 20),
            ));

            $taskData[$stateName] = $tasks;
        }

        // documents - general
        $generalDocumentData = new CActiveDataProvider('Document', array(
          'criteria' => array(
            'condition' => 'application_id = :application_id
                            AND type = :type',
            'params' => array(
                          ':application_id' => $model->id,
                          ':type' => Document::getTypeId('general'),
                        ),
            'order' => 'upload_time DESC',
          ),
        ));

        // documents - content
        $contentDocumentData = new CActiveDataProvider('Document', array(
          'criteria' => array(
            'condition' => 'application_id = :application_id
                            AND type = :type',
            'params' => array(
                          ':application_id' => $model->id,
                          ':type' => Document::getTypeId('content'),
                        ),
            'order' => 'upload_time DESC',
          ),
        ));

        // activity
        $activityData = new CActiveDataProvider('Activity', array(
          'criteria' => array(
            'condition' => 'application_id = :application_id',
            'params' => array(':application_id' => $model->id),
            'order' => 'time DESC',
          ),
        ));

        $this->controller->render('view', array(
          'model' => $model,
          'applicationDetailData' => $applicationDetailData,
          'taskData' => $taskData,
          'activityData' => $activityData,
          'generalDocumentData' => $generalDocumentData,
          'contentDocumentData' => $contentDocumentData,
        ));
    }
}
