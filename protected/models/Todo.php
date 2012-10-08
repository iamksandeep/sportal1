<?php

/**
 * This is the model class for table "td_todo".
 *
 * The followings are the available columns in table 'td_todo':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $assignee_id
 * @property integer $assigner_id
 * @property integer $student_id
 * @property integer $application_id
 * @property integer $application_task_id
 * @property string $initiate_time
 * @property string $deadline
 * @property integer $state
 * @property boolean $approved
 * @property string $complete_time
 * @property string $last_activity_time
 *
 * The followings are the available model relations:
 * @property AtApplicationTask $applicationTask
 * @property AtApplication $application
 * @property User $assignee
 * @property User $assigner
 * @property User $student
 */
class Todo extends CActiveRecord
{
	/**
	 * @return array todo states
	 */
	static public function getStates() {
		return array(
			0 => 'not-started',
			1 => 'in-progress',
			2 => 'complete',
		);
	}

	/**
	 * @param  String $state state name
	 * @return int    State id (numerical)
	 */
	static public function getStateId($state) {
		foreach(self::getStates() as $stateId => $stateName) {
			if($stateName === $state)
				return $stateId;
		}
		return -1;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Todo the static model class
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
		return 'td_todo';
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
			array('title', 'required', 'on' => 'new, edit'),
			array('description, deadline', 'safe', 'on' => 'new, edit'),

			// other
			array('title', 'length', 'max'=>255),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, assignee_id, assigner_id, student_id, application_id, application_task_id, initiate_time, deadline, state, approved', 'safe', 'on'=>'search'),
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
			'applicationTask' => array(self::BELONGS_TO, 'AtApplicationTask', 'application_task_id'),
			'application' => array(self::BELONGS_TO, 'AtApplication', 'application_id'),
			'assignee' => array(self::BELONGS_TO, 'User', 'assignee_id'),
			'assigner' => array(self::BELONGS_TO, 'User', 'assigner_id'),
			'student' => array(self::BELONGS_TO, 'User', 'student_id'),
			'activity' => array(self::HAS_MANY, 'TDActivity', 'todo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'description' => 'Description',
			'assignee_id' => 'Assignee',
			'assigner_id' => 'Assigner',
			'student_id' => 'Student',
			'application_id' => 'Application',
			'application_task_id' => 'Application Task',
			'initiate_time' => 'Initiate Time',
			'deadline' => 'Deadline',
			'state' => 'State',
			'state0' => 'State',
			'approved' => 'Approved?',
			'complete_time' => 'Time of Completion',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('assignee_id',$this->assignee_id);
		$criteria->compare('assigner_id',$this->assigner_id);
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('application_id',$this->application_id);
		$criteria->compare('application_task_id',$this->application_task_id);
		$criteria->compare('initiate_time',$this->initiate_time,true);
		$criteria->compare('deadline',$this->deadline,true);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Do stuff before validlating record
	 * @return boolean parent::beforeValidate()
	 */
	protected function beforeValidate() {
	    if ($this->isNewRecord) {
	    	$this->state = self::getStateId('not-started');
	    	$this->seen_by_assignee = false;
	    }

	    // correct deadline issue
	    if($this->deadline != '') {
	    	$this->deadline = FriendlyTime::getMysqlFormat($this->deadline);
	    }

	    if($this->scenario === 'new') {
	    	$this->initiate_time = new CDbExpression('NOW()');
			$this->assigner_id = Yii::app()->user->id;
	    }

	    return parent::beforeSave();
	}

	/**
	 * Do stuff before saving record
	 * @return boolean parent::beforeSave()
	 */
	protected function beforeSave() {
	    if ($this->deadline == '')
	        $this->setAttribute('deadline', null);

	    if($this->isNewRecord) {
		    // if this is a task for the student
		    if($this->assignee->type0 === 'student') {
		    	// if the manager is assigning, approve automatically
		    	if($this->assignee->roleManager->hasRole($this->assigner_id, 'manager'))
		    		$this->approved = true;
		    	// if someone else is assigning, wait for manager approval
		    	else
		    		$this->approved = false;
		    }
		    // if task for some other type of user, approve pronto
		    else
		    	$this->approved = true;
	    }

	    return parent::beforeSave();
	}

	/**
	 * @return String parsed description
	 */
	public function getParsedDescription() {
		return SmartContentParser::parse($this->description);
	}

	/**
	 * @return String State of todo
	 */
	public function getState0() {
		$states =  self::getStates();
		return $states[$this->state];
	}

	/**
	 * @return String Label class for current todo state
	 */
	public function getStateLabelClass() {
		switch($this->state0) {
			case 'not-started':
				return 'default';
				break;
			case 'in-progress':
				return 'warning';
				break;
			case 'complete':
				return 'success';
				break;
			default:
				return 'default';
		}
	}

	/**
	 * @return String Label class for current todo state
	 */
	public function getStateButtonClass() {
		switch($this->state0) {
			case 'not-started':
				return 'danger';
				break;
			case 'in-progress':
				return 'warning';
				break;
			case 'complete':
				return 'success';
				break;
			default:
				return 'default';
		}
	}

	/**
	 * @return String Icon class for current todo state
	 */
	public function getStateIconClass() {
		switch($this->state0) {
			case 'not-started':
				return 'warning-sign';
				break;
			case 'in-progress':
				return 'pencil';
				break;
			case 'complete':
				return 'check';
				break;
			default:
				return 'time';
		}
	}

	/**
	 * @return mixed Formatted deadline; null if not available
	 */
	public function getDeadline0() {
		if($this->deadline)
			return date('d/m/Y', strtotime($this->deadline));
		return null;
	}

	/**
	 * @return mixed Formatted deadline; null if not available
	 */
	public function getNiceDeadline() {
		if($this->deadline)
			return date('d M', strtotime($this->deadline));
		return null;
	}

	/**
	 * Logs activity for this task
	 * @param  String $msg activity
	 * @return boolean      whether logging was successful
	 */
	public function log($msg) {
		$this->updateLastActivityTime();
		return ActivityLogger::todoLog($msg, $this->id);
	}

	/**
	 * updates the last activity time for this todo item
	 */
	public function updateLastActivityTime() {
		$this->last_activity_time = new CDbExpression('NOW()');
		$this->save();
	}

	/**
	 * @return int number of unread activities by current user
	 */
	public function getUnreadActivityCount() {
		$sql = <<<EOD
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
				WHERE t.id = :todoId
EOD;
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindValue(':user_id', Yii::app()->user->id, PDO::PARAM_INT);
        $cmd->bindValue(':todoId', $this->id, PDO::PARAM_INT);
        $res = $cmd->queryAll();

		return $res[0]['unreadCount'];
	}

	/**
	 * @return int number of unread activities by current user
	 */
	static public function getUnreadActivityCountByState($state) {
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
				AND t.state = :state
				AND t.approved = 1
			   ) AS u
EOD;
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindValue(':user_id', Yii::app()->user->id, PDO::PARAM_INT);
        $cmd->bindValue(':assigneeId', Yii::app()->user->id, PDO::PARAM_INT);
        $cmd->bindValue(':state', self::getStateId($state), PDO::PARAM_INT);
        $res = $cmd->queryAll();

		return $res[0]['unreadCount'] ? $res[0]['unreadCount'] : 0;
	}

	/**
	 * Marks all activity in this todo
	 * as read by current app user
	 */
	public function markAsRead() {
		if($this->getIsNew()) {
			$this->seen_by_assignee = true;
			$this->save();
		}
		foreach($this->activity as $a) {
			$a->markAsReadBy(Yii::app()->user->id);
		}
	}

	/**
	 * Sets state for current todo item
	 * @param string $state name of state
	 */
	public function setState($state) {
		$this->state = $state;

		// if state is complete, set complete time
		if($this->state0 === 'complete')
			$this->complete_time = new CDbExpression('NOW()');

		return $this->save();
	}

	/**
	 * Return current pending approvals count for current user
	 */
	static public function pendingApprovalsCount() {
		return Todo::model()->count(array(
            'join' => 'LEFT JOIN `user` `student` ON (`student`.`id` = `t`.`student_id`)
                        LEFT JOIN `role_assignment` `roleAssignments` ON (`student`.`id` = `roleAssignments`.`student_id`)',
            'condition' => 'approved = 0
                            AND roleAssignments.role = :role
                            AND roleAssignments.user_id = :userId',
            'params' => array(
                ':role' => RoleManager::getRoleId('manager'),
                ':userId' => Yii::app()->user->id,
            )
        ));
	}

	/**
	 * @return boolean whether this task is new(unseen) for current user
	 */
	public function getIsNew() {
		return (!$this->seen_by_assignee && $this->assignee_id === Yii::app()->user->id);
	}
}
