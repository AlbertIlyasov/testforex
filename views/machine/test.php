<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Machine */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Test';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>
<div class="site-send">

    Example: <pre><? print_r([
            'serial' => '123456789012345',
            'time' => date('Y-m-d H:i:s'),
            'connect_freq' => '5',
            'firmware' => '1.00c',
            'set_connect_freq' => '6',
        ]) ?></pre>

    <?php $form = ActiveForm::begin(['id' => 'send-form', 'action' => Yii::$app->urlManager->createUrl(['machine/answer']),  'options' => ['target' => 'result']]); ?>

        <?= $form->field($model, 'serial') ?>

        <?= $form->field($model, 'time') ?>

        <?= $form->field($model, 'connect_freq') ?>

        <?= $form->field($model, 'firmware') ?>

        <?= $form->field($model, 'set_connect_freq') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
<div>
    Result:<p>
    <iframe name=result style="width: 100%; height: 200px;"></iframe>
</div>
