<?php

class SearchAction extends CAction {

    public function run() {
        // access check
        $currentUser = User::model()->findByPk(Yii::app()->user->id);
        if($currentUser->type0 === 'student')
            throw new CHttpException(403, 'You are not authorized to make this request!');

        $criteria = new CDbCriteria;

        // search
        $s = null;
        if(isset($_POST['search'])) {
          $s = $_POST['search'];
          $criteria->compare('name_first', $s, true);
          $criteria->compare('name_last', $s, true, 'OR');
          $criteria->compare('email', $s, true, 'OR');
        }

        // order
        $criteria->order = 'name_first, name_last, id';

        $res = User::model()->findAll($criteria);

        $userData = array();
        foreach ($res as $r) {
          array_push($userData, array(
            'id' => $r->id,
            'name' => $r->name,
            'type' => $r->type0,
            'gravatarUrl' => $r->getGravatarUrl(14),
          ));
        }

        echo json_encode($userData);
    }
}
