
<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User\Users $model */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('userForm', [
        'model' => $model,
    ]) ?>

</div>