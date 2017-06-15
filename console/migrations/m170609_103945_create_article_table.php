<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170609_103945_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
//            name	varchar(50)	名称
            'name'=>$this->string(50)->comment('文章名称')->notNull(),
//            intro	text	简介
            'intro'=>$this->text()->comment('文章简介')->notNull(),
//            article_category_id	int()	文章分类id
            'article_category_id'=>$this->integer()->comment('文章分类ID'),
//            sort	int(11)	排序
            'sort'=>$this->integer()->comment('文章排序'),
//            status	int(2)	状态(-1删除 0隐藏 1正常)
            'status'=>$this->integer()->comment('文章状态'),
//            create_time	int(11)	创建时间
            'create_time'=>$this->integer()->comment('文章创建时间')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
