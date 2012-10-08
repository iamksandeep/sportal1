<?php

class EditAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);
        $model->setScenario('edit');

        $cuId = Yii::app()->user->id;

        // access check
        if($model->assigner_id !== $cuId && !Yii::app()->user->checkAccess('editJobDetails', array(
            'student' => $model->student,
            'currentUser' => $this->controller->loadUser($cuId),
        )))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Todo'])) {
            $model->attributes = $_POST['Todo'];

            if($model->save()) {
                Yii::app()->user->setFlash('success', 'Job details have been updated');
                $model->log('edited job details');
                $this->controller->redirect(array('view', 'id' => $model->id));
            }
            else
                Yii::app()->user->setFlash('error', 'Unable to update details');
        }

        $this->controller->render('edit', array(
            'model' => $model,
            'student' => $model->student,
            'assignee' => $model->assignee,
        ));
    }
}
