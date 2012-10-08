<?php

class ReplyAction extends CAction {

    public function run($conv_id) {
        $conv = $this->controller->loadConversation($conv_id);
        $msg = new Message('reply');
        $msg->conversation_id = $conv_id;

        // access check
        if(!$conv->hasMember(Yii::app()->user->id))
            throw new CHttpException(403, 'You are not authorized to make this request!');


        // Check if form has been submitted
        if(isset($_POST['Message'])) {
            // Get form data
            $msg->attributes = $_POST['Message'];

            // If msg save is successful, go to conversation view page
            if($msg->save()) {
                $msg->markAsReadBy(Yii::app()->user->id);
                $this->controller->redirect(array('conversation/view', 'id' => $conv_id));
            }
        }

        $this->controller->render('reply', array(
            'msg' => $msg,
            'conv' => $conv,
        ));
    }
}
