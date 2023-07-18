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
class AdminController extends Controller
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

    public function actionIndex()
    {  
        #echo DBHandler::removeAdmin(3);
        $new = [
            "tank_id" => "0",
            "ph_min" => "0",
            "ph_max" => "1",
            "do_min" => "0",
            "do_max" => "1",
            "salinity_min" => "0",
            "salinity_max" => "1",
            "ammonia_min" => "0",
            "ammonia_max" => "1",
            "nitrate_min" => "0",
            "nitrate_max" => "1",
            "turbidity_min" => "0",
            "turbidity_max" => "1",
            "temp_min" => "0",
            "temp_max" => "1",
            "depth_min" => "0",
            "depth_max" => "1",
            "cycle_length" => 60,
        ];
        #DBHandler::updateParam($new);
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == "t"){
            return $this->render("index");
        }
        else
            return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/home");

    }
    public function actionAddTank(){
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == "t"){
            $model = new TankForm();
            if ($model->load(Yii::$app->request->post()) && $model->registerTank()){
                
                return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
            }
        }
        else
            return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
    }
    public function actionAddSensor(){
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == "t"){
            $model = new SensorForm();
            if ($model->load(Yii::$app->request->post()) && $model->registerSensor()){
                return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
            }
        }
        else
            return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
    }
    public function actionUpdateParam(){

        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == "t"){
            $model = new ParamForm();
            if ($model->load(Yii::$app->request->post()) && $model->updateParams()){
                return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
            }
            return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
        }
        else {
            return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
        }
    }



    public function actionAppoint($id){
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == "t"){
            if (DBHandler::addAdmin($id)){
                return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
            }
            return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
        }
        else {
            return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
        }
    }

    public function actionRevoke($id){
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == "t"){
            if (DBHandler::removeAdmin($id)){
                return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
            }
            return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
        }
        else {
            return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
        }
    }

    public function actionDelete($id){
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == "t"){
            if (DBHandler::deleteTank($id)){
                return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
            }
            return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
        }
        else {
            return $this->redirect("http://$GLOBALS[HOSTNAME]:8080/admin");
        }
    }




}