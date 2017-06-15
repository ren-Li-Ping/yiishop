<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_day_count".
 *
 * @property integer $id
 * @property string $day
 * @property integer $count
 */
class GoodsDayCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_day_count';
    }
    //一对一找商品
    public function getGoods(){
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day'], 'safe'],
            [['count'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day' => '日期',
            'count' => '商品数',
        ];
    }
}
