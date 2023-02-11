<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Order\Orders $model */

$this->title = 'Update Orders: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['/orders']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="orders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('orderForm', [
        'model' => $model,
    ]) ?>

</div>