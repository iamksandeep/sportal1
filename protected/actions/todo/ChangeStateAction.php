<?php

class ChangeStateAction extends CAction {

    public function run($id, $state) {
        $model = $this->controller->loadModel($id);

        $cuId = Yii::app()->user->id;

        // access check
        if(!($model->assignee_id === $cuId || $model->assigner_id === $cuId) && !Yii::app()->user->checkAccess('changeJobState', array(
            'student' => $model->student,
            'currentUser' => $this->controller->loadUser($cuId),
        )))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        if($model->setState($state)) {
            $model->refresh();
            Yii::app()->user->setFlash('success', 'Job state has been changed to <strong>' . $model->state0 . '</strong>');
            $model->log('changed job state to <strong>'.$model->state0.'</strong>');
        }
        else
            Yii::app()->user->setFlash('error', 'Unable to change state.');

        $this->controller->redirect(array('view', 'id' => $model->id));
    }
}
