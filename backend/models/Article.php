<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $article_category_id
 * @property integer $sort
 * @property integer $status
 * @property integer $create_time
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getCate(){
        //k=>v    k代表article的id   article_category_id代表文章分类表里面的分类id
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }


    /*public static function getCategoryOptions()
    {
        return ArrayHelper::map(ArticleCategory::find()->where(['status'=>1])->asArray()->all(),'id','name');
    }*/

    public function getEetail(){
        //echo 'aa';exit;
        //hasOne的第二个参数【k=>v】 k代表分类的主键（id） v代表文章分类在当前对象的关联id

        return $this->hasOne(Article::className(),['id'=>'article_id']);
    }
    /**


    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'intro'], 'required'],
            [['intro'], 'string'],
            [['article_category_id', 'sort', 'status', 'create_time'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名称',
            'intro' => '文章简介',
            'article_category_id' => '文章分类',
            'sort' => '文章排序',
            'status' => '文章状态',
            'create_time' => '文章创建时间',
            'content'=>'文章详情内容'
        ];
    }

    //静态附加行为
    public function behaviors(){
        return [
            'time'=>[
                'class'=>TimestampBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT=>['create_time']
                ]
            ]
        ];
    }
}
