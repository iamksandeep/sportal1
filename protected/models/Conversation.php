<?php

/**
 * This is the model class for table "msg_conv".
 *
 * The followings are the available columns in table 'msg_conv':
 * @property integer $id
 * @property string $subject
 * @property integer $student_id
 *
 * The followings are the available model relations:
 * @property User $student
 */
class Conversation extends CActiveRecord
{
	/**
	 * Each new conversation must have at least one additional member
	 * @var int
	 */
	public $to;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Conversation the static model class
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
		return 'msg_conv';
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
			array('subject', 'required', 'on' => 'new, new_multi'),

			// other
			array('subject', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subject, student_id', 'safe', 'on'=>'search'),
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
			'messages' => array(self::HAS_MANY, 'Message', 'conversation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subject' => 'Subject',
			'student_id' => 'Student',
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
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('student_id',$this->student_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Do stuff after saving the model
	 */
	protected function afterSave() {
		parent::afterSave();

		// If this is a new conversation
		// Add the current app user as a member
		// of this conversation
		if($this->getScenario() == 'new' || $this->getScenario() == 'new_multi')
			$this->addMember(Yii::app()->user->id);
		if($this->getScenario() == 'new')
			$this->addMember($this->to);
	}

	/**
	 * Add a member to the conversation
	 * @param int  $userId User id to add
	 * @return boolean         Whether addition was successful
	 */
	public function addMember($userId) {
		return Yii::app()->db->createCommand()
			->insert('msg_conv_member', array(
				'conv_id' => $this->id,
				'user_id' => $userId,
			));
	}

	/**
	 * @param  int  $userId User id to check for membership
	 * @return boolean         Whether given user is a part of this conversation
	 */
	public function hasMember($userId) {
		$members = Yii::app()->db->createCommand()
				->select()
				->from('msg_conv_member')
				->where('conv_id = :conv_id AND user_id = :user_id', array(
							':conv_id' => $this->id,
							':user_id' => $userId,
						))
				->queryAll();

		return (bool)(sizeof($members) == 1);
	}

	/**
	 * @return Array all members of this conversation
	 */
	public function getMembers() {
		return Yii::app()->db->createCommand()
				->select()
				->from('msg_conv_member')
				->where('conv_id = :conv_id', array(
							':conv_id' => $this->id,
						))
				->queryAll();
	}

	/**
	 * Marks all messages in this conv
	 * as read by current app user
	 */
	public function markAsRead() {
		foreach($this->messages as $msg)
			$msg->markAsReadBy(Yii::app()->user->id);
	}
}
