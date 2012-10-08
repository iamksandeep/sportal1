<?php

class NewAction extends CAction {

    public function run() {
        $currentUser = User::model()->findByPk(Yii::app()->user->id);

        // access check
        if($currentUser->type0 === 'student')
            throw new CHttpException(403, 'You are not authorized to make this request!');

        $this->controller->layout = '//layouts/column1';

        $msgData = array();

        if(isset($_POST['Message'])) {
            $msgData = $_POST['Message'];
            $receipients = array();

            if(isset($_POST['Message']['user'])) {
                $rr = $msgData['user'];
                // select receipients
                $studentId = null;
                $receipients = array();

                foreach($msgData['user'] as $usrId) {
                    // load this user from db
                    $user = User::model()->findByPk(intval($usrId));

                    if($user) {
                        // if this is a student user
                        if($user->type0 === 'student') {
                            // if a student has already been added, skip this user
                            if($studentId) continue;
                            else $studentId = $user->id;
                        }

                        // also, if this is current user, skip
                        if($user->id === Yii::app()->user->id) continue;

                        // duplicate?, skip
                        if(in_array($user, $receipients)) continue;

                        // add to array
                        array_push($receipients, $user);
                    }
                }

                // if student is in receipients, check if allowed to send
                $proceed = true;
                if($studentId)
                    $proceed = Yii::app()->user->checkAccess('messageStudent', array(
                            'student' => User::model()->findByPk($studentId),
                            'currentUser' => $currentUser,
                    ));

                if($proceed) {
                    // now, get student context
                    $studentContextId = null;
                    if($msgData['hasStudentContext'] == 'yes')
                        $studentContextId = intval($msgData['student_id']);
                    // but if a student was found in the receipients, forget this student,
                    // and add the one we found earlier
                    if($studentId) $studentContextId = $studentId;

                    // start building
                    $conv = new Conversation('new_multi');
                    if($studentContextId) $conv->student_id = $studentContextId;
                    $conv->subject = $msgData['subject'];

                    $msg = new Message('compose');
                    $msg->author_id = Yii::app()->user->id;
                    $msg->content = $msgData['content'];

                    if($msg->validate() && $conv->save()) {
                        $msg->conversation_id = $conv->id;

                        // add receipients to conv members
                        foreach($receipients as $r) {
                            $conv->addMember($r->id);
                        }

                        if($msg->save()) {
                            $msg->markAsReadBy(Yii::app()->user->id);
                            Yii::app()->user->setFlash('success', 'Your message has been sent!');
                            $this->controller->redirect(array('conversation/view', 'id' => $conv->id));
                        }
                    }
                }
                else {
                    Yii::app()->user->setFlash('warning', 'You cannot send message to this student');
                }
            }
            else
                Yii::app()->user->setFlash('error', 'You must select at least one receipient');
        }

        $this->controller->render('new', array(
            'msgData' => $msgData,
        ));
    }
}
