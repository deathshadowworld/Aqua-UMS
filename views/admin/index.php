
<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\models\TankForm;
use app\models\SensorForm;
use app\models\DBHandler;
use app\models\ParamForm;

$pmodel = new ParamForm;
$smodel = new SensorForm;
$model = new TankForm;
$this->title = 'Aqua UMS Project';
$tanklist = DBHandler::getTank();
$nonadminlist = DBHandler::getNonAdmins();
$adminlist = DBHandler::getAdmins();


$request = Yii::$app->request->get('tank_id');

foreach ($tanklist as $each){
    if ($each['id'] == $request){
        $request = $each;
        break;
    }
}

$tank = $request ? $request : $tanklist['0'];
$id = $tank['id'];
$tankparam = DBHandler::findParam($id);

$currenttank = $tank;
$user = Yii::$app->user->identity;

$s_options = [];

foreach ($tanklist as $each){
    $s_options[$each['id']] = $each['name'];
}

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
        <span class="header"><b style="font-size: 30px;">Aqua UMS Project</b></br>Kerjasama Fakulti Komputeran dan Informatik dan Institut Penyelidikan Marin Borneo</span>
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821361966387350/EcoCampus-Putih.png" style="max-height: 9vh;"></span>
        
    </div>


    <div class="mainscreen" style="padding: 0;" id="adminwindow">
        
        <h1>Admin Panel</h1>
        <div class="admin-container">
            <div class="admin-item bordered admin-select">
                Appoint Admin</br></br>
                <ul>
                    <?php
                    foreach ($nonadminlist as $each){
                        echo "<li>ID: ".$each['id']." | ".$each['fullname']."</br><button id='bt_appoint".$each['id']."' onclick=\"location.href ='http://$GLOBALS[HOSTNAME]:8080/admin/appoint/".$each['id']."';\">Appoint ".$each['fullname']."</button></li></br>";
                    }
                    ?>

                </ul>
            </div>
            
            <div class="admin-item bordered">Add Tank</br></br>
                <?php $form = ActiveForm::begin([
                    'id'=> 'tank-form',
                    'layout' => 'horizontal',
                    'action' => ['admin/add-tank'],
                    'fieldConfig' => [
                        'template' => "{label}{input}</br>{error}",
                        'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                        'inputOptions' => ['class' => 'col-lg-3 form-control'],
                        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                    ],
                ]); 
                ?>
                <?= $form->field($model, 'name')->label('Tank Name')->textInput() ?>
                <?= $form->field($model, 'desc')->label('Description')->textInput() ?>
                <?= $form->field($model, 'location')->label('Location')->textInput() ?></br>
                <?= Html::submitButton('Add Tank', ['class' => 'btn btn-primary', 'name' => 'addtank-button', 'id' => 'addtank']) ?>
                <?php ActiveForm::end(); ?>
            </div>



            <div class="admin-item bordered admin-picker">
                Update Tank</br></br>
                <select style="width: 200px; position: absolute; right: 120px;" id='sel_picktank'>
                <?php
                    foreach ($tanklist as $each){
                        echo "<option value='".$each['id']."'>".$each['name']."</option>";
                    }
                ?>
                </select>
                <script>
                const tankOption = document.getElementById('sel_picktank');
                tankOption.value = <?= $tank['id'] ?>;
                tankOption.addEventListener('change', function() {
                    const selectTankId = tankOption.value;
                    location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/admin?tank_id='+selectTankId;
                });

            </script>
            </br></br>
            Description: <?= $currenttank['desc'] ?></br>
                Location: <?= $currenttank['location'] ?></br></br>
                <?= Html::submitButton('Update All Parameters', ['class' => 'btn btn-primary', 'name' => 'updateparam-button', 'id' => 'updateparam','form'=>'param-form']) ?>
                </br></br><button id="bt_removetank" onclick="confirmRemove()">Delete Tank</button>
                <script>
                    function confirmRemove(){
                        if (confirm("Delete tank? This will also delete all messages, parameter, logs, and sensors related to this tank.") == true){
                            location.href ="http://<?= $GLOBALS['HOSTNAME'] ?>:8080/admin/delete/<?= $id?>";
                        }
                    }
                </script>
            </div>



            <div class="admin-item bordered">Add Sensor</br></br>
            <?php $form = ActiveForm::begin([
                    'id'=> 'sensor-form',
                    'layout' => 'horizontal',
                    'action' => ['admin/add-sensor'],
                    'fieldConfig' => [
                        'template' => "{label}{input}</br>{error}",
                        'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                        'inputOptions' => ['class' => 'col-lg-3 form-control'],
                        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                    ],
                ]); 
                ?>
                <?= $form->field($smodel, 'name')->label('Sensor Name')->textInput() ?>
                <?= $form->field($smodel, 'type')->label('Sensor Type')->dropdownList(
                    ['0'=>'Fish Tank Sensor','1'=>'Biofilter Sensor','2'=>'Other'],['prompt' => 'Select Type','style' => 'width: 175px;']
                ) ?>
                <?= $form->field($smodel, 'tank')->label('For Tank')->dropDownList($s_options, ['prompt' => 'Select Tank','style' => 'width: 175px;']) ?> </br>
                <?= Html::submitButton('Add Sensor', ['class' => 'btn btn-primary', 'name' => 'addsensor-button', 'id' => 'addsensor']) ?>
            <?php ActiveForm::end(); ?>
            </div>


            <div class="admin-item bordered admin-select">
                Revoke Admin</br></br>
                <ul>
                <?php
                    foreach ($adminlist as $each){
                        $id_self = '';
                        if (Yii::$app->user->identity->id == $each['id']){
                            $id_self = ' (Yourself)';
                        }
                        echo "<li>ID: ".$each['id']." | ".$each['fullname'].$id_self."</br><button id='bt_revoke".$each['id']."' onclick=\"location.href ='http://$GLOBALS[HOSTNAME]:8080/admin/revoke/".$each['id']."';\">Revoke ".$each['fullname'].$id_self."</button></li></br>";
                    }

                    ?>
                    
                </ul>

            </div>

            
            <div class="admin-item bordered">pH Level</br></br>
            <?php $form = ActiveForm::begin([
                    'id'=> 'param-form',
                    'layout' => 'horizontal',
                    'action' => ['admin/update-param'],
                    'fieldConfig' => [
                        'template' => "{label}{input}</br>{error}",
                        'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                        'inputOptions' => ['class' => 'col-lg-3 form-control'],
                        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                    ],
                ]);
                $pmodel->tank_id = $tankparam['tank_id']; 
                
                ?>
                <?= $form->field($pmodel, 'ph_min')->label('Minimum Value')->textInput(['value' => $tankparam['ph_min']]) ?>
                <?= $form->field($pmodel, 'ph_max')->label('Maximum Value')->textInput(['value' => $tankparam['ph_max']]) ?>
            </div>
            <div class="admin-item bordered">Dissolved Oxygen</br></br>
                <?= $form->field($pmodel, 'do_min')->label('Minimum Value')->textInput(['value' => $tankparam['do_min']]) ?>
                <?= $form->field($pmodel, 'do_max')->label('Maximum Value')->textInput(['value' => $tankparam['do_max']]) ?>
            </div>
            <div class="admin-item bordered">Salinity</br></br>
                <?= $form->field($pmodel, 'salinity_min')->label('Minimum Value')->textInput(['value' => $tankparam['salinity_min']]) ?>
                <?= $form->field($pmodel, 'salinity_max')->label('Maximum Value')->textInput(['value' => $tankparam['salinity_max']]) ?>
            </div>
            <div class="admin-item bordered">Ammonia</br></br>
                <?= $form->field($pmodel, 'ammonia_min')->label('Minimum Value')->textInput(['value' => $tankparam['ammonia_min']]) ?>
                <?= $form->field($pmodel, 'ammonia_max')->label('Maximum Value')->textInput(['value' => $tankparam['ammonia_max']]) ?>
            </div>
            <div class="admin-item bordered">Nitrate</br></br>
                <?= $form->field($pmodel, 'nitrate_min')->label('Minimum Value')->textInput(['value' => $tankparam['nitrate_min']]) ?>
                <?= $form->field($pmodel, 'nitrate_max')->label('Maximum Value')->textInput(['value' => $tankparam['nitrate_max']]) ?>
            </div>
            <div class="admin-item bordered">Turbidity</br></br>
                <?= $form->field($pmodel, 'turbidity_min')->label('Minimum Value')->textInput(['value' => $tankparam['turbidity_min']]) ?>
                <?= $form->field($pmodel, 'turbidity_max')->label('Maximum Value')->textInput(['value' => $tankparam['turbidity_max']]) ?>
            </div>
            <div class="admin-item bordered">Temperature</br></br>
                <?= $form->field($pmodel, 'temp_min')->label('Minimum Value')->textInput(['value' => $tankparam['temp_min']]) ?>
                <?= $form->field($pmodel, 'temp_max')->label('Maximum Value')->textInput(['value' => $tankparam['temp_max']]) ?>
            </div>
            <div class="admin-item bordered">Depth Level</br></br>
                <?= $form->field($pmodel, 'depth_min')->label('Minimum Value')->textInput(['value' => $tankparam['depth_min']]) ?>
                <?= $form->field($pmodel, 'depth_max')->label('Maximum Value')->textInput(['value' => $tankparam['depth_max']]) ?>
                <?= $form->field($pmodel, 'tank_id', ['template' => '{input}'])->hiddenInput(['value' => $tankparam['tank_id']])->label(false) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
        
            


    </div>  



    <div class="bottomleftnav" id="navbuttons">
        <div id="adminbutton" class="navicon" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/admin';">Admin</div>
        <div id="homebutton" class="navicon" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/home';">Home</div>
        <div id="profilebutton" class="navicon" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/profile';">Profile</div>
        <div id="logoutbutton" class="logout" onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/logout';">Logout</div>
    </div>
   
</body>
</html>
