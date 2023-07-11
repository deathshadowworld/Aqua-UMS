<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\PasswordForm;
use app\models\ContactForm;

class PasswordController extends Controller
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
            return $this->render('password');
        }
        else {
            return $this->redirect('http://$GLOBALS[HOSTNAME]:8080/');
        }
        
    }

    public function actionUpdatePassword()
    {
        
        if (Yii::$app->user->isGuest) {
            return $this->redirect('http://$GLOBALS[HOSTNAME]:8080/');
        }
        else {
            $model = new PasswordForm();
            if ($model->load(Yii::$app->request->post()) && $model->updatePassword()){
                return $this->redirect('http://$GLOBALS[HOSTNAME]:8080/profile');
            }
            Yii::$app->session->setFlash('model', $model);
            return $this->redirect('http://$GLOBALS[HOSTNAME]:8080/profile');
        }
    }

}
