
<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Order\Orders $model */

$this->title = 'Create Orders';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['/orders']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('orderForm', [
        'model' => $model,
    ]) ?>

</div>