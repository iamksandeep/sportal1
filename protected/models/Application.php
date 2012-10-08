<?php

/**
 * This is the model class for table "at_application".
 *
 * The followings are the available columns in table 'at_application':
 * @property integer $id
 * @property integer $student_id
 * @property string $university
 * @property string $course
 * @property string $deadline
 * @property integer $state
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property User $student
 */
class Application extends CActiveRecord
{
	const ICON_CLASS = 'folder-open';

	// if not selected from drop down, allow custom university
	public $university_other;

	// if not selected from drop down, allow custom course
	public $course_other;

	/**
	 * @return array Application states
	 */
	static public function getStates() {
		return array(
			0 => 'inactive',
			1 => 'shortlisted',
			2 => 'in-progress',
			3 => 'complete',
		);
	}

	/**
	 * @param  String $tate state name
	 * @return int       State id (numerical)
	 */
	static public function getStateId($state) {
		foreach(self::getStates() as $stateId => $stateName) {
			if($stateName === $state)
				return $stateId;
		}
		return -1;
	}

	/**
	 * @return String State of application
	 */
	public function getState0() {
		$states =  self::getStates();
		return $states[$this->state];
	}

	/**
	 * @return array Application typesl
	 */
	static public function getTypes() {
		return array(
			0 => 'safe',
			1 => 'range',
			2 => 'dream',
			3 => 'other',
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
	 * @return String Type of application
	 */
	public function getType0() {
		$types =  self::getTypes();
		return $types[$this->type];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Application the static model class
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
		return 'at_application';
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
			array('university, course, type', 'required', 'on' => 'add, update'),
			array('deadline', 'safe', 'on' => 'add, update'),
			array('state', 'safe', 'on'=>'change-state'),
			array('university_other, course_other', 'safe', 'on'=>'add, edit'),

			// other
			array('university, university_other, course, course_other', 'length', 'max'=>255),
			array('state', 'numerical', 'integerOnly'=>true),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student_id, university, course, deadline, state', 'safe', 'on'=>'search'),
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
			'student' => array(self::BELONGS_TO, 'User', 'student_id'),
			'applicationDetails' => array(self::HAS_MANY, 'ApplicationDetail', 'application_id'),
			'applicationTasks' => array(self::HAS_MANY, 'ApplicationTask', 'application_id'),
			'activity' => array(self::HAS_MANY, 'Activity', 'application_id'),
			'documents' => array(self::HAS_MANY, 'Document', 'application_id'),
			'relatedTodo' => array(self::HAS_MANY, 'Todo', 'application_id'),
			'credentials' => array(self::HAS_ONE, 'UniversityCredential', 'application_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'student_id' => 'Student',
			'university' => 'University',
			'course' => 'Course',
			'deadline' => 'Deadline',
			'state' => 'State',
			'state0' => 'State',
			'type' => 'Type',
			'type0' => 'Type',
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
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('university',$this->university,true);
		$criteria->compare('course',$this->course,true);
		$criteria->compare('deadline',$this->deadline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Do stuff before validlating record
	 * @return boolean parent::beforeValidate()
	 */
	protected function beforeValidate() {
	    if ($this->isNewRecord && $this->getScenario() === 'add') {
	    	$this->state = 0;
	    }

	    // correct deadline issue
	    if($this->deadline != '') {
	    	$this->deadline = FriendlyTime::getMysqlFormat($this->deadline);
	    }

		// if alternate university is set, use that
		if($this->university_other && $this->university_other != '')
			$this->university = $this->university_other;

		// if alternate course is set, use that
		if($this->course_other && $this->course_other != '')
			$this->course = $this->course_other;

	    return parent::beforeSave();
	}

	/**
	 * Do stuff before saving record
	 * @return boolean parent::beforeSave()
	 */
	protected function beforeSave() {
	    if ($this->deadline == '')
	        $this->setAttribute('deadline', null);

	    return parent::beforeSave();
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
	 * @return String Combined application title
	 */
	public function getTitle() {
		return $this->university.' - '.$this->course;
	}

	/**
	 * @return int Progress percentage of this application
	 */
	public function getProgress() {
		// if application marked as complete, return 100%
		if($this->state0 === 'complete')
			return 100;

		// calculate progress from checklist items' status
		$numChecklistItems = 0;
		$numCompletedChecklistItems = 0;

		foreach($this->applicationTasks as $task) {
			$numChecklistItems++;
			if($task->state0 === 'complete')
				$numCompletedChecklistItems++;
		}
		if($numChecklistItems == 0) $numChecklistItems = 1;

		$progress = ceil(($numCompletedChecklistItems / $numChecklistItems) * 100);
		return min(99, $progress);
	}

	/**
	 * @param  int $progress progress percentage
	 * @return String          Class of progress bar
	 */
	static public function getProgressBarClass($progress) {
		if($progress < 50) return 'danger';
		if($progress < 100)	return 'info';
		return 'success';
	}

	/**
	 * @return String Label class for current application state
	 */
	public function getStateLabelClass() {
		switch($this->state0) {
			case 'inactive':
				return 'default';
				break;
			case 'shortlisted':
				return 'inverse';
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
	 * @return String Label class for current application state
	 */
	public function getTypeIconClass() {
		switch($this->type0) {
			case 'dream':
				return 'heart';

			case 'range':
				return 'star';

			case 'safe':
				return 'thumbs-up';

			default:
				return 'label';
		}
	}

	/**
	 * @return String Label class for current todo state
	 */
	public function getStateButtonClass() {
		switch($this->state0) {
			case 'inactive':
				return 'danger';
				break;
			case 'shortlisted':
				return 'inverse';
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
	 * @return String Icon class for current application state
	 */
	public function getStateIconClass() {
		switch($this->state0) {
			case 'inactive':
				return 'pause';
				break;
			case 'shortlisted':
				return 'list';
				break;
			case 'in-progress':
				return 'play';
				break;
			case 'complete':
				return 'check';
				break;
			default:
				return 'time';
		}
	}

	/**
	 * Logs activity for this application
	 * @param  String $msg activity
	 * @return boolean      whether logging was successful
	 */
	public function log($msg) {
		return ActivityLogger::log($msg, $this->student->id, $this->id);
	}

	/**
	 * @param  int $id ID of model
	 * @return String     a link to model
	 */
	static public function getLinkFor($id) {
		$model = self::model()->findByPk($id);

		if($model) {
			$linkString = '<i class="icon-'.self::ICON_CLASS.'"></i> '.$model->university;
			return CHtml::link($linkString, array('application/view', 'id' => $id));
		}

		return null;
	}

	/**
	 * @return all unique universities in the db
	 */
	static public function getListOfUniversities() {
		$apps = Application::model()->findAll(array(
			'order' => 'university',
		));
		$arr = array();

		foreach($apps as $a) {
			if(!in_array($a->university, $arr))
				$arr[$a->university] = $a->university;
		}

		return $arr;
	}

	/**
	 * @return all unique courses in the db
	 */
	static public function getListOfCourses() {
		$apps = Application::model()->findAll(array(
			'order' => 'course',
		));
		$arr = array();

		foreach($apps as $a) {
			if(!in_array($a->course, $arr))
				$arr[$a->course] = $a->course;
		}

		return $arr;
	}

	/**
	 * Change application state based on checklist state
	 */
	public function smartlyChangeState() {
		$activeChecklist = false;
		foreach ($this->applicationTasks as $at) {
			if($at->state0 != 'not-started') {
				$activeChecklist = true;
				break;
			}
		}

		if($activeChecklist) {
			if($this->state0 != 'complete' && $this->state0 != 'in-progress') {
	            $this->state = Application::getStateId('in-progress');
	            $this->save();
			}
		}
		else {
			if($this->state0 != 'shortlisted') {
	            $this->state = Application::getStateId('shortlisted');
	            $this->save();
	        }
		}
	}
}
