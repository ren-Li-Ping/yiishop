<?php

namespace backend\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $create_time
 *
 */
class Goods extends \yii\db\ActiveRecord
{
    //状态选择
    static public $statusOptions=[1=>'在售',0=>'下架'];
    static public $is_on_saleOptions=[1=>'正常',0=>'回收站'];

    //一对一，找商品分类
    public function getGoods_category(){
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }

    //一对一找商品品牌
    public function getBrand(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }




    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sn', 'goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'create_time'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '货号',
            'logo' => 'LOGO',
            'goods_category_id' => '商品分类',
            'brand_id' => '商品品牌分类',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'is_on_sale' => '是否在售',
            'status' => '状态',
            'sort' => '排序',
            'create_time' => '添加时间',
        ];
    }

}
