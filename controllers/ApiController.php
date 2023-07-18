<?php

namespace app\controllers;

use app\models\TankForm;
use app\models\SensorForm;
use app\models\ParamForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\models\DBHandler;
class ApiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            "access" => [
                "class" => AccessControl::className(),
                "only" => ["logout"],
                "rules" => [
                    [
                        "actions" => ["logout"],
                        "allow" => true,
                        "roles" => ["@"],
                    ],
                ],
            ],
            "verbs" => [
                "class" => VerbFilter::className(),
                "actions" => [
                    "logout" => ["post"],
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
            "error" => [
                "class" => "yii\web\ErrorAction",
            ],
            "captcha" => [
                "class" => "yii\captcha\CaptchaAction",
                "fixedVerifyCode" => YII_ENV_TEST ? "testme" : null,
            ],
        ];
    }

    public function actionAddSensor(){
        if ($_GET != null){
            if (DBHandler::findAdminbyID($_GET['id'])){
                $array = [
                    'tank' => $_GET['tank_id'],
                    'name' => $_GET['name'],
                    'type' => $_GET['type'],
                    'user' => $_GET['id']
                ];
                try{
                    $s = DBHandler::addSensor($array);
                    return $s;
                }
                catch (Exception $e){
                    return $e->message;
                }
            }
            else {
                return "<Response [400]>";
            }
        }
        return "<Response [500]>";
    }

    public function actionAddLog(){
        if ($_GET != null){
            if (DBHandler::findAdminbyID($_GET['id'])){
                $array = [
                    'sensor_id'=>$_GET['sensor_id'],
                    'datetime' => $_GET['datetime'],
                    'ph' => $_GET['ph'],
                    'do' => $_GET['do'],
                    'sal' => $_GET['sal'],
                    'amm' => $_GET['amm'],
                    'nit' => $_GET['nit'],
                    'tur' => $_GET['tur'],
                    'temp' => $_GET['temp'],
                    'dep' => $_GET['dep'],
                    'type' => $_GET['type'],
                    'user' => $_GET['id']
                ];
                try{
                    DBHandler::addLog($array);
                    return "<Response [200]>";
                }
                catch (Exception $e){
                    return $e->message;
                }
            }
            else {
                return "<Response [400]>";
            }
        }    
        return "<Response [500]>";
}




}