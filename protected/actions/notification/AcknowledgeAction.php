<?php

class AcknowledgeAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);
        // access check
        if($model->target_id !== Yii::app()->user->id)
            throw new CHttpException(403, 'You are not authorized to make this request!');

        $model->ack = true;
        echo $model->save();
    }
}
