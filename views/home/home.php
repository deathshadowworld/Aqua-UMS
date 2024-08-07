<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use app\models\DBHandler;



$this->title = 'Aqua UMS Project';
$tanklist = DBHandler::getTank();
$request = Yii::$app->request->get('tank_id');

foreach ($tanklist as $each) {
    if ($each['id'] == $request) {
        $request = $each;
        break;
    }
}

$tank = $request ? $request : $tanklist['0'];
$id = $tank['id'];
$status = false;

try {

    $loglist = DBHandler::findSensorLogs($id);
    $sensorlist = $loglist['sensor_ids'];
    unset($loglist['sensor_ids']);
    $sensor1 = $loglist[0];
    $sensor2 = 0;

    if (count($sensorlist) == 2) {
        $sensor_info1 = DBHandler::findSensor($sensorlist[0]['sensor_id']);
        $sensor_info2 = DBHandler::findSensor($sensorlist[1]['sensor_id']);
        $sensor2 = $loglist[1];
    } elseif (count($sensorlist) == 1) {
        $sensor_info1 = DBHandler::findSensor($sensorlist[0]['sensor_id']);
        $sensor_info2 = DBHandler::findSensor($sensorlist[0]['sensor_id']);
        $sensor2 = $loglist[0];
    } else {
        throw new Exception("Sensor not found");
    }


    #if ($id != '0'){
#    $sensor2 = $loglist[0];
#}else {
#    $sensor2 = $loglist[1];
#}

    $type1 = array();
    foreach ($sensor1 as $each) {
        $type1[$each['time_taken']] = [
            'ph' => $each['ph'],
            'do' => strval(intval($each['do']) / 100),
            'salinity' => $each['salinity'],
            'ammonia' => $each['ammonia'],
            'nitrate' => $each['nitrate'],
            'turbidity' => $each['turbidity'],
            'temp' => $each['temp'],
            'depth' => $each['depth'],
            'type' => $each['type'],
        ];
    }

    $type2 = array();
    foreach ($sensor2 as $each) {
        $type2[$each['time_taken']] = [
            'ph' => $each['ph'],
            'do' => strval(intval($each['do']) / 100),
            'salinity' => $each['salinity'],
            'ammonia' => $each['ammonia'],
            'nitrate' => $each['nitrate'],
            'turbidity' => $each['turbidity'],
            'temp' => $each['temp'],
            'depth' => $each['depth'],
            'type' => $each['type'],
        ];
    }

    $keytype1 = array_keys($type1);
    $keytype2 = array_keys($type2);
    $dep1 = array_column($type1, 'depth');
    $dep2 = array_column($type2, 'depth');
    $dep1 = end($dep1);
    $dep2 = end($dep2);
    if (count($keytype1) < 2) {
        echo "Tank only has one sensor, therefore the chart is merged.";
        $status = false;
    } else {
        $status = true;
    }
    $tank_param = DBHandler::findTankParam($id);


} catch (Exception $e) {
    echo "Tank has no sensors or logged data, therefore no data to be displayed. Error 03";
}
$message = DBHandler::sortedMessages($id);

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
    <div class="desktop-view">
        <div style="height:10vh; width:98vw;">
            <span class="header"><img src="https://i.imgur.com/I5pJoVM.png" style="max-height: 9vh;"
                    onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/home';"></span>
            <span class="header"><b>Aqua UMS Project</b></br>Kerjasama Fakulti Komputeran dan Informatik dan Institut
                Penyelidikan Marin Borneo</span>
            <span class="header"><img
                    src="https://i.imgur.com/jaqebAU.png"
                    style="max-height: 9vh;"></span>
        </div>
        <div class="" style="" id="monitorwindow">
            <div class="grid-container" style=" margin-bottom: 50px;">
                <div class="grid-item"></div>

                <div class="grid-item widget mini-widget" id="phdiv" style="border-color:<?php if ($status == true && (end($type1)['ph'] >= $tank_param['ph_min'] && end($type1)['ph'] <= $tank_param['ph_max']) && (end($type2)['ph'] >= $tank_param['ph_min'] && end($type2)['ph'] <= $tank_param['ph_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;">pH Level<canvas id="cv_ph"></canvas></div>
                <div class="grid-item widget main-widget" style="position: relative;" id="scorediv">Water Quality Score
                    <canvas id="mainChart" style="max-height: 450px;"></canvas>
                    <span class="scoreleft" id="mainleft"><?= $sensor_info1['name'] ?></br><b
                            style="font-size: 40px;">N/A%</b></span>
                    <span class="scoreright" id="mainright"><?= $sensor_info2['name'] ?></br><b
                            style="font-size: 40px;">N/A%</b></span>
                </div>
                <div class="grid-item widget mini-widget" id="dodiv" style="border-color:<?php if ($status == true && (end($type1)['do'] >= $tank_param['do_min'] && end($type1)['do'] <= $tank_param['do_max']) && (end($type2)['do'] >= $tank_param['do_min'] && end($type2)['do'] <= $tank_param['do_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;">Dissolved Oxygen<canvas id="cv_do"></canvas></div>
                <div class="grid-item widget mini-widget " id="sadiv" style="border-color:<?php if ($status == true && (end($type1)['salinity'] >= $tank_param['salinity_min'] && end($type1)['salinity'] <= $tank_param['salinity_max']) && (end($type2)['salinity'] >= $tank_param['salinity_min'] && end($type2)['salinity'] <= $tank_param['salinity_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;">Salinity<canvas id="cv_sal"></canvas></div>
                <div class="grid-item small-widget widget" id="depthtankdiv" style="border-color:<?php if ($status == true && (end($type1)['depth'] >= $tank_param['depth_min'] && end($type1)['depth'] <= $tank_param['depth_max']) && (end($type2)['depth'] >= $tank_param['depth_min'] && end($type2)['depth'] <= $tank_param['depth_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;"><?= $sensor_info1['name'] ?> Depth<canvas id="cv_bar1" style="max-height: 250px;"></canvas></div>
                <div class="grid-item small-widget widget" id="depthfilterdiv" style="border-color:<?php if (($status == true && end($type1)['depth'] >= $tank_param['depth_min'] && end($type1)['depth'] <= $tank_param['depth_max']) && (end($type2)['depth'] >= $tank_param['depth_min'] && end($type2)['depth'] <= $tank_param['depth_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;"><?= $sensor_info2['name'] ?> Depth<canvas id="cv_bar2" style="max-height: 250px;"></canvas></div>
                <div class="grid-item widget mini-widget " id="amdiv" style="border-color:<?php if ($status == true && (end($type1)['ammonia'] >= $tank_param['ammonia_min'] && end($type1)['ammonia'] <= $tank_param['ammonia_max']) && (end($type2)['ammonia'] >= $tank_param['ammonia_min'] && end($type2)['ammonia'] <= $tank_param['ammonia_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;">Ammonia<canvas id="cv_amm"></canvas></div>
                <div class="grid-item widget tank-widget" id="infodiv"><u>Tank Info</u></br></br>
                    <span style="position: absolute; top: 0px; right:0px; width: 40%;padding: 4px;">
                        <select style="width: 200px;" id="sel_displaytank">
                            <?php
                            foreach ($tanklist as $each) {
                                echo "<option value='" . $each['id'] . "'>" . $each['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </span>
                    Tank Name: <?= $tank['name'] ?> </br>
                    Content: <?= $tank['desc'] ?></br>
                    Location: <?= $tank['location'] ?>
                    <script>
                        const tankOption = document.getElementById('sel_displaytank');
                        tankOption.value = <?= $tank['id'] ?>;
                        tankOption.addEventListener('change', function () {
                            const selectTankId = tankOption.value;
                            location.href = 'http://<?= $GLOBALS['HOSTNAME'] ?>:8080/home?tank_id=' + selectTankId;
                        });

                    </script>
                </div>
                <div class="grid-item row-end" style="grid-row: 9;"></div> <!--next line-->
                <div class="grid-item widget mini-widget" id="tudiv" style="border-color:<?php if ($status == true && (end($type1)['turbidity'] >= $tank_param['turbidity_min'] && end($type1)['turbidity'] <= $tank_param['turbidity_max']) && (end($type2)['turbidity'] >= $tank_param['turbidity_min'] && end($type2)['turbidity'] <= $tank_param['turbidity_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;">Turbidity<canvas id="cv_tur"></canvas></div>
                <div class="grid-item widget mini-widget " id="nidiv" style="border-color:<?php if ($status == true && (end($type1)['nitrate'] >= $tank_param['nitrate_min'] && end($type1)['nitrate'] <= $tank_param['nitrate_max']) && (end($type2)['nitrate'] >= $tank_param['nitrate_min'] && end($type2)['nitrate'] <= $tank_param['nitrate_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;">Nitrate<canvas id="cv_nit"></canvas></div>
                <div class="grid-item widget temp-widget " id="tempdiv" style="border-color:<?php if ($status == true && (end($type1)['temp'] >= $tank_param['temp_min'] && end($type1)['temp'] <= $tank_param['temp_max']) && (end($type2)['temp'] >= $tank_param['temp_min'] && end($type2)['temp'] <= $tank_param['temp_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;">Temperature<canvas style="max-height: 175px;" id="cv_temp"></canvas></div>

            </div>


            <div class="grid-container">
                <div class="grid-item widget messagetitle">Warnings</div>
                <div class="grid-item widget messagetitle">Sensor Log</div>
                <div class="grid-item widget messagetitle">Forecasts</div>
                <div class="grid-item widget messagecontent">
                    <table>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th style="width:300px;">Warning</th>
                            <th style="width:150px;">Timestamp</th>
                        </tr>
                        <?php
                        $msg_index = 0;
                        foreach ($message['warning'] as $each) {
                            if ($msg_index > 14) {
                                break;
                            }
                            echo '<tr><td>' . $each['message_id'] . '</td>';
                            echo '<td>' . $each['content'] . '</td>';
                            echo '<td>' . $each['time_posted'] . '</td></tr>';
                            $msg_index = $msg_index + 1;
                        }
                        ?>

                    </table>
                </div>
                <div class="grid-item widget messagecontent">
                    <table>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th style="width:300px;">Sensor Log</th>
                            <th style="width:150px;">Timestamp</th>
                        </tr>
                        <?php
                        $msg_index = 0;
                        foreach ($message['sensor'] as $each) {
                            if ($msg_index > 14) {
                                break;
                            }
                            echo '<tr><td>' . $each['message_id'] . '</td>';
                            echo '<td>' . $each['content'] . '</td>';
                            echo '<td>' . $each['time_posted'] . '</td></tr>';
                            $msg_index = $msg_index + 1;
                        }
                        ?>

                    </table>
                </div>
                <div class="grid-item widget messagecontent">
                    <table>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th style="width:300px;">Forecasts</th>
                            <th style="width:150px;">Timestamp</th>
                        </tr>
                        <?php
                        $msg_index = 0;
                        foreach ($message['forecast'] as $each) {
                            if ($msg_index > 14) {
                                break;
                            }
                            echo '<tr><td>' . $each['message_id'] . '</td>';
                            echo '<td>' . $each['content'] . '</td>';
                            echo '<td>' . $each['time_posted'] . '</td></tr>';
                            $msg_index = $msg_index + 1;
                        }
                        ?>

                    </table>
                </div>
            </div>

            <!--<div id="modalwindow" style="background-color: #000000d7; height: 100vh; width:100vw; position:fixed; top: 0;right: 0; display: none; z-index: 3; ">
            <div class="widget-modal">
                Chart
                <canvas id="chart2"></canvas>
            </div>
        </div>-->

            <!--  -->
        </div>


        <?php $sitename = 'http://' . $GLOBALS['HOSTNAME'] . ':8080/admin'; ?>
        <div class="bottomleftnav" id="navbuttons">
            <?php if (DBHandler::findAdmin() == true) {
                echo "<div id='adminbutton' class='navicon' onclick='location.href=\"$sitename\";'>Admin</div>";
            } ?>
            <div id="homebutton" class="navicon"
                onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/home';">Home</div>
            <div id="profilebutton" class="navicon"
                onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/profile';">Profile</div>
            <div id="logoutbutton" class="logout"
                onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/logout';">Logout</div>
        </div>



    </div>

    <div class="mobile-view">
        <div style="height:10vh; width:92vw;">
            <span class="header"><img src="https://i.imgur.com/I5pJoVM.png" style="max-height: 9vh;"
                    onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/home';"></span>
            <span class="header" style="width: 100%;"><b>Aqua UMS Project</b></br>Kerjasama Fakulti Komputeran dan
                Informatik dan Institut Penyelidikan Marin Borneo</span>
            <span class="header"><img
                    src="https://i.imgur.com/jaqebAU.png"
                    style="max-height: 9vh;"
                    onclick="location.href ='http://<?= $GLOBALS['HOSTNAME'] ?>:8080/admin';"></span>
        </div>
        <div class="" style="" id="m_monitorwindow">
            <div class="grid-container" style=" margin-bottom: 50px;">
                <div class="grid-item widget tank-widget" style="margin-top: 160px; height: 250px;" id="m_infodiv">
                    <u>Tank Info</u></br></br>
                    <span style="position: absolute; top: 80%; right:30%; width: 40%;padding: 4px;">
                        <select style="width: 200px;" id="m_sel_displaytank">
                            <?php
                            foreach ($tanklist as $each) {
                                echo "<option value='" . $each['id'] . "'>" . $each['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </span>
                    Tank Name: <?= $tank['name'] ?> </br>
                    Content: <?= $tank['desc'] ?></br>
                    Location: <?= $tank['location'] ?>
                    <script>
                        const m_tankOption = document.getElementById('m_sel_displaytank');
                        m_tankOption.value = <?= $tank['id'] ?>;
                        m_tankOption.addEventListener('change', function () {
                            const m_selectTankId = m_tankOption.value;
                            location.href = 'http://<?= $GLOBALS['HOSTNAME'] ?>:8080/home?tank_id=' + m_selectTankId;
                        });

                    </script>
                </div>
                <div class="grid-item widget main-widget" style="position: relative;" id="m_scorediv">Water Quality
                    Score
                    <canvas id="m_mainChart" style="max-height: 450px;"></canvas>
                    <span class="scoreleft" id="m_mainleft"><?= $sensor_info1['name'] ?></br><b
                            style="font-size: 40px;">N/A%</b></span>
                    <span class="scoreright" id="m_mainright"><?= $sensor_info2['name'] ?></br><b
                            style="font-size: 40px;">N/A%</b></span>
                </div>

                <div class="grid-item widget mini-widget" id="m_phdiv" style="border-color:<?php if ($status == true && (end($type1)['ph'] >= $tank_param['ph_min'] && end($type1)['ph'] <= $tank_param['ph_max']) && (end($type2)['ph'] >= $tank_param['ph_min'] && end($type2)['ph'] <= $tank_param['ph_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;">pH Level<canvas id="m_cv_ph"></canvas></div>

                <div class="grid-item widget mini-widget" id="m_dodiv" style="border-color:<?php if ($status == true && (end($type1)['do'] >= $tank_param['do_min'] && end($type1)['do'] <= $tank_param['do_max']) && (end($type2)['do'] >= $tank_param['do_min'] && end($type2)['do'] <= $tank_param['do_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;">Dissolved Oxygen<canvas id="m_cv_do"></canvas></div>

                <div class="grid-item widget mini-widget " id="m_sadiv" style="border-color:<?php if ($status == true && (end($type1)['salinity'] >= $tank_param['salinity_min'] && end($type1)['salinity'] <= $tank_param['salinity_max']) && (end($type2)['salinity'] >= $tank_param['salinity_min'] && end($type2)['salinity'] <= $tank_param['salinity_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;">Salinity<canvas id="m_cv_sal"></canvas></div>

                <!--<div class="grid-item small-widget widget" id="m_depthtankdiv"><?= $sensor_info1['name'] ?> Depth<canvas id="m_cv_bar1" style="max-height: 250px;"></canvas></div>

            <div class="grid-item small-widget widget" id="m_depthfilterdiv"><?= $sensor_info2['name'] ?> Depth<canvas id="m_cv_bar2" style="max-height: 250px;"></canvas></div>-->

                <div class="grid-item widget mini-widget " id="m_amdiv">Ammonia<canvas id="m_cv_amm" style="border-color:<?php if ($status == true && (end($type1)['ammonia'] >= $tank_param['ammonia_min'] && end($type1)['ammonia'] <= $tank_param['ammonia_max']) && (end($type2)['ammonia'] >= $tank_param['ammonia_min'] && end($type2)['ammonia'] <= $tank_param['ammonia_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;"></canvas></div>

                <div class="grid-item widget mini-widget" id="m_tudiv">Turbidity<canvas id="m_cv_tur" style="border-color:<?php if ($status == true && (end($type1)['turbidity'] >= $tank_param['turbidity_min'] && end($type1)['turbidity'] <= $tank_param['turbidity_max']) && (end($type2)['turbidity'] >= $tank_param['turbidity_min'] && end($type2)['turbidity'] <= $tank_param['turbidity_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;"></canvas></div>

                <div class="grid-item widget mini-widget " id="m_nidiv">Nitrate<canvas id="m_cv_nit" style="border-color:<?php if ($status == true && (end($type1)['nitrate'] >= $tank_param['nitrate_min'] && end($type1)['nitrate'] <= $tank_param['nitrate_max']) && (end($type2)['nitrate'] >= $tank_param['nitrate_min'] && end($type2)['nitrate'] <= $tank_param['nitrate_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;"></canvas></div>

                <div class="grid-item widget temp-widget " id="m_tempdiv" style="border-color:<?php if ($status == true && (end($type1)['temp'] >= $tank_param['temp_min'] && end($type1)['temp'] <= $tank_param['temp_max']) && (end($type2)['temp'] >= $tank_param['temp_min'] && end($type2)['temp'] <= $tank_param['temp_max'])) {
                    echo '#cccccc';
                } else {
                    echo '#d0342c';
                } ?>;">Temperature<canvas style="max-height: 175px;" id="m_cv_temp"></canvas></div>

            </div>


            <div class="grid-container">
                <div class="grid-item widget messagetitle">Warnings</div>

                <div class="grid-item widget messagecontent">
                    <table>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th style="width:300px;">Warning</th>
                            <th style="width:150px;">Timestamp</th>
                        </tr>
                        <?php
                        $msg_index = 0;
                        foreach ($message['warning'] as $each) {
                            if ($msg_index > 6) {
                                break;
                            }
                            echo '<tr><td>' . $each['message_id'] . '</td>';
                            echo '<td>' . $each['content'] . '</td>';
                            echo '<td>' . $each['time_posted'] . '</td></tr>';
                            $msg_index = $msg_index + 1;
                        }
                        ?>

                    </table>
                </div>

                <div class="grid-item widget messagetitle">Sensor Log</div>
                <div class="grid-item widget messagecontent">
                    <table>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th style="width:300px;">Sensor Log</th>
                            <th style="width:150px;">Timestamp</th>
                        </tr>
                        <?php
                        $msg_index = 0;
                        foreach ($message['sensor'] as $each) {
                            if ($msg_index > 6) {
                                break;
                            }
                            echo '<tr><td>' . $each['message_id'] . '</td>';
                            echo '<td>' . $each['content'] . '</td>';
                            echo '<td>' . $each['time_posted'] . '</td></tr>';
                            $msg_index = $msg_index + 1;
                        }
                        ?>

                    </table>
                </div>

                <div class="grid-item widget messagetitle">Forecasts</div>
                <div class="grid-item widget messagecontent">
                    <table>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th style="width:300px;">Forecasts</th>
                            <th style="width:150px;">Timestamp</th>
                        </tr>
                        <?php
                        $msg_index = 0;
                        foreach ($message['forecast'] as $each) {
                            if ($msg_index > 6) {
                                break;
                            }
                            echo '<tr><td>' . $each['message_id'] . '</td>';
                            echo '<td>' . $each['content'] . '</td>';
                            echo '<td>' . $each['time_posted'] . '</td></tr>';
                            $msg_index = $msg_index + 1;
                        }
                        ?>

                    </table>
                </div>
            </div>

            <!--<div id="modalwindow" style="background-color: #000000d7; height: 100vh; width:100vw; position:fixed; top: 0;right: 0; display: none; z-index: 3; ">
            <div class="widget-modal">
                Chart
                <canvas id="chart2"></canvas>
            </div>
        </div>-->

            <!--  -->
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.1/chart.min.js"></script>



    <?php if ($status) { ?>
            <script>
                const ph_chartlabel = <?= json_encode(array_keys($type1)) ?>.slice(-6);
                const ph_data1label = "<?= $sensor_info1['name'] ?>";
                const ph_data1 = <?= json_encode(array_column($type1, 'ph')) ?>.slice(-6);
                const ph_data2label = "<?= $sensor_info2['name'] ?>";
                const ph_data2 = <?= json_encode(array_column($type2, 'ph')) ?>.slice(-6);

                const cv_ph = document.getElementById('cv_ph');
                const ch_ph = new Chart(cv_ph, {
                    type: 'line',
                    data: {
                        labels: ph_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: ph_data1label,   //Sensor type or name
                            data: ph_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['ph'] >= $tank_param['ph_min'] && end($type1)['ph'] <= $tank_param['ph_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['ph'] >= $tank_param['ph_min'] && end($type1)['ph'] <= $tank_param['ph_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: ph_data2label,
                            data: ph_data2,
                            backgroundColor: <?php if (end($type2)['ph'] >= $tank_param['ph_min'] && end($type2)['ph'] <= $tank_param['ph_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['ph'] >= $tank_param['ph_min'] && end($type2)['ph'] <= $tank_param['ph_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 14,
                                min: 1,
                                stepSize: 0.1,
                            }
                        },
                    }
                });

                const m_cv_ph = document.getElementById('m_cv_ph');
                const m_ch_ph = new Chart(m_cv_ph, {
                    type: 'line',
                    data: {
                        labels: ph_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: ph_data1label,   //Sensor type or name
                            data: ph_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['ph'] >= $tank_param['ph_min'] && end($type1)['ph'] <= $tank_param['ph_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['ph'] >= $tank_param['ph_min'] && end($type1)['ph'] <= $tank_param['ph_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: ph_data2label,
                            data: ph_data2,
                            backgroundColor: <?php if (end($type2)['ph'] >= $tank_param['ph_min'] && end($type2)['ph'] <= $tank_param['ph_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['ph'] >= $tank_param['ph_min'] && end($type2)['ph'] <= $tank_param['ph_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 14,
                                min: 1,
                                stepSize: 0.1,
                            }
                        },
                    }
                });


                const do_chartlabel = <?= json_encode(array_keys($type1)) ?>.slice(-6);
                const do_data1label = "<?= $sensor_info1['name'] ?>";
                const do_data1 = <?= json_encode(array_column($type1, 'do')) ?>.slice(-6);
                const do_data2label = "<?= $sensor_info2['name'] ?>";
                const do_data2 = <?= json_encode(array_column($type2, 'do')) ?>.slice(-6);

                const cv_do = document.getElementById('cv_do');
                const ch_do = new Chart(cv_do, {
                    type: 'line',
                    data: {
                        labels: do_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: do_data1label,   //Sensor type or name
                            data: do_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['do'] >= $tank_param['do_min'] && end($type1)['do'] <= $tank_param['do_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['do'] >= $tank_param['do_min'] && end($type1)['do'] <= $tank_param['do_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: do_data2label,
                            data: do_data2,
                            backgroundColor: <?php if (end($type2)['do'] >= $tank_param['do_min'] && end($type2)['do'] <= $tank_param['do_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['do'] >= $tank_param['do_min'] && end($type2)['do'] <= $tank_param['do_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 100,
                                min: 0,
                                stepSize: 0.1,
                            }
                        },
                    }
                });
                const m_cv_do = document.getElementById('m_cv_do');
                const m_ch_do = new Chart(m_cv_do, {
                    type: 'line',
                    data: {
                        labels: do_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: do_data1label,   //Sensor type or name
                            data: do_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['do'] >= $tank_param['do_min'] && end($type1)['do'] <= $tank_param['do_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['do'] >= $tank_param['do_min'] && end($type1)['do'] <= $tank_param['do_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: do_data2label,
                            data: do_data2,
                            backgroundColor: <?php if (end($type2)['do'] >= $tank_param['do_min'] && end($type2)['do'] <= $tank_param['do_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['do'] >= $tank_param['do_min'] && end($type2)['do'] <= $tank_param['do_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 100,
                                min: 0,
                                stepSize: 0.1,
                            }
                        },
                    }
                });

                const sal_chartlabel = <?= json_encode(array_keys($type1)) ?>.slice(-6);
                const sal_data1label = "<?= $sensor_info1['name'] ?>";
                const sal_data1 = <?= json_encode(array_column($type1, 'salinity')) ?>.slice(-6);
                const sal_data2label = "<?= $sensor_info2['name'] ?>";
                const sal_data2 = <?= json_encode(array_column($type2, 'salinity')) ?>.slice(-6);

                const cv_sal = document.getElementById('cv_sal');
                const ch_sal = new Chart(cv_sal, {
                    type: 'line',
                    data: {
                        labels: sal_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: sal_data1label,   //Sensor type or name
                            data: sal_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['salinity'] >= $tank_param['salinity_min'] && end($type1)['salinity'] <= $tank_param['salinity_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['salinity'] >= $tank_param['salinity_min'] && end($type1)['salinity'] <= $tank_param['salinity_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: sal_data2label,
                            data: sal_data2,
                            backgroundColor: <?php if (end($type2)['salinity'] >= $tank_param['salinity_min'] && end($type2)['salinity'] <= $tank_param['salinity_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['salinity'] >= $tank_param['salinity_min'] && end($type2)['salinity'] <= $tank_param['salinity_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 50,
                                min: 0,
                                stepSize: 0.1,
                            }
                        },
                    }
                });

                const m_cv_sal = document.getElementById('m_cv_sal');
                const m_ch_sal = new Chart(m_cv_sal, {
                    type: 'line',
                    data: {
                        labels: sal_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: sal_data1label,   //Sensor type or name
                            data: sal_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['salinity'] >= $tank_param['salinity_min'] && end($type1)['salinity'] <= $tank_param['salinity_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['salinity'] >= $tank_param['salinity_min'] && end($type1)['salinity'] <= $tank_param['salinity_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: sal_data2label,
                            data: sal_data2,
                            backgroundColor: <?php if (end($type2)['salinity'] >= $tank_param['salinity_min'] && end($type2)['salinity'] <= $tank_param['salinity_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['salinity'] >= $tank_param['salinity_min'] && end($type2)['salinity'] <= $tank_param['salinity_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 50,
                                min: 0,
                                stepSize: 0.1,
                            }
                        },
                    }
                });



                const amm_chartlabel = <?= json_encode(array_keys($type1)) ?>.slice(-6);
                const amm_data1label = "<?= $sensor_info1['name'] ?>";
                const amm_data1 = <?= json_encode(array_column($type1, 'ammonia')) ?>.slice(-6);
                const amm_data2label = "<?= $sensor_info2['name'] ?>";
                const amm_data2 = <?= json_encode(array_column($type2, 'ammonia')) ?>.slice(-6);

                const cv_amm = document.getElementById('cv_amm');
                const ch_amm = new Chart(cv_amm, {
                    type: 'line',
                    data: {
                        labels: amm_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: amm_data1label,   //Sensor type or name
                            data: amm_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['ammonia'] >= $tank_param['ammonia_min'] && end($type1)['ammonia'] <= $tank_param['ammonia_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['ammonia'] >= $tank_param['ammonia_min'] && end($type1)['ammonia'] <= $tank_param['ammonia_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: amm_data2label,
                            data: amm_data2,
                            backgroundColor: <?php if (end($type2)['ammonia'] >= $tank_param['ammonia_min'] && end($type2)['ammonia'] <= $tank_param['ammonia_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['ammonia'] >= $tank_param['ammonia_min'] && end($type2)['ammonia'] <= $tank_param['ammonia_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 20,
                                min: 0,
                                stepSize: 0.1,
                            }
                        },
                    }
                });

                const m_cv_amm = document.getElementById('m_cv_amm');
                const m_ch_amm = new Chart(m_cv_amm, {
                    type: 'line',
                    data: {
                        labels: amm_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: amm_data1label,   //Sensor type or name
                            data: amm_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['ammonia'] >= $tank_param['ammonia_min'] && end($type1)['ammonia'] <= $tank_param['ammonia_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['ammonia'] >= $tank_param['ammonia_min'] && end($type1)['ammonia'] <= $tank_param['ammonia_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: amm_data2label,
                            data: amm_data2,
                            backgroundColor: <?php if (end($type2)['ammonia'] >= $tank_param['ammonia_min'] && end($type2)['ammonia'] <= $tank_param['ammonia_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['ammonia'] >= $tank_param['ammonia_min'] && end($type2)['ammonia'] <= $tank_param['ammonia_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 20,
                                min: 0,
                                stepSize: 0.1,
                            }
                        },
                    }
                });


                const nit_chartlabel = <?= json_encode(array_keys($type1)) ?>.slice(-6);
                const nit_data1label = "<?= $sensor_info1['name'] ?>";
                const nit_data1 = <?= json_encode(array_column($type1, 'nitrate')) ?>.slice(-6);
                const nit_data2label = "<?= $sensor_info2['name'] ?>";
                const nit_data2 = <?= json_encode(array_column($type2, 'nitrate')) ?>.slice(-6);

                const cv_nit = document.getElementById('cv_nit');
                const ch_nit = new Chart(cv_nit, {
                    type: 'line',
                    data: {
                        labels: nit_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: nit_data1label,   //Sensor type or name
                            data: nit_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['nitrate'] >= $tank_param['nitrate_min'] && end($type1)['nitrate'] <= $tank_param['nitrate_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['nitrate'] >= $tank_param['nitrate_min'] && end($type1)['nitrate'] <= $tank_param['nitrate_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: nit_data2label,
                            data: nit_data2,
                            backgroundColor: <?php if (end($type2)['nitrate'] >= $tank_param['nitrate_min'] && end($type2)['nitrate'] <= $tank_param['nitrate_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['nitrate'] >= $tank_param['nitrate_min'] && end($type2)['nitrate'] <= $tank_param['nitrate_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 20,
                                min: 0,
                                stepSize: 0.1,
                            }
                        },
                    }
                });

                const m_cv_nit = document.getElementById('m_cv_nit');
                const m_ch_nit = new Chart(m_cv_nit, {
                    type: 'line',
                    data: {
                        labels: nit_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: nit_data1label,   //Sensor type or name
                            data: nit_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['nitrate'] >= $tank_param['nitrate_min'] && end($type1)['nitrate'] <= $tank_param['nitrate_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['nitrate'] >= $tank_param['nitrate_min'] && end($type1)['nitrate'] <= $tank_param['nitrate_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: nit_data2label,
                            data: nit_data2,
                            backgroundColor: <?php if (end($type2)['nitrate'] >= $tank_param['nitrate_min'] && end($type2)['nitrate'] <= $tank_param['nitrate_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['nitrate'] >= $tank_param['nitrate_min'] && end($type2)['nitrate'] <= $tank_param['nitrate_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 20,
                                min: 0,
                                stepSize: 0.1,
                            }
                        },
                    }
                });

                const tur_chartlabel = <?= json_encode(array_keys($type1)) ?>.slice(-6);
                const tur_data1label = "<?= $sensor_info1['name'] ?>";
                const tur_data1 = <?= json_encode(array_column($type1, 'turbidity')) ?>.slice(-6);
                const tur_data2label = "<?= $sensor_info2['name'] ?>";
                const tur_data2 = <?= json_encode(array_column($type2, 'turbidity')) ?>.slice(-6);

                const cv_tur = document.getElementById('cv_tur');
                const ch_tur = new Chart(cv_tur, {
                    type: 'line',
                    data: {
                        labels: tur_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: tur_data1label,   //Sensor type or name
                            data: tur_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['turbidity'] >= $tank_param['turbidity_min'] && end($type1)['turbidity'] <= $tank_param['turbidity_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['turbidity'] >= $tank_param['turbidity_min'] && end($type1)['turbidity'] <= $tank_param['turbidity_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: tur_data2label,
                            data: tur_data2,
                            backgroundColor: <?php if (end($type2)['turbidity'] >= $tank_param['turbidity_min'] && end($type2)['turbidity'] <= $tank_param['turbidity_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['turbidity'] >= $tank_param['turbidity_min'] && end($type2)['turbidity'] <= $tank_param['turbidity_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 10,
                                min: 0,
                                stepSize: 0.1,
                            }
                        },
                    }
                });

                const m_cv_tur = document.getElementById('m_cv_tur');
                const m_ch_tur = new Chart(m_cv_tur, {
                    type: 'line',
                    data: {
                        labels: tur_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: tur_data1label,   //Sensor type or name
                            data: tur_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['turbidity'] >= $tank_param['turbidity_min'] && end($type1)['turbidity'] <= $tank_param['turbidity_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['turbidity'] >= $tank_param['turbidity_min'] && end($type1)['turbidity'] <= $tank_param['turbidity_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: tur_data2label,
                            data: tur_data2,
                            backgroundColor: <?php if (end($type2)['turbidity'] >= $tank_param['turbidity_min'] && end($type2)['turbidity'] <= $tank_param['turbidity_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['turbidity'] >= $tank_param['turbidity_min'] && end($type2)['turbidity'] <= $tank_param['turbidity_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 10,
                                min: 0,
                                stepSize: 0.1,
                            }
                        },
                    }
                });


                const temp_chartlabel = <?= json_encode(array_keys($type1)) ?>.slice(-6);
                const temp_data1label = "<?= $sensor_info1['name'] ?>";
                const temp_data1 = <?= json_encode(array_column($type1, 'temp')) ?>.slice(-6);
                const temp_data2label = "<?= $sensor_info2['name'] ?>";
                const temp_data2 = <?= json_encode(array_column($type2, 'temp')) ?>.slice(-6);

                const cv_temp = document.getElementById('cv_temp');
                const ch_temp = new Chart(cv_temp, {
                    type: 'line',
                    data: {
                        labels: temp_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: temp_data1label,   //Sensor type or name
                            data: temp_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['temp'] >= $tank_param['temp_min'] && end($type1)['temp'] <= $tank_param['temp_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['temp'] >= $tank_param['temp_min'] && end($type1)['temp'] <= $tank_param['temp_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: temp_data2label,
                            data: temp_data2,
                            backgroundColor: <?php if (end($type2)['temp'] >= $tank_param['temp_min'] && end($type2)['temp'] <= $tank_param['temp_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['temp'] >= $tank_param['temp_min'] && end($type2)['temp'] <= $tank_param['temp_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 40,
                                min: 10,
                                stepSize: 5,
                            }
                        },
                    }
                });

                const m_cv_temp = document.getElementById('m_cv_temp');
                const m_ch_temp = new Chart(m_cv_temp, {
                    type: 'line',
                    data: {
                        labels: temp_chartlabel,      //generate label array timestamp log
                        datasets: [{
                            label: temp_data1label,   //Sensor type or name
                            data: temp_data1,   //timestamp pair of data
                            backgroundColor: <?php if (end($type1)['temp'] >= $tank_param['temp_min'] && end($type1)['temp'] <= $tank_param['temp_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['temp'] >= $tank_param['temp_min'] && end($type1)['temp'] <= $tank_param['temp_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }, {
                            label: temp_data2label,
                            data: temp_data2,
                            backgroundColor: <?php if (end($type2)['temp'] >= $tank_param['temp_min'] && end($type2)['temp'] <= $tank_param['temp_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['temp'] >= $tank_param['temp_min'] && end($type2)['temp'] <= $tank_param['temp_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 5,
                                min: 0,
                                stepSize: 1,
                            },
                            y: {
                                max: 40,
                                min: 10,
                                stepSize: 5,
                            }
                        },
                    }
                });



                const dep_chartlabel = <?= json_encode(array_keys($type1)) ?>.slice(-1);
                const dep_data1label = "<?= $sensor_info1['name'] ?>";
                const dep_data1 = <?= json_encode($dep1) ?>.slice(-1);
                const dep_data2label = "<?= $sensor_info2['name'] ?>";
                const dep_data2 = <?= json_encode($dep2) ?>.slice(-1);

                const cv_dep1 = document.getElementById('cv_bar1');
                const ch_dep1 = new Chart(cv_dep1, {
                    type: 'bar',
                    data: {
                        labels: ["Depth (cm)"], // Label for the bar
                        datasets: [{
                            label: dep_data1label,
                            data: [dep_data1], // Value for the bar (ranging from 0 to 300)
                            backgroundColor: <?php if (end($type1)['depth'] >= $tank_param['depth_min'] && end($type1)['depth'] <= $tank_param['depth_max']) {
                                echo '"#00bfff33"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type1)['depth'] >= $tank_param['depth_min'] && end($type1)['depth'] <= $tank_param['depth_max']) {
                                echo '"#00bfff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2 // Bar border width
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 1,
                                min: 1,
                                stepSize: 1,
                            },
                            y: {
                                max: 300,
                                min: 0,
                                stepSize: 10,
                            }
                        },
                    }
                });

                const cv_dep2 = document.getElementById('cv_bar2');
                const ch_dep2 = new Chart(cv_dep2, {
                    type: 'bar',
                    data: {
                        labels: ["Depth (cm)"],      //generate label array timestamp log
                        datasets: [{
                            label: dep_data2label,   //Sensor type or name
                            data: [dep_data2],   //timestamp pair of data
                            backgroundColor: <?php if (end($type2)['depth'] >= $tank_param['depth_min'] && end($type2)['depth'] <= $tank_param['depth_max']) {
                                echo '"#f700ff2c"';
                            } else {
                                echo '"#d0342c33"';
                            } ?>,
                            borderColor: <?php if (end($type2)['depth'] >= $tank_param['depth_min'] && end($type2)['depth'] <= $tank_param['depth_max']) {
                                echo '"#f700ff"';
                            } else {
                                echo '"#d0342c"';
                            } ?>,
                            borderWidth: 2,
                            fill: true
                        },
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                max: 1,
                                min: 1,
                                stepSize: 1,
                            },
                            y: {
                                max: 300,
                                min: 0,
                                stepSize: 10,
                            }
                        },
                    }
                });

                const fishTankQuality = parseInt((parseFloat(ph_data1.slice(-1)[0]) + parseFloat(do_data1.slice(-1)[0] / 100) + parseFloat(amm_data1.slice(-1)[0]) + parseFloat(sal_data1.slice(-1)[0]) + parseFloat(nit_data1.slice(-1)[0]) + parseFloat(tur_data1.slice(-1)[0]) + parseFloat(temp_data1.slice(-1)[0])));
                const bioFilterQuality = parseInt(parseFloat(ph_data2.slice(-1)[0]) + parseFloat(do_data2.slice(-1)[0] / 100) + parseFloat(amm_data2.slice(-1)[0]) + parseFloat(sal_data2.slice(-1)[0]) + parseFloat(nit_data2.slice(-1)[0]) + parseFloat(tur_data2.slice(-1)[0]) + parseFloat(temp_data2.slice(-1)[0]));
                var ch_main = document.getElementById('mainChart').getContext('2d');
                var donutChart = new Chart(ch_main, {
                    type: 'doughnut',
                    data: {
                        labels: ["Water Quality Percentage", ""], // Labels for the pie charts
                        datasets: [{
                            data: [fishTankQuality, 100 - fishTankQuality], // Values for the first pie chart (percentages)
                            backgroundColor: ["#00bfff33", "#aaaaaa00"], // Colors for the first pie chart slices
                            borderWidth: 1, // Border width of the first pie chart slices
                            borderColor: "#00b2ff" // Border color of the first pie chart slices
                        }, {
                            data: [bioFilterQuality, 100 - bioFilterQuality], // Values for the second pie chart (percentages)
                            backgroundColor: ["#f700ff2c", "#aaaaaa00"], // Colors for the second pie chart slices
                            borderWidth: 1, // Border width of the second pie chart slices
                            borderColor: "#f700ff" // Border color of the second pie chart slices
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            }
                        },
                    }
                });

                var m_ch_main = document.getElementById('m_mainChart').getContext('2d');
                var m_donutChart = new Chart(m_ch_main, {
                    type: 'doughnut',
                    data: {
                        labels: ["Water Quality Percentage", ""], // Labels for the pie charts
                        datasets: [{
                            data: [fishTankQuality, 100 - fishTankQuality], // Values for the first pie chart (percentages)
                            backgroundColor: ["#00bfff33", "#aaaaaa00"], // Colors for the first pie chart slices
                            borderWidth: 1, // Border width of the first pie chart slices
                            borderColor: "#00b2ff" // Border color of the first pie chart slices
                        }, {
                            data: [bioFilterQuality, 100 - bioFilterQuality], // Values for the second pie chart (percentages)
                            backgroundColor: ["#f700ff2c", "#aaaaaa00"], // Colors for the second pie chart slices
                            borderWidth: 1, // Border width of the second pie chart slices
                            borderColor: "#f700ff" // Border color of the second pie chart slices
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            }
                        },
                    }
                });

                document.getElementById('m_mainright').innerHTML = `<?= $sensor_info1['name'] ?></br><b style="font-size: 40px;">${fishTankQuality}%</b>`;
                document.getElementById('m_mainleft').innerHTML = `<?= $sensor_info2['name'] ?></br><b style="font-size: 40px;">${bioFilterQuality}%</b>`;
                document.getElementById('mainright').innerHTML = `<?= $sensor_info1['name'] ?></br><b style="font-size: 40px;">${fishTankQuality}%</b>`;
                document.getElementById('mainleft').innerHTML = `<?= $sensor_info2['name'] ?></br><b style="font-size: 40px;">${bioFilterQuality}%</b>`;
            </script>
    <?php } ?>
</body>

</html>