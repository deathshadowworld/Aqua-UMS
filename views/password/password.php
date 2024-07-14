
<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\models\PasswordForm;
use app\models\DBHandler;

$model = new PasswordForm;
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
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821207343374417/LOGO_UMS_putih.png?ex=6684c0b4&is=66836f34&hm=af5e9a87bb0dda7b341400235baa3f8d9323dbd3c0657ee6275dae95cea2b05e&" style="max-height: 9vh;" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/home';"></span>
        <span class="header"><b>Aqua UMS Project</b></br>Kerjasama Fakulti Komputeran dan Informatik dan Institut Penyelidikan Marin Borneo</span>
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821361966387350/EcoCampus-Putih.png?ex=6684c0d9&is=66836f59&hm=0fb2dbcc577308974208e89d2c2f8e6a39d4e87ff5822c27cb66677cb01fe47b&" style="max-height: 9vh;"></span>
        
    </div>

    <div class="mainscreen" style="" id="passwordwindow">
        <h1 id="passwordnotif" style="display: none;">Password Updated. Please close this window.</h1>
        <div id="passwordmenu" class="loginwindow" style="padding-top:5px; height: auto; padding-bottom: 25px; display: block;">
            
            <h1>Reset Password</h1>
            <?php $form = ActiveForm::begin([
                'id' => 'password-form',
                'layout' => 'horizontal',
                'action' => ['password/update-password'],
                'fieldConfig' => [
                    'template' => "<h3>{label}</h3>{input}</br></br>{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

                <?= $form->field($model, 'username')->label('Username')->textInput(['value' => Yii::$app->user->identity->username, 'readonly' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password2')->label('Confirm Password')->passwordInput() ?>
                <?= Html::submitButton('Update Password', ['class' => 'btn btn-primary', 'name' => 'password-button', 'id' => 'passwordsubmit']) ?>
                <?php ActiveForm::end(); ?>
                </br></br><button onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/profile';">Back</button>
        </div>
    </div>

    <?php $sitename = 'http://' . $GLOBALS['HOSTNAME'] . ':8080/admin'; ?>
    <div class="bottomleftnav" id="navbuttons">
        <?php if (DBHandler::findAdmin() == true) {
            echo "<div id='adminbutton' class='navicon' onclick='location.href=\"$sitename\";'>Admin</div>";
        } ?>
        <div id="homebutton" class="navicon" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/home';">Home</div>
        <div id="profilebutton" class="navicon" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/profile';">Profile</div>
        <div id="logoutbutton" class="logout" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/logout';">Logout</div>
    </div>
   


</body>
</html>
