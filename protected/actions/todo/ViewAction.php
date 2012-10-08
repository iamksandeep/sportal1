<?php

class ViewAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);
        $this->controller->todo = $model;

        $cuId = Yii::app()->user->id;

        // access check
        if(!($model->assignee_id === $cuId || $model->assigner_id === $cuId) && !Yii::app()->user->checkAccess('viewJob', array(
            'student' => $model->student,
            'currentUser' => $this->controller->loadUser($cuId),
        )))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        // activity
        $activityData = new CActiveDataProvider('TDActivity', array(
          'criteria' => array(
            'with' => array('todo', 'author'),
            'condition' => 't.todo_id = :todo_id',
            'params' => array(':todo_id' => $model->id),
            'order' => 'time DESC',
          ),
        ));

        // documents
        $documentData = new CActiveDataProvider('TDDocument', array(
          'criteria' => array(
            'with' => array('todo', 'uploader'),
            'condition' => 't.todo_id = :todo_id',
            'params' => array(
                          ':todo_id' => $model->id,
            ),
            'order' => 'upload_time DESC',
          ),
        ));

        $this->controller->render('view', array(
            'model' => $model,
            'activityData' => $activityData,
            'documentData' => $documentData,
        ));
    }
}
