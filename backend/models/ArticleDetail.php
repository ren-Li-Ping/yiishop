<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_detail".
 *
 * @property integer $article_id
 * @property string $content
 */
class ArticleDetail extends \yii\db\ActiveRecord
{
    //一对一   找到文章的名称
    public function getCate(){
        //echo 'aa';exit;
        //hasOne的第二个参数【k=>v】 k代表分类的主键（id） v代表文章分类在当前对象的关联id

        return $this->hasOne(Article::className(),['id'=>'article_id']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'content'], 'required'],
            [['article_id'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => '文章ID',
            'content' => '文章内容',
        ];
    }
}
