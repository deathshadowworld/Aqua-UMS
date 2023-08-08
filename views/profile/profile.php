
<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\models\ProfileForm;
use app\models\DBHandler;
$model = new ProfileForm;
$this->title = 'Aqua UMS Project';
?>

<!DOCTYPE html>
<html>
<head>
    <!--<link rel="stylesheet" href="https://cdn.discordapp.com/attachments/616833107965771776/1097357861010546798/styles.css">-->
    <!--<link rel="stylesheet" href="styles.css">-->
    <style>
        

    </style>
</head>
<body>
    
    <div style="height:10vh; width:98vw;">
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821207343374417/LOGO_UMS_putih.png" style="max-height: 9vh;" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/home';"></span>
        <span class="header"><b>Aqua UMS Project</b></br>Kerjasama Fakulti Komputeran dan Informatik dan Institut Penyelidikan Marin Borneo</span>
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821361966387350/EcoCampus-Putih.png" style="max-height: 9vh;"></span>
        
    </div>



    <div class="mainscreen" style="" id="profilewindow">
        <div class="loginwindow" style="padding-top:5px; height: auto; padding-bottom: 25px;">
            <h1>Update Profile</h1>
            <?php $form = ActiveForm::begin([
                    'id'=> 'profile-form',
                    'layout' => 'horizontal',
                    'action' => ['profile/update-user'],
                    'fieldConfig' => [
                        'template' => "<h3>{label}</h3>{input}</br>{error}",
                        'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                        'inputOptions' => ['class' => 'col-lg-3 form-control'],
                        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                    ],
                ]); ?>

                <?= $form-> field($model,'username')->label('Username (cannot be changed)')->textInput(['value'=>Yii::$app->user->identity->username,'readonly'=> true]) ?>
                <?= $form->field($model, 'fullname')->label('Full Name')->textInput(['value'=>Yii::$app->user->identity->fullname]) ?>
                <?= $form->field($model, 'email')->label('E-mail')->textInput(['value'=>Yii::$app->user->identity->email]) ?></br></br>
                <?= Html::submitButton('Update Profile', ['class' => 'btn btn-primary', 'name' => 'update-button', 'id' => 'updatesubmit']) ?>
                <?php ActiveForm::end(); ?>
                </br></br>
                <h3>Click Here to Change Password</h3>
                <button onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/password';">Change Password</button></br>

    </br></br><button onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/home';">Back</button>
        </div>
    </div>


    <?php $sitename = 'http://'.$GLOBALS['HOSTNAME'].':8080/admin'; ?>
    <div class="bottomleftnav" id="navbuttons">
        <?php if (DBHandler::findAdmin() == true) {echo "<div id='adminbutton' class='navicon' onclick='location.href=\"$sitename\";'>Admin</div>";} ?>
        <div id="homebutton" class="navicon" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/home';">Home</div>
        <div id="profilebutton" class="navicon" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/profile';">Profile</div>
        <div id="logoutbutton" class="logout" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/logout';">Logout</div>
    </div>
   


</body>
</html>
