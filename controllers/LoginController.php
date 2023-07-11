<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class LoginController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {   
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('http://$GLOBALS[HOSTNAME]:8080/home');
        }
        else 
            return $this->redirect('http://$GLOBALS[HOSTNAME]:8080/');
    }

    public function actionLogin()
    {
        
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('http://$GLOBALS[HOSTNAME]:8080/home');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('http://$GLOBALS[HOSTNAME]:8080/home');
        }

        $model->password = '';
        Yii::$app->session->setFlash('model', $model);
        return $this->redirect(Yii::$app->homeUrl);
    }
}
