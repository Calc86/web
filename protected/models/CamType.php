<?php

/**
 * This is the model class for table "cam_types".
 *
 * The followings are the available columns in table 'cam_types':
 * @property integer $id
 * @property integer $vendor_id
 * @property string $name
 * @property string $live_auth
 * @property string $live_user
 * @property string $live_pass
 * @property string $live_proto
 * @property integer $live_port
 * @property string $live_path
 * @property integer $live_width
 * @property integer $live_height
 * @property string $live_audio
 * @property string $stop_auth
 * @property string $stop_user
 * @property string $stop_pass
 * @property string $stop_proto
 * @property integer $stop_port
 * @property string $stop_path
 * @property integer $stop_width
 * @property integer $stop_height
 * @property string $ispy_url
 * @property string $comment
 */
class CamType extends CActiveRecord
{
    public static $enum_live_auth = array('noauth'=>'noauth','http'=>'http');
    public static $enum_live_proto = array('http'=>'http','rtsp'=>'rtsp','rtmp'=>'rtmp');
    public static $enum_live_audio = array('No'=>'No','Yes'=>'Yes');
    public static $enum_stop_auth = array('noauth'=>'noauth','http'=>'http','ubqt'=>'ubqt','ubqt2'=>'ubqt2');
    public static $enum_stop_proto = array('http'=>'http');
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cam_types';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, live_port, live_width, live_height, stop_port, stop_width, stop_height', 'required'),
			array('vendor_id, live_port, live_width, live_height, stop_port, stop_width, stop_height', 'numerical', 'integerOnly'=>true),
			array('name, live_user, live_pass, live_path, stop_user, stop_pass, stop_path, ispy_url', 'length', 'max'=>255),
			array('live_auth, stop_auth', 'length', 'max'=>6),
			array('live_proto, stop_proto', 'length', 'max'=>4),
			array('live_audio', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vendor_id, name, live_auth, live_user, live_pass, live_proto, live_port, live_path, live_width, live_height, live_audio, stop_auth, stop_user, stop_pass, stop_proto, stop_port, stop_path, stop_width, stop_height, ispy_url, comment', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vendor_id' => 'Vendor',
			'name' => 'Name',
			'live_auth' => 'Live Auth',
			'live_user' => 'Live User',
			'live_pass' => 'Live Pass',
			'live_proto' => 'Live Proto',
			'live_port' => 'Live Port',
			'live_path' => 'Live Path',
			'live_width' => 'Live Width',
			'live_height' => 'Live Height',
			'live_audio' => 'Live Audio',
			'stop_auth' => 'Stop Auth',
			'stop_user' => 'Stop User',
			'stop_pass' => 'Stop Pass',
			'stop_proto' => 'Stop Proto',
			'stop_port' => 'Stop Port',
			'stop_path' => 'Stop Path',
			'stop_width' => 'Stop Width',
			'stop_height' => 'Stop Height',
			'ispy_url' => 'Ispy Url',
			'comment' => 'Comment',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('live_auth',$this->live_auth,true);
		$criteria->compare('live_user',$this->live_user,true);
		$criteria->compare('live_pass',$this->live_pass,true);
		$criteria->compare('live_proto',$this->live_proto,true);
		$criteria->compare('live_port',$this->live_port);
		$criteria->compare('live_path',$this->live_path,true);
		$criteria->compare('live_width',$this->live_width);
		$criteria->compare('live_height',$this->live_height);
		$criteria->compare('live_audio',$this->live_audio,true);
		$criteria->compare('stop_auth',$this->stop_auth,true);
		$criteria->compare('stop_user',$this->stop_user,true);
		$criteria->compare('stop_pass',$this->stop_pass,true);
		$criteria->compare('stop_proto',$this->stop_proto,true);
		$criteria->compare('stop_port',$this->stop_port);
		$criteria->compare('stop_path',$this->stop_path,true);
		$criteria->compare('stop_width',$this->stop_width);
		$criteria->compare('stop_height',$this->stop_height);
		$criteria->compare('ispy_url',$this->ispy_url,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CamType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
