<?php

class ActivityCountAction extends CAction {

    public function run() {
        $model = $this->controller->loadUser(Yii::app()->user->id);
        echo $model->jobActivityCount;
    }
}
