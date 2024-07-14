
<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\RegisterForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\models\RegisterForm;

$model = new RegisterForm;
$this->title = 'Aqua UMS Project';
?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>
    
    <div style="height:10vh; width:98vw;">
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821207343374417/LOGO_UMS_putih.png?ex=6684c0b4&is=66836f34&hm=af5e9a87bb0dda7b341400235baa3f8d9323dbd3c0657ee6275dae95cea2b05e&" style="max-height: 9vh;" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/home';"></span>
        <span class="header"><b>Aqua UMS Project</b></br>Kerjasama Fakulti Komputeran dan Informatik dan Institut Penyelidikan Marin Borneo</span>
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821361966387350/EcoCampus-Putih.png?ex=6684c0d9&is=66836f59&hm=0fb2dbcc577308974208e89d2c2f8e6a39d4e87ff5822c27cb66677cb01fe47b&" style="max-height: 9vh;"></span>
        
    </div>


    <div class="mainscreen" style="" id="registerwindow">
        <div class="loginwindow" style="padding-top:5px; height: auto; padding-bottom: 25px;">
            <h1>Register</h1>

                <?php $form = ActiveForm::begin([
                    'id' => 'register-form',
                    'layout' => 'horizontal',
                    'action' => ['register/register'],
                    'fieldConfig' => [
                        'template' => "<h3>{label}</h3>{input}</br></br>{error}",
                        'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                        'inputOptions' => ['class' => 'col-lg-3 form-control'],
                        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                    ],
                ]); ?>

                <?= $form->field($model, 'username')->label('Username (max 16 characters)')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password2')->label('Confirm Password')->passwordInput() ?>
                <?= $form->field($model, 'fullname')->label('Full Name')->textInput() ?>
                <?= $form->field($model, 'email')->label('E-mail')->textInput() ?>
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button', 'id' => 'registersubmit']) ?>
                <?php ActiveForm::end(); ?>
                </br>
                </br>
                <button onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/';">Back</button>
            

        </div>
    </div>
   


</body>
</html>
