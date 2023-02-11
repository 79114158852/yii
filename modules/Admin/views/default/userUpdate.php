<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User\Users $model */

$this->title = 'Update users: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('userForm', [
        'model' => $model,
    ]) ?>

</div>