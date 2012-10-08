<?php

class UniversityCredentialController extends Controller
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
          'application.filters.universityCredential.DisabledUserFilter',
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
          'edit'=>'application.actions.universityCredential.EditAction',
        );
    }

    public function loadModel($id) {
        $model = ApplicationDetail::model()->findByPk($id);

        if($model == null)
            throw new CHttpException(404, 'Requested page not found.');

        return $model;
    }

  public function loadApplication($id) {
    $model = Application::model()->findByPk($id);

    if($model == null)
      throw new CHttpException(404, 'Requested page not found.');

    return $model;
  }
}
