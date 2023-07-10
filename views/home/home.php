
<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use app\models\DBHandler;



$this->title = 'Aqua UMS Project';
$tanklist = DBHandler::getTank();
$request = Yii::$app->request->get('tank_id');

foreach ($tanklist as $each){
    if ($each['id'] == $request){
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
$sensor2 = $loglist[1];
$type1 = array();
foreach($sensor1 as $each){
    $type1[$each['time_taken']] = [
        'ph'=>$each['pH'],
        'do'=>$each['Do'],
        'salinity'=>$each['salinity'],
        'ammonia'=>$each['ammonia'],
        'nitrate'=>$each['nitrate'],
        'turbidity'=>$each['turbidity'],
        'temp'=>$each['temp'],
        'depth'=>$each['depth'],
        'type' => $each['type'],
    ];
}
$type2 = array();
foreach($sensor2 as $each){
    $type2[$each['time_taken']] = [
        'ph'=>$each['pH'],
        'do'=>$each['Do'],
        'salinity'=>$each['salinity'],
        'ammonia'=>$each['ammonia'],
        'nitrate'=>$each['nitrate'],
        'turbidity'=>$each['turbidity'],
        'temp'=>$each['temp'],
        'depth'=>$each['depth'],
        'type' => $each['type'],
    ];
}

$keytype1 = array_keys($type1);
$keytype2 = array_keys($type2);
$dep1 = array_column($type1, 'depth');
$dep2 = array_column($type2, 'depth');
$dep1 = end($dep1);
$dep2 = end($dep2);
$status = true;
}

catch(Exception $e){
    echo "Tank has no sensors or logged data, therefore no data to be displayed.";
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

    <div style="height:10vh; width:98vw;">
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821207343374417/LOGO_UMS_putih.png" style="max-height: 9vh;" onclick="location.href ='http://localhost:8080/home';"></span>
        <span class="header"><b style="font-size: 30px;">Aqua UMS Project</b></br>Kerjasama Fakulti Komputeran dan Informatik dan Institut Penyelidikan Marin Borneo</span>
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821361966387350/EcoCampus-Putih.png" style="max-height: 9vh;"></span>
    </div>

    <div class="" style="" id="monitorwindow">
    <div class="grid-container" style=" margin-bottom: 50px;">
        <div class="grid-item"></div>

        <div class="grid-item widget mini-widget" id="phdiv">pH Level<canvas id="cv_ph"></canvas></div>
        <div class="grid-item widget main-widget" style="position: relative;" id="scorediv">Water Quality Score
            <canvas id="mainChart" style="max-height: 450px;"></canvas>
            <span class="scoreleft" id="mainleft">Fish Tank</br><b style="font-size: 40px;">N/A%</b></span>
            <span class="scoreright" id="mainright">Biofilter</br><b style="font-size: 40px;">N/A%</b></span>
        </div>
        <div class="grid-item widget mini-widget" id="dodiv">Dissolved Oxygen<canvas id="cv_do"></canvas></div>
        <div class="grid-item widget mini-widget " id="sadiv">Salinity<canvas id="cv_sal"></canvas></div>
        <div class="grid-item small-widget widget" id="depthtankdiv">Fish Tank Depth<canvas id="cv_bar1" style="max-height: 250px;"></canvas></div>
        <div class="grid-item small-widget widget" id="depthfilterdiv">Biofilter Depth<canvas id="cv_bar2" style="max-height: 250px;"></canvas></div>
        <div class="grid-item widget mini-widget " id="amdiv">Ammonia<canvas id="cv_amm"></canvas></div>
        <div class="grid-item widget tank-widget" id="infodiv"><u>Tank Info</u></br></br>
            <span style="position: absolute; top: 0px; right:0px; width: 40%;padding: 4px;">
                <select style="width: 200px;" id="sel_displaytank">
                <?php
                    foreach ($tanklist as $each){
                        echo "<option value='".$each['id']."'>".$each['name']."</option>";
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
                tankOption.addEventListener('change', function() {
                    const selectTankId = tankOption.value;
                    location.href ='http://localhost:8080/home?tank_id='+selectTankId;
                });

            </script>
        </div>
        <div class="grid-item row-end" style="grid-row: 9;"></div> <!--next line-->
        <div class="grid-item widget mini-widget" id="tudiv">Turbidity<canvas id="cv_tur"></canvas></div>
        <div class="grid-item widget mini-widget " id="nidiv">Nitrate<canvas id="cv_nit"></canvas></div>
        <div class="grid-item widget temp-widget " id="tempdiv">Temperature<canvas style="max-height: 175px;" id="cv_temp"></canvas></div>
          
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
                    foreach ($message['warning'] as $each){
                        echo '<tr><td>'.$each['message_id'].'</td>';
                        echo '<td>'.$each['content'].'</td>';
                        echo '<td>'.$each['time_posted'].'</td></tr>';
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
                    foreach ($message['sensor'] as $each){
                        echo '<tr><td>'.$each['message_id'].'</td>';
                        echo '<td>'.$each['content'].'</td>';
                        echo '<td>'.$each['time_posted'].'</td></tr>';
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
                    foreach ($message['forecast'] as $each){
                        echo '<tr><td>'.$each['message_id'].'</td>';
                        echo '<td>'.$each['content'].'</td>';
                        echo '<td>'.$each['time_posted'].'</td></tr>';
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


    <div class="bottomleftnav" id="navbuttons">
        <div id="adminbutton" class="navicon" onclick="location.href ='http://localhost:8080/admin';">Admin</div>
        <div id="homebutton" class="navicon" onclick="location.href ='http://localhost:8080/home';">Home</div>
        <div id="profilebutton" class="navicon" onclick="location.href ='http://localhost:8080/profile';">Profile</div>
        <div id="logoutbutton" class="logout" onclick="location.href ='http://localhost:8080/logout';">Logout</div>
    </div>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.1/chart.min.js"></script>
    
<script>

<?php if ($status) { ?>
        const ph_chartlabel = <?= json_encode(array_keys($type1))?>;
        const ph_data1label = "<?= $type1[reset($keytype1)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
        const ph_data1 = <?= json_encode(array_column($type1, 'ph'))?>;
        const ph_data2label = "<?= $type2[reset($keytype2)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
        const ph_data2 = <?= json_encode(array_column($type2, 'ph'))?>;            

        const cv_ph = document.getElementById('cv_ph');
        const ch_ph = new Chart(cv_ph, {
            type: 'line',
            data:{
                labels: ph_chartlabel,      //generate label array timestamp log
                datasets:[{
                    label:ph_data1label,   //Sensor type or name
                    data: ph_data1,   //timestamp pair of data
                    backgroundColor: '#00bfff33',
                    borderColor: '#00b2ff',
                    borderWidth: 2,
                    fill: true   
                },{
                    label: ph_data2label,
                    data: ph_data2,
                    backgroundColor: '#f700ff2c',
                    borderColor: '#f700ff',
                    borderWidth: 2,
                    fill: true
                }
            ]},
            options:{
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                    }
                },
                scales: {
                    x: {
                        max: 14,
                        min: 1,
                        stepSize: 1,
                    },
                    y: {
                        max: 9,
                        min: 6,
                        stepSize: 0.1,
                    }
                },
            }
        }); 


const do_chartlabel = <?= json_encode(array_keys($type1))?>;
const do_data1label = "<?= $type1[reset($keytype1)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const do_data1 = <?= json_encode(array_column($type1, 'do'))?>;
const do_data2label = "<?= $type2[reset($keytype2)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const do_data2 = <?= json_encode(array_column($type2, 'do'))?>;            

const cv_do = document.getElementById('cv_do');
const ch_do = new Chart(cv_do, {
    type: 'line',
    data:{
        labels: do_chartlabel,      //generate label array timestamp log
        datasets:[{
            label:do_data1label,   //Sensor type or name
            data: do_data1,   //timestamp pair of data
            backgroundColor: '#00bfff33',
            borderColor: '#00b2ff',
            borderWidth: 2,
            fill: true   
        },{
            label: do_data2label,
            data: do_data2,
            backgroundColor: '#f700ff2c',
            borderColor: '#f700ff',
            borderWidth: 2,
            fill: true
        }
    ]},
    options:{
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
            }
        },
        scales: {
            x: {
                max: 14,
                min: 1,
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


const sal_chartlabel = <?= json_encode(array_keys($type1))?>;
const sal_data1label = "<?= $type1[reset($keytype1)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const sal_data1 = <?= json_encode(array_column($type1, 'salinity'))?>;
const sal_data2label = "<?= $type2[reset($keytype2)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const sal_data2 = <?= json_encode(array_column($type2, 'salinity'))?>;            

const cv_sal = document.getElementById('cv_sal');
const ch_sal = new Chart(cv_sal, {
    type: 'line',
    data:{
        labels: sal_chartlabel,      //generate label array timestamp log
        datasets:[{
            label:sal_data1label,   //Sensor type or name
            data: sal_data1,   //timestamp pair of data
            backgroundColor: '#00bfff33',
            borderColor: '#00b2ff',
            borderWidth: 2,
            fill: true   
        },{
            label: sal_data2label,
            data: sal_data2,
            backgroundColor: '#f700ff2c',
            borderColor: '#f700ff',
            borderWidth: 2,
            fill: true
        }
    ]},
    options:{
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
            }
        },
        scales: {
            x: {
                max: 14,
                min: 1,
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



const amm_chartlabel = <?= json_encode(array_keys($type1))?>;
const amm_data1label = "<?= $type1[reset($keytype1)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const amm_data1 = <?= json_encode(array_column($type1, 'ammonia'))?>;
const amm_data2label = "<?= $type2[reset($keytype2)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const amm_data2 = <?= json_encode(array_column($type2, 'ammonia'))?>;            

const cv_amm = document.getElementById('cv_amm');
const ch_amm = new Chart(cv_amm, {
    type: 'line',
    data:{
        labels: amm_chartlabel,      //generate label array timestamp log
        datasets:[{
            label:amm_data1label,   //Sensor type or name
            data: amm_data1,   //timestamp pair of data
            backgroundColor: '#00bfff33',
            borderColor: '#00b2ff',
            borderWidth: 2,
            fill: true   
        },{
            label: amm_data2label,
            data: amm_data2,
            backgroundColor: '#f700ff2c',
            borderColor: '#f700ff',
            borderWidth: 2,
            fill: true
        }
    ]},
    options:{
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
            }
        },
        scales: {
            x: {
                max: 14,
                min: 1,
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


const nit_chartlabel = <?= json_encode(array_keys($type1))?>;
const nit_data1label = "<?= $type1[reset($keytype1)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const nit_data1 = <?= json_encode(array_column($type1, 'nitrate'))?>;
const nit_data2label = "<?= $type2[reset($keytype2)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const nit_data2 = <?= json_encode(array_column($type2, 'nitrate'))?>;            

const cv_nit = document.getElementById('cv_nit');
const ch_nit = new Chart(cv_nit, {
    type: 'line',
    data:{
        labels: nit_chartlabel,      //generate label array timestamp log
        datasets:[{
            label:nit_data1label,   //Sensor type or name
            data: nit_data1,   //timestamp pair of data
            backgroundColor: '#00bfff33',
            borderColor: '#00b2ff',
            borderWidth: 2,
            fill: true   
        },{
            label: nit_data2label,
            data: nit_data2,
            backgroundColor: '#f700ff2c',
            borderColor: '#f700ff',
            borderWidth: 2,
            fill: true
        }
    ]},
    options:{
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
            }
        },
        scales: {
            x: {
                max: 14,
                min: 1,
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


const tur_chartlabel = <?= json_encode(array_keys($type1))?>;
const tur_data1label = "<?= $type1[reset($keytype1)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const tur_data1 = <?= json_encode(array_column($type1, 'turbidity'))?>;
const tur_data2label = "<?= $type2[reset($keytype2)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const tur_data2 = <?= json_encode(array_column($type2, 'turbidity'))?>;            

const cv_tur = document.getElementById('cv_tur');
const ch_tur = new Chart(cv_tur, {
    type: 'line',
    data:{
        labels: tur_chartlabel,      //generate label array timestamp log
        datasets:[{
            label:tur_data1label,   //Sensor type or name
            data: tur_data1,   //timestamp pair of data
            backgroundColor: '#00bfff33',
            borderColor: '#00b2ff',
            borderWidth: 2,
            fill: true   
        },{
            label: tur_data2label,
            data: tur_data2,
            backgroundColor: '#f700ff2c',
            borderColor: '#f700ff',
            borderWidth: 2,
            fill: true
        }
    ]},
    options:{
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
            }
        },
        scales: {
            x: {
                max: 14,
                min: 1,
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


const temp_chartlabel = <?= json_encode(array_keys($type1))?>;
const temp_data1label = "<?= $type1[reset($keytype1)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const temp_data1 = <?= json_encode(array_column($type1, 'temp'))?>;
const temp_data2label = "<?= $type2[reset($keytype2)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const temp_data2 = <?= json_encode(array_column($type2, 'temp'))?>;            

const cv_temp = document.getElementById('cv_temp');
const ch_temp = new Chart(cv_temp, {
    type: 'line',
    data:{
        labels: temp_chartlabel,      //generate label array timestamp log
        datasets:[{
            label:temp_data1label,   //Sensor type or name
            data: temp_data1,   //timestamp pair of data
            backgroundColor: '#00bfff33',
            borderColor: '#00b2ff',
            borderWidth: 2,
            fill: true   
        },{
            label: temp_data2label,
            data: temp_data2,
            backgroundColor: '#f700ff2c',
            borderColor: '#f700ff',
            borderWidth: 2,
            fill: true
        }
    ]},
    options:{
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
            }
        },
        scales: {
            x: {
                max: 14,
                min: 1,
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


const dep_chartlabel = <?= json_encode(array_keys($type1))?>;
const dep_data1label = "<?= $type1[reset($keytype1)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const dep_data1 = <?= json_encode($dep1)?>;
const dep_data2label = "<?= $type2[reset($keytype2)]['type'] == '1' ? 'Fish Tank':'Biofilter'?>";
const dep_data2 = <?= json_encode($dep2)?>;            

const cv_dep1 = document.getElementById('cv_bar1');
const ch_dep1 = new Chart(cv_dep1, {
    type: 'bar',
    data: {
    labels: ["Depth (cm)"], // Label for the bar
    datasets: [{
        label:dep_data1label,
        data: [dep_data1], // Value for the bar (ranging from 0 to 300)
        backgroundColor: '#00bfff33', // Bar color
        borderColor: '#00b2ff', // Bar border color
        borderWidth: 2 // Bar border width
    }]
},
    options:{
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
            }
        },
        scales: {
            x: {
                max: 10,
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
    data:{
        labels: ["Depth (cm)"],      //generate label array timestamp log
        datasets:[{
            label:dep_data2label,   //Sensor type or name
            data: [dep_data2],   //timestamp pair of data
            backgroundColor: '#f700ff2c',
            borderColor: '#f700ff',
            borderWidth: 2,
            fill: true   
        },
    ]},
    options:{
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
            }
        },
        scales: {
            x: {
                max: 14,
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

const fishTankQuality = parseInt((parseFloat(ph_data1.slice(-1)[0])+parseFloat(do_data1.slice(-1)[0])+parseFloat(amm_data1.slice(-1)[0])+parseFloat(sal_data1.slice(-1)[0])+parseFloat(nit_data1.slice(-1)[0])+parseFloat(tur_data1.slice(-1)[0])+parseFloat(temp_data1.slice(-1)[0]))/7*6);
const bioFilterQuality = parseInt(parseFloat(ph_data2.slice(-1)[0])+parseFloat(do_data2.slice(-1)[0])+parseFloat(amm_data2.slice(-1)[0])+parseFloat(sal_data2.slice(-1)[0])+parseFloat(nit_data2.slice(-1)[0])+parseFloat(tur_data2.slice(-1)[0])+parseFloat(temp_data2.slice(-1)[0]));
var ch_main = document.getElementById('mainChart').getContext('2d');
var donutChart = new Chart(ch_main, {
    type: 'doughnut',
    data: {
        labels: ["Water Quality Percentage", ""], // Labels for the pie charts
        datasets: [{
            data: [fishTankQuality,100-fishTankQuality], // Values for the first pie chart (percentages)
            backgroundColor: ["#00bfff33", "#aaaaaa00"], // Colors for the first pie chart slices
            borderWidth: 1, // Border width of the first pie chart slices
            borderColor: "#00b2ff" // Border color of the first pie chart slices
        }, {
            data: [bioFilterQuality,100-bioFilterQuality], // Values for the second pie chart (percentages)
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

document.getElementById('mainright').innerHTML = `Fish Tank</br><b style="font-size: 40px;">${fishTankQuality}%</b>`;
document.getElementById('mainleft').innerHTML = `Biofilter</br><b style="font-size: 40px;">${bioFilterQuality}%</b>`;
<?php } ?>
    </script>
</body>
</html>
