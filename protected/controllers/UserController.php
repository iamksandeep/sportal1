<?php

class UserController extends Controller
{
	public $layout = '//layouts/column2';
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
				'application.filters.user.BeforeDeleteFilter + remove',
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

	public function actions() {
		return array(
			'add' => 'application.actions.user.AddAction',
			'update' => 'application.actions.user.UpdateAction',
			'view' => 'application.actions.user.ViewAction',
			'index' => 'application.actions.user.IndexAction',
			'remove' => 'application.actions.user.RemoveAction',
			'changePassword' => 'application.actions.user.ChangePasswordAction',
			'resetPassword' => 'application.actions.user.ResetPasswordAction',
			'changeType' => 'application.actions.user.ChangeTypeAction',
			'disable' => 'application.actions.user.DisableAction',
			'enable' => 'application.actions.user.EnableAction',
			'assignRole' => 'application.actions.user.EnableAction',
			'assignedToMe' => 'application.actions.user.AssignedToMeAction',
			'search' => 'application.actions.user.SearchAction',
			//'mailNewPassword' => 'application.actions.user.MailNewPasswordAction',
		);
	}

	public function loadModel($id) {
		$model = User::model()->findByPk($id);

		if($model == null)
			throw new CHttpException(404, 'Requested page not found.');

		return $model;
	}
}
