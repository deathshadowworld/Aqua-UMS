<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\DBHandler;
use app\models\User;


class SiteController extends Controller
{
    #public function init()
    #{
    #    parent::init();
    #    User::setUsers();
    #}
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
        #echo var_dump(DBHandler::getUserIDs())."</br>";
        #echo var_dump(DBHandler::getUsernamebyID('2'))."</br>";
        #echo var_dump(DBHandler::findParam('0'))."</br>";


        if (!Yii::$app->user->isGuest) {
            return $this->redirect('http://localhost:8080/home');
        }
        else 
            return $this->render('index');
    }

    public function actionLogin()
    {        
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('http://localhost:8080/home');
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('http://localhost:8080/home');
        }
        $model->password = '';
        Yii::$app->session->setFlash('model', $model);
        return $this->redirect(Yii::$app->homeUrl);
    }
}
