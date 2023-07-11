<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class HomeController extends Controller
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
            return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/");
        }
        elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Access the POST data
                $tank_id = $_POST['tank_id'];
            
                // Use the $tank_id in your server-side logic
                // ...
            
                // Send a response back to the client-side (JavaScript)
                $response = [
                    'message' => 'Data received successfully',
                    'tank_id' => $tank_id
                ];
            
                // Set the response header
                header('Content-Type: application/json');
            
                // Output the JSON-encoded response
                echo json_encode($response);
        }
        return $this->render('home');
        
    }

}
