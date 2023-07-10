
<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\models\LoginForm;
$model = new LoginForm;
$this->title = 'Aqua UMS Project';
?>

<!DOCTYPE html>
<html>
<head>

    

</head>
<body>
    
    <div style="height:10vh; width:98vw;">
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821207343374417/LOGO_UMS_putih.png" style="max-height: 9vh;"></span>
        <span class="header"><b style="font-size: 30px;">Aqua UMS Project</b></br>Kerjasama Fakulti Komputeran dan Informatik dan Institut Penyelidikan Marin Borneo</span>
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821361966387350/EcoCampus-Putih.png" style="max-height: 9vh;"></span>
        
    </div>




    <div class="mainscreen" style="display: block;" id="loginwindow">
        <div class="loginwindow" style="padding-top:50px;">
        <h1>Login</h1>
        <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'action' => ['login/login'],
        'fieldConfig' => [
            'template' => "<h3>{label}</h3>{input}</br></br>{error}",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?><a href="https://www.youtube.com">Forgot password?</a></br></br>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"offset-lg-1 col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?></br>

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button', 'id' => 'loginsubmit']) ?></br></br>
        <?php ActiveForm::end(); ?>
                <button id="registerbutton" onclick="location.href ='http://localhost:8080/register';">Register</button>
            </div>
        </div>

    
            

   
</body>
</html>
