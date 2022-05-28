<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SearchForm extends Model
{
    public $id;
    public $name;
    public $code;
    public $t_status;
    public $operation;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['operation'], 'safe'],
            [['id', 'name', 'code'], 'trim'],
            [['t_status'], 'default','value'=>'On']
        ];
    }

}
