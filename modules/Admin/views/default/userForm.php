<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/** @var yii\web\View $this */
/** @var app\models\User\Users $model */
/** @var yii\widgets\ActiveForm $form */

    $roles = [];

    foreach(Yii::$app->authManager->getRoles() as $role){

        $roles[$role->name] = $role->description;

    }

?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList($roles) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <input type="hidden" name="current_password" value="<?= $model->password ?>">
    <?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>