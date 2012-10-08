<?php

class ViewAction extends CAction {

    public function run($id) {
        $conv = $this->controller->loadModel($id);
        $this->controller->conversation = $conv;

        // access check
        if(!$conv->hasMember(Yii::app()->user->id))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        $messageDataProvider = new CActiveDataProvider('Message', array(
            'criteria' => array(
                'condition' => 'conversation_id = :conv_id',
                'params' => array(':conv_id' => $id),
                'order' => 'send_time DESC',
            ),

            'pagination' => array(
                'pageSize' => 5,
            ),
        ));

        $this->controller->render('view', array(
            'conv' => $conv,
            'messageDataProvider' => $messageDataProvider,
        ));
    }
}
