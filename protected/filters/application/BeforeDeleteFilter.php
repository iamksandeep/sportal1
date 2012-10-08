<?php

class BeforeDeleteFilter extends CFilter {

    public $controller;

    public function preFilter() {
        if(isset($_GET['id'])) {
            $model = $this->controller->loadModel($_GET['id']);

            // check for documents
            if(sizeof($model->documents) > 0) {
                Yii::app()->user->setFlash('error', 'You must delete all applications documents before deleting this application');
                $this->controller->redirect(array('view', 'id' => $model->id));
            }
        }

        return true;
    }
}