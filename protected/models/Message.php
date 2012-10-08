<?php

/**
 * This is the model class for table "msg_msg".
 *
 * The followings are the available columns in table 'msg_msg':
 * @property integer $id
 * @property integer $conversation_id
 * @property integer $author_id
 * @property string $content
 * @property string $send_time
 *
 * The followings are the available model relations:
 * @property User $author
 * @property Conv $conversation
 */
class Message extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Message the static model class
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
		return 'msg_msg';
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
			array('content', 'required', 'on' => 'compose, reply'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, conversation_id, author_id, content, send_time', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'conversation' => array(self::BELONGS_TO, 'Conversation', 'conversation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'conversation_id' => 'Conversation',
			'author_id' => 'Author',
			'content' => 'Message',
			'send_time' => 'Send Time',
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
		$criteria->compare('conversation_id',$this->conversation_id);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('send_time',$this->send_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Do stuff before validating model
	 * @return boolean parent::beforeValidate()
	 */
	protected function beforeValidate() {
		if($this->isNewRecord) {
			$this->send_time = new CDbExpression('NOW()');
			$this->author_id = Yii::app()->user->id;
		}
		return parent::beforeValidate();
	}

	/**
	 * @return String parsed content
	 */
	public function getParsedContent() {
		return SmartContentParser::parse($this->content);
	}

	/**
	 * @param  int  $userId User id
	 * @return boolean         Whether a message has been read by given user
	 */
	public function hasBeenReadBy($userId) {
		return (bool)(sizeof(Yii::app()->db->createCommand()
				->select()
				->from('msg_read')
				->where('msg_id = :msg_id AND user_id = :user_id', array(
					':msg_id' => $this->id,
					':user_id' => $userId,
				))
				->queryAll()) == 1);
	}

	/**
	 * Marks a message as read by user
	 * @param  int $userId User id who has read the msg
	 * @return boolean         Success of failurel
	 */
	public function markAsReadBy($userId) {
		if(!$this->hasBeenReadBy($userId))
			return (bool)(Yii::app()->db->createCommand()
				->insert('msg_read', array(
					'msg_id' => $this->id,
					'user_id' => $userId,
			)) == 1);
		else
			return false;
	}
}
