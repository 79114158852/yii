<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Order\Orders $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['/orders']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

     

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'customer',
            'title:ntext',
            [
                'attribute' => 'product_id',
                'value'     => $model->product->name ?? ''
            ],
            'phone',
            [
                'attribute' => 'status_id',
                'value'     => $model->status->name ?? ''
            ],
            'price',
            'description:ntext',
            'created_at'
        ],
    ]) ?>

    <H5>История</H5>
    <?php 

        foreach($model->histories as $history){

            echo '<hr>'.date('d.m.Y H:i:s', strtotime($history->date)).': '. $history->action;

        }
    
    ?>   
    

</div>