<?php
namespace app\models;

use yii\db\ActiveRecord;

class Supplier extends ActiveRecord
{
    /**
     * @return string Active Record 类关联的数据库表名称
     */
    public static function tableName()
    {
        return '{{supplier}}';
    }
    
}