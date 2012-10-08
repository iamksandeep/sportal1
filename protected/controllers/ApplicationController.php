<?php

class ApplicationController extends Controller
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
                'application.filters.application.DisabledUserFilter - view',
                'controller' => $this,
            ),
            array(
                'application.filters.application.BeforeDeleteFilter + remove',
                'controller' => $this,
            ),
            array(
                'application.filters.application.InactiveApplicationFilter + copyFromTemplate',
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
            'index'=>'application.actions.application.IndexAction',
            'listAll'=>'application.actions.application.ListAllAction',
            'add'=>'application.actions.application.AddAction',
            'index'=>'application.actions.application.IndexAction',
            'edit'=>'application.actions.application.EditAction',
            'remove'=>'application.actions.application.RemoveAction',
            'view'=>'application.actions.application.ViewAction',
            'changeState'=>'application.actions.application.ChangeStateAction',
            'copyFromTemplate'=>'application.actions.application.CopyFromTemplateAction',
		);
	}

    public function loadModel($id) {
        $model = Application::model()->findByPk($id);

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
