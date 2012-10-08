<?php

class BeforeDeleteFilter extends CFilter {

    public $controller;

    public function preFilter() {
        if(isset($_GET['id'])) {
            $model = $this->controller->loadModel($_GET['id']);
            $delete = true;

            // check for applications
            if(sizeof($model->applications) > 0) {
                $delete = false;
                Yii::app()->user->setFlash('error', 'You must delete all user applications before deleting this user');
            }

            // check for documents
            if(sizeof($model->documents) > 0) {
                $delete = false;
                Yii::app()->user->setFlash('error', 'You must delete all user documents before deleting this user');
            }

            // check for uploaded documents
            if(sizeof($model->uploadedDocuments) > 0) {
                $delete = false;
                Yii::app()->user->setFlash('error', 'You must delete all documents uploaded by this user before deleting this user');
            }

            if(!$delete)
                $this->controller->redirect(array('view', 'id' => $model->id));
        }

        return true;
    }
}