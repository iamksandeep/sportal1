<?php

/**
 * This is the model class for table "td_activity".
 *
 * The followings are the available columns in table 'td_activity':
 * @property integer $id
 * @property integer $todo_id
 * @property string $comment
 * @property integer $log
 * @property integer $author_id
 * @property string $time
 *
 * The followings are the available model relations:
 * @property User $author
 * @property Todo $todo
 */
class TDActivity extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TDActivity the static model class
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
		return 'td_activity';
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
			array('comment', 'required', 'on' => 'add, edit'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, todo_id, comment, log, author_id, time', 'safe', 'on'=>'search'),
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
			'todo' => array(self::BELONGS_TO, 'Todo', 'todo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'todo_id' => 'Todo',
			'comment' => 'Comment',
			'log' => 'Log',
			'author_id' => 'Author',
			'time' => 'Time',
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
		$criteria->compare('todo_id',$this->todo_id);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('log',$this->log);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Do stuff before validation
	 * @return boolean parent::beforeValidate()
	 */
	protected function beforeValidate() {
		if($this->isNewRecord) {
			$this->time = new CDbExpression('NOW()');
			$this->author_id = Yii::app()->user->id;

			if($this->scenario === 'add') {
				$this->log = false;
			}
		}

		return parent::beforeValidate();
	}

	/**
	 * @return String parsed comment
	 */
	public function getParsedComment() {
		return SmartContentParser::parse($this->comment);
	}

	/**
	 * @param  int  $userId User id
	 * @return boolean         Whether a todo activity has been read by given user
	 */
	public function hasBeenReadBy($userId) {
		return (bool)(sizeof(Yii::app()->db->createCommand()
				->select()
				->from('td_activity_read')
				->where('todo_activity_id = :todo_activity_id AND user_id = :user_id', array(
					':todo_activity_id' => $this->id,
					':user_id' => $userId,
				))
				->queryAll()) == 1);
	}

	/**
	 * Marks a todo activity as read by user
	 * @param  int $userId User id who has read the msg
	 * @return boolean         Success of failurel
	 */
	public function markAsReadBy($userId) {
		if(!$this->hasBeenReadBy($userId))
			return (bool)(Yii::app()->db->createCommand()
				->insert('td_activity_read', array(
					'todo_activity_id' => $this->id,
					'user_id' => $userId,
			)) == 1);
		else
			return false;
	}
}
