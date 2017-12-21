<?php

/* @var $this yii\web\View */
/* @var $model app\models\Machines */


$this->title = 'Tables';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>
<h2>Machines->id = <?= $model->id ?></h2>
<div>
    <h2>Machines</h2>
    <pre><? print_r($model->getAttributes()) ?></pre>
</div>

<div>
    <h2>MachinesOptions</h2>
    <pre><? print_r($model->options->getAttributes()) ?></pre>
</div>

<div>
    <h2>MachinesOptionsSet</h2>
    <pre><? foreach ($model->optionsSet as $optionsSet){print_r($optionsSet->getAttributes());} ?>
    </pre>
</div>
