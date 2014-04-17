<?php

require_once 'Zend/XmlRpc/Client.php';

/**
 * This is the model class for table "cam_settings".
 *
 * The followings are the available columns in table 'cam_settings':
 * @property integer $id
 * @property integer $cam_id
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
 * @property integer $stream_port
 * @property integer $stream_path
 */
class CamSettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cam_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cam_id', 'required'),
			array('cam_id, live_port, live_width, live_height, stop_port, stop_width, stop_height', 'numerical', 'integerOnly'=>true),
			array('live_auth, stop_auth', 'length', 'max'=>6),
			array('live_user, live_pass, live_path, stop_user, stop_pass, stop_path', 'length', 'max'=>255),
			array('live_proto, stop_proto', 'length', 'max'=>4),
			array('live_audio', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cam_id, live_auth, live_user, live_pass, live_proto, live_port, live_path, live_width, live_height, live_audio, stop_auth, stop_user, stop_pass, stop_proto, stop_port, stop_path, stop_width, stop_height', 'safe', 'on'=>'search'),
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
            'cam'=>array(self::BELONGS_TO, 'Cam', 'cam_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cam_id' => 'Cam',
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
		$criteria->compare('cam_id',$this->cam_id);
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CamSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function setByType(CamType $type){
        //live
        $this->live_auth = $type->live_auth;
        //$this->live_user = $user;
        //$this->live_pass = $pass;

        $this->live_proto = $type->live_proto;
        $this->live_port = $type->live_port;
        $this->live_path = $type->live_path;
        $this->live_width = $type->live_width;
        $this->live_height = $type->live_height;

        $this->live_audio = $type->live_audio;

        //stop
        $this->stop_auth = $type->stop_auth;
        //$this->stop_user;
        //$this->stop_pass;

        $this->stop_proto = $type->stop_proto;
        $this->stop_port = $type->stop_port;
        $this->stop_path = $type->stop_path;
        $this->stop_width = $type->stop_width;
        $this->stop_height = $type->stop_height;
    }

    //todo: убрать 9000
    protected function afterFind(){
        $this->stream_port = 9000+$this->cam_id;
    }


    protected function afterSave(){
        parent::afterSave();

        $url = MyConfig::getLiveRPCUrl(Yii::app()->user->id);
        //$client = new Zend_XmlRpc_Client($url);
        //$rpc = $client->getProxy('rpc');
        $cid = $this->cam_id;

        /*try
        {*/
            //$rpc->cam_reload($cid);
            $ret = file_get_contents($url."&cid={$cid}&func=cam_reload");
            //echo $ret;
        /*}
        catch(Zend_XmlRpc_HttpException $e){
            echo 'ZHTTP';
            echo $e->getCode();
            echo ': ';
            echo $e->getMessage();
            echo '<pre>';
            print_r($client->getLastResponse());
        }
        catch (Zend_XmlRpc_FaultException $e) {
            echo 'ZFE';
            echo $e->getCode();
            echo ': ';
            echo $e->getMessage();
            echo '<pre>';
            print_r($client->getLastResponse());
        }
        catch(Zend_XmlRpc_Client_FaultException $e){
            echo 'ZCFE';
            echo $e->getCode();
            echo ': ';
            echo $e->getMessage();
            echo '<pre>';
            print_r($client->getLastResponse());
            exit();
        }
        catch (Exception $e) {
            echo 'E';
            echo $e->getCode();
            echo ': ';
            echo $e->getMessage();
            $response = $client->getLastResponse();
            echo '<pre>';
            print_r($response);
            $httpClient = $client->getHttpClient();
            print_r($httpClient);
            exit();
        }*/
    }
}
