<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name_first
 * @property string $name_last
 * @property string $email
 * @property string $password
 * @property string $password_salt
 * @property int $type
 * @property bool $disabled
 */
class User extends CActiveRecord
{
	/**
	 * @return array User types
	 */
	static public function getTypes() {
		return array(
			0 => 'superadmin',
			1 => 'admin',
			2 => 'mnemonic',
			3 => 'student',
		);
	}

	/**
	 * @param  String $type type name
	 * @return int       Type id (numerical)
	 */
	static public function getTypeId($type) {
		foreach(self::getTypes() as $typeId => $typeName) {
			if($typeName === $type)
				return $typeId;
		}
		return -1;
	}

	/**
	 * Confirmation password
	 * @var String
	 */
	public $password_repeat;

	/**
	 * Old password
	 * @var String
	 */
	public $password_old;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// safe
			array('email, name_first, name_last', 'required', 'on' => 'add, update'),
			array('password', 'required', 'on' => 'add, change-password'),
			array('password_old', 'required', 'on' => 'change-password'),
			array('password', 'compare', 'on' => 'add, change-password' ),
			array('type', 'safe', 'on' => 'change-type'),

			// other
			array('email', 'email'),
			array('email', 'unique'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('name_first, name_last, email, password, password_old, password_repeat', 'length', 'max'=>255),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name_first, name_last, email, password', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'applications' => array(self::HAS_MANY, 'Application', 'student_id'),
			'activity' => array(self::HAS_MANY, 'Activity', 'student_id'),
			'postedActivity' => array(self::HAS_MANY, 'Activity', 'author_id'),
			'documents' => array(self::HAS_MANY, 'Document', 'student_id'),
			'uploadedDocuments' => array(self::HAS_MANY, 'Document', 'uploader_id'),
			'roleAssignments' => array(self::HAS_MANY, 'RoleAssignment', 'student_id'),
			'tasksTodo' => array(self::HAS_MANY, 'Todo', 'assignee_id'),
			'tasksAssigned' => array(self::HAS_MANY, 'Todo', 'assigner_id'),
			'relatedTodo' => array(self::HAS_MANY, 'Todo', 'student_id'),
            'profile' => array(self::HAS_MANY, 'ProfileDetail', 'student_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name_first' => 'First Name',
			'name_last' => 'Last Name',
			'email' => 'Email',
			'password' => 'Password',
			'password_repeat' => 'Repeat Password',
			'password_old' => 'Old Password',
			'type' => 'Type of user',
			'type0' => 'Type of user',
			'name' => 'Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name_first',$this->name_first,true);
		$criteria->compare('name_last',$this->name_last,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Do stuff before validation
	 */
	protected function beforeValidate() {
		if($this->isNewRecord && $this->getScenario() === 'add') {
			// Salt and Hash user provided password
			$sPassword = new SecurePassword($this->password, null);
			$this->password = $this->password ? $sPassword->getPassword() : '';
			$this->password_salt = $sPassword->getSalt();

			// Salt and Hash user provided password repeat
			$sPasswordRepeat = new SecurePassword($this->password_repeat, $this->password_salt);
			$this->password_repeat = $sPasswordRepeat->getPassword();

			// mark account as active
			$this->disabled = false;
		}

		return parent::beforeValidate();
	}

	/**
	 * @param  String $password Test password
	 * @return boolean Whether given password is correct
	 */
	public function checkPassword($password) {
    $sPassword = new SecurePassword($password, $this->password_salt);
    return $this->password == $sPassword->getPassword();
	}

	/**
	 * Change password for this user
	 * @param  String  $password new password
	 * @param  boolean $newSalt  Generate new salt. Default true.
	 * @return boolean whether save successful
	 */
	public function changePassword($password, $newSalt = true) {
		if($newSalt)
    	$sPassword = new SecurePassword($password, null);
    else
    	$sPassword = new SecurePassword($password, $this->salt);

    $this->password = $sPassword->getPassword();
    $this->password_salt = $sPassword->getSalt();
    return $this->save();
	}

	/**
	 * @return String Type of user
	 */
	public function getType0() {
		$types =  self::getTypes();
		return $types[$this->type];
	}

	/**
	 * @return String Full name of user
	 */
	public function getName() {
		return $this->name_first.' '.$this->name_last;
	}

	/**
	 * Logs activity for this user
	 * @param  String $msg activity
	 * @return boolean      whether logging was successful
	 */
	public function log($msg) {
		return ActivityLogger::log($msg, $this->id);
	}

	/**
	 * @return RoleManager Instance of role manager for this student
	 */
	public function getRoleManager() {
		return new RoleManager($this);
	}

    /**
     * @return Array List of mnemonic users for dropdown list
     */
    public function getMnemonicUsers() {
        return User::model()->findAll(array(
                'condition' => 'type = :t1
                                OR type = :t2
                                OR type = :t3',
                'params' => array(
                                ':t1' => User::getTypeId('superadmin'),
                                ':t2' => User::getTypeId('admin'),
                                ':t3' => User::getTypeId('mnemonic'),
                            ),
                'order' => 'name_first, name_last, id',
            ));
    }

    /**
     * @return Array List of student users for dropdown list
     */
    public function getStudentUsers() {
        return User::model()->findAll(array(
                'condition' => 'type = :t',
                'params' => array(
                                ':t' => User::getTypeId('student'),
                            ),
                'order' => 'name_first, name_last, id',
            ));
    }

	/**
	 * Stores a notification for a this user and activity
	 * @param  Activity $activity Activity about which to notify
	 * @return boolean             whether notification was stored
	 */
	public function notify($activity) {
		// if action performer is current user, skip
		if($activity->author_id === $this->id)
			return false;

		// first check if doesnt already exist
		if(intval(Notification::model()->countByAttributes(array(
			'target_id' => $this->id,
			'activity_id' => $activity->id,
			'ack' => false,
		))) > 0)
			return false;

		// proceed with notifying
		$n = new Notification();
		$n->target_id = $this->id;
		$n->activity_id = $activity->id;
		return $n->save();
	}

	/**
	 * Notifies all users in given roles about activity
	 * @param  Activity $activity Activity about which to notify
	 * @param  array $roles      roles to notify
	 */
	public function notifyRoles($activity, $roles) {
		$rm = $this->getRoleManager();

		foreach($roles as $role) {
			$assignments = $rm->getAssignmentsInRole($role);
			foreach($assignments as $ass)
				$ass->user->notify($activity);
		}
	}

    /**
     * @param  integer $size Size of gravatar
     * @return String        Gravatar image
     */
    public function getGravatar($size = null) {
        $emailHash = md5(strtolower(trim($this->email)));
        $imgUrl = 'http://www.gravatar.com/avatar/'.$emailHash.'.jpg?d=identicon&r=g';
        if($size) $imgUrl .= '&s='.$size;
        return CHtml::image($imgUrl, CHtml::encode($this->name));
    }

    /**
     * @param  integer $size Size of gravatar
     * @return String        Gravatar image url
     */
    public function getGravatarUrl($size = null) {
        $emailHash = md5(strtolower(trim($this->email)));
        $imgUrl = 'http://www.gravatar.com/avatar/'.$emailHash.'.jpg?d=identicon&r=g';
        if($size) $imgUrl .= '&s='.$size;
        return $imgUrl;
    }

	/**
	 * @param  integer $size Size of gravatar
	 * @return String        Gravatar + image
	 */
	public function getGravatarAndName($size = 14) {
	    $emailHash = md5(strtolower(trim($this->email)));
	    $imgUrl = 'http://www.gravatar.com/avatar/'.$emailHash.'.jpg?d=identicon&r=g&s='.$size;
	    return CHtml::image($imgUrl, CHtml::encode($this->name)) .' '. CHtml::Encode($this->name);
	}

	/**
	 * @param  integer $size Size of gravatar
	 * @return String        Gravatar + image link
	 */
	public function getGravatarAndNameLink($size = 14) {
		return CHtml::link($this->getGravatarAndName($size), array('user/view', 'id' => $this->id));
	}

	/**
	 * @param  int $id ID of model
	 * @return String     a link to model
	 */
	static public function getLinkFor($id) {
		if($id === Yii::app()->user->id)
			return '<strong>You</strong>';

		$model = self::model()->findByPk($id);

		if($model) {
			return CHtml::link($model->gravatarAndName, array('user/view', 'id' => $model->id));
		}

		return null;
	}

    public function getApplicationList() {
        return Application::model()->findAll(array(
                'condition' => 'student_id = :student_id
                                AND state <> :state',
                'params' => array(
                        ':student_id' => $this->id,
                        ':state' => Application::getStateId('inactive'),
                ),
                'order' => 'university, course',
        ));
    }

/*
RBAC METHODS
----------------------------------------------------------------
*/
	  public function revokeAllRoles() {
	    // delete all previous assignments
	    $query = "DELETE FROM AuthAssignment WHERE userid = :uid";
	    $command = Yii::app()->db->createCommand($query);
	    $command->bindValue(":uid", $this->id, PDO::PARAM_INT);
	    return $command->execute();
	  }

	  public function assignRoles() {
	    // try to get instance of CAuthManager
	    if(($auth = Yii::app()->authManager) == null)
	      return;

	    // assign roles based on type
	    if($this->type0 === 'student') {
	      $auth->assign('student', $this->id);
	    }
	    else {
	      $auth->assign('researcher', $this->id);
	      $auth->assign('counselor', $this->id);
	      $auth->assign('content-writer', $this->id);
	      $auth->assign('manager', $this->id);
	      $auth->assign('mnemonicGeneralReader', $this->id);
	      $auth->assign('admin', $this->id);
	      $auth->assign('superadmin', $this->id);
	    }
	  }

	  protected function afterSave() {
	    parent::afterSave();

	    $this->revokeAllRoles();
	    $this->assignRoles();
	  }

  static public function generateRandomPassword($length = 12) {
    $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
              '0123456789``-=~!@#$%^&*()_+,./<>?;:[]{}\|';

    $str = '';
    $max = strlen($chars) - 1;

    for ($i=0; $i < $length; $i++)
      $str .= $chars[rand(0, $max)];

    return $str;
  }

  /**
   * @return int nuumber of unread messages for this user
   */
  public function getUnreadMessageCount() {
        $sql = <<<EOD
        SELECT
        SUM((
            SELECT COUNT(id)
            FROM msg_msg
            WHERE conversation_id = C.id
        ) -
        (
            SELECT COUNT(*)
            FROM msg_msg
            LEFT JOIN msg_read
            ON msg_msg.id = msg_read.msg_id
            WHERE conversation_id = C.id
            AND msg_read.user_id = :currentUserId
        )) AS unreadCount
        FROM msg_conv C
        LEFT JOIN msg_conv_member M
        ON C.id = M.conv_id
        WHERE M.user_id = :currentUserId
EOD;
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindValue(':currentUserId', $this->id, PDO::PARAM_INT);
        $res = $cmd->queryAll();

        return $res[0]['unreadCount'] ? $res[0]['unreadCount'] : 0;
  }

  public function getJobActivityCount() {
    $sql = <<<EOD
           SELECT SUM(u.unreadCount) AS unreadCount
           FROM (
            SELECT t.id,
            (
                SELECT COUNT(id)
                FROM td_activity
                WHERE td_activity.todo_id = t.id
            ) -
            (
                SELECT COUNT(*)
                FROM td_activity
                LEFT JOIN td_activity_read
                ON td_activity.id = td_activity_read.todo_activity_id
                WHERE td_activity.todo_id = t.id
                AND td_activity_read.user_id = :user_id
            ) AS unreadCount
            FROM
            td_todo t
            WHERE (t.assignee_id = :user_id
            OR t.assigner_id = :user_id)
            AND t.approved = 1
           ) AS u
EOD;
    $cmd = Yii::app()->db->createCommand($sql);
    $cmd->bindValue(':user_id', $this->id, PDO::PARAM_INT);
    $cmd->bindValue(':assigneeId', $this->id, PDO::PARAM_INT);
    $res = $cmd->queryAll();

    return $res[0]['unreadCount'] ? $res[0]['unreadCount'] : 0;
  }
}
