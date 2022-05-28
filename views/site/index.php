<?php

/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
 
?>
<div class="site-index">
    <div class="body-content">
        <div class="alert alert-primary hide" role="alert">
            export process start. please wait for the file
        </div>
        <?php $form = ActiveForm::begin([
            'id' => 'search-form',
            'method' => 'get',
            'action' => '/',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-4',
                    'offset' => 'col-sm-offset-4',
                    'wrapper' => 'col-sm-8',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]);?>
        <div class="row">
            <div class="col-2">
                <?= $form->field($model, 'operation')->label('Id')->dropDownList([">" => ">", "<" => "<",">=" => ">=", "<=" => "<="], ['prompt' => '']) ?>
            </div>
            <div class="col-1">
                <?= $form->field($model, 'id')->label(false) ?>
            </div>
            <div class="col-2">
                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-2">
                <?= $form->field($model, 'code') ?>
            </div>
            <div class="col-2">
                <?= $form->field($model, 't_status')->label("status")->dropDownList(["Ok" => "Ok", "Hold" => "Hold"], ['prompt' => 'choose']) ?>
            </div>
            <div class="col-1">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'name' => 'search']) ?>
            </div>
            <div class="col-1">
                <?= Html::resetButton('Reset', ['class' => 'btn', 'name' => 'Reset']) ?>
            </div>
            <div class="col-1">
                <?= Html::button('export', ['class' => 'btn btn-dark hide', 'name' => 'export', 'onclick' => 'download();']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <div class="row">
            <div id="select-msg" class="col-lg-12 hide">all 10 items on this page have selected. <a href="javascript:void(0)" onclick="selectAll();">Select all items match this search</a></div>
            <div id="select-msg2" class="col-lg-12 hide">all items in this search have been selected. <a href="javascript:void(0)" onclick="cleanAll();">clean selection</a></div>
        </div>
        <div class="row">
            <div class="col-lg-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => '',
                        'format' => ['raw'],
                        'label' => "all/reserve",
                        'headerOptions' => ['width' => '50','style'=>'cursor:pointer'],
                        'contentOptions' => ['align'=>'center'],
                        'header'=>"<b title='all' id='all-check'>all</b>/<b title='reserve' id='reverse-check'>reserve</b>",
                        'value' => function ($data) {
                            return "<input type='checkbox' class='i-checks' value={$data['id']}>";
                        },
                    ],
                    'id',
                    'name',
                    'code',
                    [
                        'label' =>  'status',
                        'attribute' =>  't_status'
                    ],
                ],
            ]) ?>
            </div>
        </div>

    </div>
</div>