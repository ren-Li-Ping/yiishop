<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_detail`.
 */
class m170609_145108_create_article_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_detail', [
//            article_id	primaryKey	文章id
            'article_id'=>$this->integer()->comment('文章ID')->notNull()->primaryKey(),
//            content	text	简介
            'content'=>$this->text()->comment('文章内容')->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_detail');
    }
}
