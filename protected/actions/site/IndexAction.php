<?php

class IndexAction extends CAction {

    public function run() {
        if(Yii::app()->user->isGuest)
            $this->controller->redirect(array('login'));
        else
            $this->controller->redirect(array('user/view', 'id' => Yii::app()->user->id));
    }
}
