<?php

//require_once 'Zend/XmlRpc/Client.php';

/**
 * This is the model class for table "cams".
 *
 * The followings are the available columns in table 'cams':
 * @property integer $id
 * @property integer $zone_id
 * @property integer $user_id
 * @property string $name
 * @property integer $order
 * @property integer $type_id
 * @property integer $ip
 * @property integer $user
 * @property integer $pass
 * @property CamSettings $cs
 * @property integer $live
 * @property integer $rec
 * @property integer $mtn
 */

class Cam extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cams';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('zone_id, name', 'required'),
            array('zone_id, user_id, order, type_id', 'numerical', 'integerOnly'=>true),
            array('name, ip, user, pass', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, zone_id, user_id, name, order, type_id, ip, user, pass', 'safe', 'on'=>'search'),
            array('live','numerical',  'on'=>'live'),
            array('rec','numerical', 'on'=>'rec'),
            array('mtn','numerical', 'on'=>'mtn'),
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
            'cs'=>array(self::HAS_ONE, 'CamSettings', 'cam_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'zone_id' => 'Zone',
            'user_id' => 'User',
            'name' => 'Name',
            'order' => 'Order',
            'type_id' => 'Type',
            'ip' => 'Ip',
            'user' => 'User',
            'pass' => 'Pass',
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

        //$criteria->compare('id',$this->id);
        //$criteria->compare('zone_id',$this->zone_id);
        $criteria->compare('user_id',Yii::app()->user->id);
        //$criteria->compare('name',$this->name,true);
        //$criteria->compare('order',$this->order);
        //$criteria->compare('type_id',$this->type_id);
        //$criteria->compare('ip',$this->ip,true);
        //$criteria->compare('user',$this->user,true);
        //$criteria->compare('pass',$this->pass,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Cam the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    protected function beforeSave(){
        if(parent::beforeSave()){
            $this->user_id = Yii::app()->user->id;
            return true;
        }
        else
            return false;
    }

    protected function afterSave(){
        parent::afterSave();

        //сценарии обрабатываются внутри этого метода
        $this->toggle();

        // создать профиль настроек для камеры
        if($this->getIsNewRecord()){
            $type = CamType::model()->findByPk($this->type_id);
            $settings = new CamSettings();
            $settings->cam_id = $this->id;
            /** @noinspection PhpParamsInspection */
            $settings->setByType($type);
            $settings->save();
        }
    }

    public function snapshot(){
        $result = '';
        $rand = rand();
        $tmp = "/tmp/bb";
        if(!is_dir($tmp))
            mkdir($tmp);
        $dir = $tmp;
        $cookie = "$dir/$this->id.$rand.txt"; //cookie
        return '';
        //return buffer with image
        /*switch ($this->cs->stop_auth){
            //HTTP авторизация, обычно на камерах DLink
            case 'http':
                $url = $this->cs->stop_proto.'://'.$this->ip.':'.$this->cs->stop_port.'/'.$this->cs->stop_path;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1); // ждем 1 секунду
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERPWD, "$this->user:$this->pass");
                $result = curl_exec($ch);
                curl_close($ch);
                return $result;
            case 'ubqt':
                $url = "{$this->cs->stop_proto}://$this->ip:{$this->cs->stop_port}/login.cgi";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 1); // ждем 1 секунду
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie);
                curl_exec($ch); // get cookie

                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);    //-LH
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                    'username' => $this->user,  //-F username=$this->user
                    'password' => $this->pass,  //-F password=$this->pass
                    'uri'=>$this->cs->stop_path,//uri={$this->cs->stop_path}
                ));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //'Expect:'

                //curl -o $jpg -LH 'Expect:' -b $ck -F username=$this->user -F password=$this->pass -F uri={$this->cs->stop_path} $url
                // -o нам не нужен
                $result =curl_exec($ch);
                curl_close($ch);
                return $result;
            default:
                $url = "{$this->cs->stop_proto}://{$this->ip}/{$this->cs->stop_path}";
                $result = file_get_contents($url);
                return $result;
                break;
        }*/
    }

    public function toggle(){
        $type = $this->getScenario();

        //для лайв обрабатываем оба действия
        //value не выносим, так как может быть сценарий insert и другие
        switch($type){
            /** @noinspection PhpMissingBreakStatementInspection */
            case 'live':
                $value = $this->$type;
                $this->play('live',$value);
                //no break, stop live => stop rec!!!
            case 'rec':
                $value = $this->$type;
                $this->play('rec',$value);
                break;
        }
    }


    //один метод на 3 разных случая
    public function play($type,$on=1){
        //$type = $this->getScenario();
        //$value = $this->$type;

        //$url = 'http://10.154.28.202/rpc/vlc.php?token='.Yii::app()->user->id;
        $url = MyConfig::getLiveRPCUrl(Yii::app()->user->id);
        /*$client = new Zend_XmlRpc_Client($url);
        $rpc = $client->getProxy('rpc');*/
        /*try
        {*/
            $ret = 0;
            if($on)
                //$ret = $rpc->cam_play($this->id,$type);
                $ret = file_get_contents($url."&cid={$this->id}&pref={$type}&func=cam_play");
            else
                //$ret = $rpc->cam_stop($this->id,$type);
                $ret = file_get_contents($url."&cid={$this->id}&pref={$type}&func=cam_stop");
            echo $ret;
        /*}
        catch(Zend_XmlRpc_HttpException $e){    // Ошибки HTTP (404, etc)
            echo "Zend_XmlRpc_HttpException: ";
            echo $e->getCode();
            echo ': ';
            echo $e->getMessage();
            echo '<pre>';
            print_r($client->getLastResponse());
        }
        catch (Zend_XmlRpc_FaultException $e) { //Ошибки XML-ROC
            echo "Zend_XmlRpc_FaultException: ";
            echo $e->getCode();
            echo ': ';
            echo $e->getMessage();
            echo '<pre>';
            print_r($client->getLastResponse());
        }
        catch (Exception $e) {
            echo $url."<br>";
            echo "Exception: ";
            echo $e->getCode();
            echo ': ';
            echo $e->getMessage();
            $response = $client->getLastResponse();
            echo '<pre>';
            print_r($response);
            $httpClient = $client->getHttpClient();
            print_r($httpClient);
        }*/
    }
}
