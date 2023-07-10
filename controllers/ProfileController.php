<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ProfileForm;
use app\models\ContactForm;

class ProfileController extends Controller
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
        if (Yii::$app->user->isGuest) {
            return $this->redirect('http://localhost:8080/');
        }
        else 
        return $this->render('profile');
    }

    public function actionUpdateUser(){
        if (Yii::$app->user->isGuest) {
            return $this->redirect('http://localhost:8080/');
        }
        else {
            $model = new ProfileForm();
            if ($model->load(Yii::$app->request->post()) && $model->updateProfile()){
                return $this->redirect('http://localhost:8080/profile');
            }
            Yii::$app->session->setFlash('model', $model);
            return $this->redirect('http://localhost:8080/profile');
        }
            
    }

}
