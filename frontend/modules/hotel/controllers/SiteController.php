<?php

/**
 * 酒店预定控制器
 * @author wencong.lin <183482670@qq.com>
 */
class SiteController extends Controller {

    public function actions() {
        return array(
            'selectLanguage' => array('class' => 'CommonAction','method'=>'selectLanguage'),
        );
    }

    public function beforeAction($action) {
        //设置seo
        $seo = $this->getConfig('seo');
        $this->pageTitle = $seo['hotelTitle'];
        $this->keywords = $seo['hotelKeyword'];
        $this->description = $seo['hotelDescription'];

        return parent::beforeAction($action);
    }

    /**
     * 酒店首页
     */
    public function actionIndex() {
        $args = $this->_standardRequestParams();
        $params = Tool::requestParamsDispose($args);
        $query = array(
            'select' => 'h.id, h.name, l.name as level_name, h.thumbnail, h.parking_lot, h.pickup_service, p.name as province_name, c.name as city_name, h.street, h.lng, h.lat, h.comments, h.total_score, h.min_price, h.sort',
            'from' => '{{hotel}} as h',
            'join' => '
                LEFT JOIN `{{hotel_level}}` as `l` ON `h`.`level_id` = `l`.`id`
                LEFT JOIN `{{region}}` as `p` ON `h`.`province_id` = `p`.`id`
                LEFT JOIN `{{region}}` as `c` ON `h`.`city_id` = `c`.`id`
            ',
            'where' => 'h.status = :status',
            'order' => 'h.sort DESC, h.min_price ASC',
            'params' => array(':status' => Hotel::STATUS_PUBLISH),
        );
        $this->_buildQuery($query, $params);
        $result = Yii::app()->db->createCommand($query)->query();
        $pages = new CPagination($result->rowCount);
        $pages->pageSize = 3;
        $query['offset'] = $pages->getOffset();
        $query['limit'] = $pages->getLimit();
        $hotels = Yii::app()->db->createCommand($query)->queryAll();
        if (!empty($hotels)) {
            $ids = array();
            foreach ($hotels as $k => $h) {
                $ids[$k] = $h['id'];
            }
            $data = Hotel::getRooms($ids);
            $rooms = ArrayHelper::dataGroupByKey($data, 'hotel_id');
            $hotels = ArrayHelper::partDataMerge($hotels, $rooms, 'id', 'rooms');
        }
        $hotHotel = Hotel::getHotelByHot(); // 热门酒店
        $newHotel = Hotel::getHotelByNew(); // 最新上线酒店
        $region = Region::getHotelCityPinyin();
        $city = array();
        foreach ($region as $v){
            $city[] = $v['name'].'|'.$v['allPy'].'|'.$v['head'];
        }
        $this->render('index', array('hotHotel' => $hotHotel, 'newHotel' => $newHotel, 'hotels' => $hotels, 'pages' => $pages, 'params' => $params,'city'=>$city));
    }

    /**
     * 构建查询规范
     * @param array $query 查询规范
     * @param array $params 请求后处理的参数
     * @return array
     */
    private function _buildQuery(&$query, $params) {
        if (!empty($params))
        {
            $criteria = new CDbCriteria();
            // 酒店地区查询条件
            if ($params['city'] != '') {
                $cityId = $this->_findCityId($params['city']);
                if ($cityId > 0) {
                    $criteria->compare('h.city_id', $cityId);
                }
            }
            // 酒店名称查询条件
            if ($params['name'] != '') {
                $criteria->compare('h.name', $params['name'], true);
            }
            // 酒店积分区间查询条件
            $min_price = (int) $params['min'];
            $max_price = (int) $params['max'];
            if ($max_price != '' && $max_price > $min_price)
            {
                $typeId = Yii::app()->user->getState('typeId');
                $typeId = isset($typeId) ? $typeId : 1;
                $min_price = Common::reverseSingle($min_price, $typeId);
                $max_price = Common::reverseSingle($max_price, $typeId);
                $criteria->addBetweenCondition('h.min_price', $min_price, $max_price);
            }
            // 酒店星级查询条件
            if (is_numeric($params['level']) && $params['level'] > 0) {
                $criteria->compare('h.level_id', $params['level']);
            }
            // 酒店热点查询条件
            if (is_numeric($params['address']) && $params['address'] > 0) {
                $criteria->compare('h.address_id', $params['address']);
            }
            // 排序
            if ($params['hot'] || $params['new']) {
                if (is_numeric($params['hot']) && $params['hot'] == 1) {
                    $criteria->order = 'h.comments DESC';
                }
                if (is_numeric($params['new']) && $params['new'] == 1) {
                    $criteria->order .= $criteria->order != '' ? ', h.create_time DESC' : 'h.create_time DESC';
                }
            }else {
                $sort = Tool::findSortValue($this->_standardRequestParams(), $params['order']);
                $criteria->order = $sort != '' ? $sort : '';
            }
            $query['where'] .= $criteria->condition != '' ? (' AND ' . $criteria->condition) : '';
            $query['params'] = array_merge($query['params'], $criteria->params);
            $query['order'] = $criteria->order != '' ? $criteria->order : $query['order'];
        }
    }

    /**
     * 定义规范请求参数
     * @return array    返回规范参数
     */
    protected function _standardRequestParams()
    {
        return array(
            'city' => '',
            'name' => '',
            'min' => '',
            'max' => '',
            'level' => 0,
            'address' => 0,
            'order' => array(
                'score' => array(
                    'text' => Yii::t('hotelSite', '评论'),
                    'defaultValue' => 1,
                    1 => 'h.total_score DESC',
                ),
                'integral' => array(
                    'defaultValue' => 3,
                    'text' => Yii::t('hotelSite', '积分'),
                    2 => 'h.min_price ASC',
                    3 => 'h.max_price DESC',
                ),
            ),
            'hot' => 0,
            'new' => 0,
        );
    }

    /**
     * 通过城市查找地区ID
     * @param string $str
     * @return int
     */
    private function _findCityId($str)
    {
        $id = 0;
        if ($str != '')
        {
            $arr = array('北京', '天津', '上海', '重庆', '内蒙古', '新疆', '西藏', '广西', '宁夏');
            $arr2 = array('北京市', '天津市', '上海市', '重庆市', '内蒙古自治区', '新疆维吾尔自治区', '西藏自治区', '广西壮族自治区', '宁夏回族自治区');
            $city = str_replace($arr, $arr2, $str);
            $sql = "SELECT id FROM {{region}} WHERE `depth` = 2 AND `name` LIKE '%" . addslashes($city) . "%'";
            $id = yii::app()->db->createCommand($sql)->queryScalar();
        }
        return (int) $id;
    }

    /**
     * 查看酒店
     * @param integer $id 酒店ID
     * @throws CHttpException
     */
    public function actionView($id) {

        // AJAX 请求
        if ($this->isAjax() && $_GET['ajax'] == 'commentLists') {
            // 酒店相关评论
            $comments = HotelOrder::getComment($id, 3);
            $this->renderPartial('_comments', array('dataProvider' => $comments));
            Yii::app()->end();
        }

        // 查询酒店信息
        $hotel = Yii::app()->db->createCommand()
            ->select('h.id, h.thumbnail, h.name, l.name as level_name, p.name as province_name, c.name as city_name, h.street, h.parking_lot, h.pickup_service, h.min_price, h.comments, h.total_score, h.content, h.lng, h.lat')
            ->from('{{hotel}} as h')
            ->leftJoin('{{hotel_level}} as l', 'h.level_id = l.id')
            ->leftJoin('{{region}} as p', 'h.province_id = p.id')
            ->leftJoin('{{region}} as c', 'h.city_id = c.id')
            ->where('status = :status AND h.id = :hid', array(':status' => Hotel::STATUS_PUBLISH, ':hid' => $id))
            ->queryRow();

        // 没有查询到相关酒店，则抛出异常
        if (empty($hotel)) {
            throw new CHttpException(404, Yii::t('hotelSite', "访问出错！"));
        }

        // 客房
        $rooms = $this->_getHotelRooms($id);
        $comments = HotelOrder::getComment($id, 3);
        $pictures = HotelPicture::getPictures($hotel['id'], HotelPicture::TYPE_HOTEL);
        $this->pageTitle = $hotel['name'] . '_' . $this->pageTitle;
        $this->render('view', array('hotel' => $hotel, 'rooms' => $rooms, 'comments' => $comments, 'pictures' => $pictures));
    }

    /**
     * 获取酒店所有客房
     * @param integer $id 酒店ID
     * @return CActiveDataProvider
     */
    private function _getHotelRooms($id) {
        $criteria = new CDbCriteria;
        $criteria->select = 'id, name, breadfast, bed, network, unit_price, estimate_back_credits, activities_start, activities_end, activities_price, content';
        $criteria->condition = 'status = :status AND hotel_id = :hid';
        $criteria->params = array(':status' => HotelRoom::STATUS_PUBLISH, ':hid' => $id);
        $criteria->order = 'sort DESC, unit_price DESC';
        $criteria->with = array('pictures' => array('select' => 'path'));
        return new CActiveDataProvider('HotelRoom', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30, // 不做限制，一般酒店客房不多
            ),
        ));
    }

    public function actionError() {
        $this->layout = 'main';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}

