<?php

class NotificationController extends Controller
{
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl - unacknowledgedCount',
        );
    }

    /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actions()
    {
        return array(
            'index'=>'application.actions.notification.IndexAction',
            'unacknowledgedCount'=>'application.actions.notification.UnacknowledgedCountAction',
            'acknowledge'=>'application.actions.notification.AcknowledgeAction',
            'acknowledgeAll'=>'application.actions.notification.AcknowledgeAllAction',
        );
    }

      public function loadUser($id) {
        $model = User::model()->findByPk($id);

        if($model == null)
          throw new CHttpException(404, 'Requested page not found.');

        return $model;
      }

      public function loadModel($id) {
        $model = Notification::model()->findByPk($id);

        if($model == null)
          throw new CHttpException(404, 'Requested page not found.');

        return $model;
      }
}
