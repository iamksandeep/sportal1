<?php

class AcademicDetailController extends Controller
{
    public $layout = '//layouts/column2fb';
    public $showProfileFor; // user profile on the left
    public $currentProfileMenuItem; // current profile highlighted item

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
            array(
                'application.filters.academicDetail.DisabledUserFilter',
                'controller' => $this,
            ),
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
            'add'=>'application.actions.academicDetail.AddAction',
            'edit'=>'application.actions.academicDetail.EditAction',
            'delete'=>'application.actions.academicDetail.DeleteAction',
        );
    }

    public function loadModel($id) {
        $model = AcademicDetail::model()->findByPk($id);

        if($model == null)
            throw new CHttpException(404, 'Requested page not found.');

        return $model;
    }

      public function loadUser($id) {
        $model = User::model()->findByPk($id);

        if($model == null)
          throw new CHttpException(404, 'Requested page not found.');

        return $model;
      }
}
