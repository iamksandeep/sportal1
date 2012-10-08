<?php

class ComposeAction extends CAction {

    private function allowMessageStudent($student, $currentUser) {
        return Yii::app()->user->checkAccess('messageStudent', array(
                'student' => $student,
                'currentUser' => $currentUser,
              ));
    }

    public function run($to, $student_id) {
        $_to = $this->controller->loadUser($to);
        $_student = $this->controller->loadUser($student_id);

        $conv = new Conversation('new');
        $conv->to = $_to->id;
        $conv->student_id = $_student->id;
        $msg = new Message('compose');

        $currentUser = User::model()->findByPk(Yii::app()->user->id);

        // check if msg from student
        if($currentUser->type0 === 'student')
            throw new CHttpException(403, 'You are not authorized to make this request!');

        // check if msg to student
        if($student_id == $to && !$this->allowMessageStudent($_student, $currentUser))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        // Check if form has been submitted
        if(isset($_POST['Message'], $_POST['Conversation'])) {
            // Get form data
            $msg->attributes = $_POST['Message'];
            $conv->attributes = $_POST['Conversation'];

            // Validate message content and save conversation
            if($msg->validate() && $conv->save()) {
                $msg->conversation_id = $conv->id;
                // If msg save is successful, go to conversation view page
                if($msg->save()) {
                    $msg->markAsReadBy(Yii::app()->user->id);
                    Yii::app()->user->setFlash('success', 'Your message has been sent!');
                    $this->controller->redirect(array('conversation/view', 'id' => $conv->id));
                }
                // If it fails, delete conversation (since it has no messages)
                else {
                    Yii::app()->user->setFlash('error', 'Unable to send message');
                    $conv->delete();
                }
            }
        }

        $this->controller->render('compose', array(
            'msg' => $msg,
            'conv' => $conv,
            '_to' => $_to,
            '_student' => $_student,
        ));
    }
}
