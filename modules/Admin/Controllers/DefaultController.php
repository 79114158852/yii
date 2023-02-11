<?php

namespace app\modules\Admin\Controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User\Users;
use app\models\User\UsersSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `users` module
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function () {
                    Yii::$app->session->setFlash('error', "Недостаточно прав");
                    return $this->goHome();
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['users']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ]
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {   
        
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('userList', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        
    }

    /**
     * Display user
    */
    public function actionView($id)
    {
        return $this->render('userView', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * user Create
    */
    public function actionCreate()
    {   

        $model = new Users();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            Yii::$app->session->setFlash('error', print_r($model->errors));
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('userCreate', [
            'model' => $model,
        ]);
    }



    /**
     * Updates an existing users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id #
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate() &&  $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } 

        return $this->render('userUpdate', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id #
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Url::toRoute(['/admin']));
    }

    /**
     * Finds the users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id #
     * @return users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {   
        if (($model = Users::getById(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}