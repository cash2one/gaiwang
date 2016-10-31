<?php

/**
 * This is the model class for table "{{agent_day}}".
 *
 * The followings are the available columns in table '{{agent_day}}':
 * @property string $id
 * @property string $city_id
 * @property string $gai_money
 * @property string $machine_money
 * @property string $statistics_date
 * @property integer $create_time
 */
class AgentDay extends CActiveRecord
{
	public $name,$cash,$depth,$tree,$gai_money1,$machine_money1;			//代理统计使用
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{agent_day}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_id, gai_money, machine_money, statistics_date, create_time', 'required'),
			array('create_time', 'numerical', 'integerOnly'=>true),
			array('city_id', 'length', 'max'=>11),
			array('gai_money, machine_money, statistics_date', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, city_id, gai_money, machine_money, statistics_date, create_time', 'safe', 'on'=>'search'),
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
			'city_id' => '省市区的id',
			'gai_money' => '盖网金额',
			'machine_money' => '盖网通金额',
			'statistics_date' => '统计日期',
			'create_time' => '创建时间',
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
	 * based on the search/filter conditions.貌似没有使用了
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = "t.gai_money,t.machine_money,r.name,a.cash,r.depth,r.tree,SUM(t.gai_money) as gai_money1,SUM(t.machine_money) as machine_money1 ";
		
		if (!empty($this->statistics_date)){
			$criteria->addCondition("t.statistics_date >= ".strtotime($this->statistics_date)." and t.statistics_date <= ".strtotime($this->statistics_date)+86399);
		}
		
		$commonAcountTabel = CommonAccount::model()->tableName();
		$criteria->join = " left join gatewang.$commonAcountTabel a on a.city_id = t.city_id";
		
		$regionTable = Region::model()->tableName();
		$criteria->join.= " left join gatewang.$regionTable r on r.id = t.city_id";
		
		$criteria->group = "r.tree";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 10, //分页
            ),
            'sort' => false,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->st;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AgentDay the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * gridview显示的时候获取数据
	 */
	public static function getCity($data){
		if ($data->depth == 0) {
			$width = "20px";
		}else if ($data->depth == 1) {
			$width = "50px";
		}else if ($data->depth == 2) {
			$width = "100px";
		}else{
			$width = "160px";
		}
		$name = $data->depth == 0? $data->name:"-".$data->name;
		echo "<span style='margin-left:$width'>$name</span>";
	}
	
	/**
     * 总后台--代理管理--代理统计
     * 后台运行脚本--每天运行一次,跑昨天的数据
     * @author LC
     */
	public static function runDayTaskStaticsInfo()
	{
		$create_time = time();
		$statistics_date = strtotime(date('Y-m-d',$create_time))-86400;			//昨天的0点
		$end_time = $statistics_date+86399;										//昨天的23:59:59
		
		$source_ids = Wealth::SOURCE_ONLINE_ORDER.','.Wealth::SOURCE_LINE_CONSUME.','.Wealth::SOURCE_HOTEL_ORDER;
		$sql = "SELECT a.source_id,a.money,b.city_id,r.tree FROM {{wealth}} a LEFT JOIN {{common_account}} b on a.member_id=b.id LEFT JOIN {{region}} r ON b.city_id=r.id where a.type_id=3 and a.`owner`=0 and b.type=".CommonAccount::TYPE_AGENT;
//		$sql .= " and a.create_time>=$statistics_date and a.create_time<=$end_time";
		$sql .= " and a.source_id in($source_ids)";
		$sql .= " group by source_id,city_id";
		
		//通过city_id找到父id
		
		$query = Yii::app()->db->createCommand($sql)->query();
		$insertData = array();
		foreach($query as $row)
		{
			$region = explode('|',$row['tree']);
			foreach($region as $city)
			{
				if(!isset($insertData[$city]))
				{
					$insertData[$city] = array(
						'gai_money'=>0,
						'machine_money'=>0
					);
				}
			}
			if($row['source_id'] == Wealth::SOURCE_LINE_CONSUME)
			{
				//线下
				$insertData[$row['city_id']]['machine_money'] += $row['money'];
			}
			else
			{
				$insertData[$row['city_id']]['gai_money'] += $row['money'];
			}
			
		}
		//插入到统计表
		$tn = self::model()->tableName();
		$insert_sql = "INSERT INTO $tn(`city_id`,`gai_money`,`machine_money`,`statistics_date`,`create_time`) VALUES";
		foreach($insertData as $city_id=>$row)
		{
			$insert_sql .= "('".$city_id."','".$row['gai_money']."','".$row['machine_money']."','".$statistics_date."','".$create_time."'),";
		}
		$insert_sql = substr($insert_sql, 0, strlen($insert_sql)-1);
		$connection = Yii::app()->st;
		$connection->createCommand($insert_sql)->execute();
		echo date('Y-m-d',$statistics_date).'的代理统计脚本执行成功。'. "\n";
	}
}
