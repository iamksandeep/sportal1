<?php

/**
 * This is the model class for table "pr_academic".
 *
 * The followings are the available columns in table 'pr_academic':
 * @property integer $id
 * @property integer $student_id
 * @property integer $level
 * @property string $institution
 * @property string $board_univ
 * @property string $score
 * @property integer $year
 *
 * The followings are the available model relations:
 * @property User $student
 */
class AcademicDetail extends CActiveRecord
{
	/**
	 * @return array Application states
	 */
	static public function getLevels() {
		return array(
			0 => 'IX',
			1 => 'X',
			2 => 'XI',
			3 => 'XII',
			4 => 'Graduation',
			5 => 'Post-Graduation',
			6 => 'Diploma',
		);
	}

	/**
	 * @param  String $tate level name
	 * @return int       State id (numerical)
	 */
	static public function getLevelId($level) {
		foreach(self::getLevels() as $levelId => $levelName) {
			if($levelName === $level)
				return $levelId;
		}
		return -1;
	}

	/**
	 * @return String level of academic detail
	 */
	public function getlevel0() {
		$levels =  self::getLevels();
		return $levels[$this->level];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AcademicDetail the static model class
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
		return 'pr_academic';
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
			array('level', 'required', 'on' => 'add'),
			array('institution, board_univ, score, year', 'required'),

			// other
			array('student_id, level, year', 'numerical', 'integerOnly'=>true),
			array('institution, board_univ, score', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student_id, level, institution, board_univ, score, year', 'safe', 'on'=>'search'),
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
			'level' => 'Grade / Level',
			'level0' => 'Grade / Level',
			'institution' => 'School / College',
			'board_univ' => 'Board / University',
			'score' => 'Score',
			'year' => 'Year of Completion',
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
		$criteria->compare('level',$this->level);
		$criteria->compare('institution',$this->institution,true);
		$criteria->compare('board_univ',$this->board_univ,true);
		$criteria->compare('score',$this->score,true);
		$criteria->compare('year',$this->year);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	static public function getYearList() {
		$year = date("Y");
		$arr = array();

		// take a  few years
		for($i = $year + 3; $i >= $year - 15; $i--)
			$arr[$i] = strval($i);

		return $arr;
	}

	/**
	 * Add some default academic details under a user
	 * @param  int $userId User under which details are to be added
	 */
	static public function prepopulateUser($userId) {
		$details = array(
			'Location' => '<p><small>not-added</small></p>',
			'SAT 1' => '<p><small>not-added</small></p>',
			'SAT 2' => '<p><small>not-added</small></p>',
			'English Proficiency' => '<p><small>not-added</small></p>',
			'Fee' => '<p><strong>Tuition:</strong> <small>not-added</small>
						<br><strong>Living:</strong> <small>not-added</small></p>',
			'Scholarship' => '<p><small>not-added</small></p>',
			'University url' => '<p><small>not-added</small></p>',
			'Program url' => '<p><small>not-added</small></p>',
		);

		foreach($details as $title => $content) {
			$model = new ApplicationDetail('add');
			$model->application_id = $userId;
			$model->title = $title;
			$model->content = $content;
			$model->save();
		}
	}
}
