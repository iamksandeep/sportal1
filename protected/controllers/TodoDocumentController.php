<?php

class TodoDocumentController extends Controller
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
            'upload' => 'application.actions.todoDocument.UploadAction',
            'delete' => 'application.actions.todoDocument.DeleteAction',
            'download' => 'application.actions.todoDocument.DownloadAction',
        );
    }

    public function loadModel($id) {
        $model = TDDocument::model()->findByPk($id);

        if($model == null)
            throw new CHttpException(404, 'Requested page not found.');

        return $model;
    }

    public function loadTodo($id) {
        $model = Todo::model()->findByPk($id);

        if($model == null)
          throw new CHttpException(404, 'Requested page not found.');

        return $model;
    }
}
