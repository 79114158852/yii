<?php
namespace app\controllers;

use app\models\Order\Orders;
use Yii;
use yii\web\Controller;
use app\models\User\LoginForm;
use yii\helpers\Url;

class SiteController extends Controller
{
  

    /**
     * Index page
    */
    public function actionIndex(){
        $model = new Orders();
        return $this->render('orderForm', ['model' => $model]);
    }


    /**
     * Save order
    */
    public function actionSave(){
        $model = new Orders();
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', "Заказ отправлен.");
                $model->loadDefaultValues();
            } else {
                Yii::$app->session->setFlash('error', "Что-то пошло не так!");
            }
            return $this->goHome();
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
    */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Url::toRoute(['/orders']));
        }

        $model->password = '';
        return $this->render('loginForm', [
            'model' => $model,
        ]);
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->goHome();
    }

}