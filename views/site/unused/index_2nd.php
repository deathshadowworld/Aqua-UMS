
<?php

/** @var yii\web\View $this */

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
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821207343374417/LOGO_UMS_putih.png?ex=6684c0b4&is=66836f34&hm=af5e9a87bb0dda7b341400235baa3f8d9323dbd3c0657ee6275dae95cea2b05e&" style="max-height: 9vh;"></span>
        <span class="header"><b style="font-size: 30px;">Aqua UMS Project</b></br>Kerjasama Fakulti Komputeran dan Informatik dan Institut Penyelidikan Marin Borneo</span>
        <span class="header"><img src="https://cdn.discordapp.com/attachments/616833107965771776/1094821361966387350/EcoCampus-Putih.png?ex=6684c0d9&is=66836f59&hm=0fb2dbcc577308974208e89d2c2f8e6a39d4e87ff5822c27cb66677cb01fe47b&" style="max-height: 9vh;"></span>
        
    </div>

    <div class="" style="display: none;" id="monitorwindow">
    <div class="grid-container" style=" margin-bottom: 50px;">
        <div class="grid-item"></div>
        <div class="grid-item widget mini-widget" id="phdiv">pH Level<canvas id="chart7"></canvas></div>

        <div class="grid-item widget main-widget" style="position: relative;" id="scorediv">Water Quality Score
            <canvas id="mainChart" style="max-height: 450px;"></canvas>
            <span class="scoreleft" id="mainleft">Fish Tank</br><b style="font-size: 40px;">90%</b></span>
            <span class="scoreright" id="mainright">Biofilter</br><b style="font-size: 40px;">95%</b></span>
            
        </div>

        <div class="grid-item widget mini-widget" id="dodiv">Dissolved Oxygen<canvas id="chart1"></canvas></div>
        <div class="grid-item widget mini-widget " id="sadiv">Salinity<canvas id="charttwooooo"></canvas></div>

        <div class="grid-item small-widget widget" id="depthtankdiv">Fish Tank Depth<canvas id="chartbar1" style="max-height: 250px;"></canvas></div>
        <div class="grid-item small-widget widget" id="depthfilterdiv">Biofilter Depth<canvas id="chartbar2" style="max-height: 250px;"></canvas></div>

        <div class="grid-item widget mini-widget " id="amdiv">Ammonia<canvas id="chart3"></canvas></div>

        <div class="grid-item widget tank-widget" id="infodiv"><u>Tank Info</u></br></br>
            Tank Name: Grouper 01</br>
            Content: 50 Hybrid</br>
            Location: IPMB
            <span style="position: absolute; top: 40px; right:420px; border: solid; border-width: 1px; border-color: #cccccc; border-radius: 10px; width: 120px;padding: 4px;">
                Select Tank:
                <select style="width: 100px;" id="selecttankmain">
                    <option>Grouper 01</option>
                    <option>Grouper 02</option>
                    <option>Prawn 01</option>
                </select>
            </span>
        </div>

        <div class="grid-item row-end" style="grid-row: 9;"></div> <!--next line-->

        <div class="grid-item widget mini-widget" id="tudiv">Turbidity<canvas id="chart4"></canvas></div>
        <div class="grid-item widget mini-widget " id="nidiv">Nitrate<canvas id="chart5"></canvas></div>
        <div class="grid-item widget temp-widget " id="tempdiv">Temperature<canvas style="max-height: 175px;" id="chart6"></canvas></div>
          
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
                <tr>
                    <td>1</td>
                    <td>Rapid water depth changes</td>
                    <td>13:01 02/03/2023</td>
                </tr>
            </table>
        </div>
        <div class="grid-item widget messagecontent">
            <table>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:300px;">Sensor Log</th>
                    <th style="width:150px;">Timestamp</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Biofilter sensors data taken</td>
                    <td>13:00 02/03/2023</td>
                </tr>
            </table>
        </div>
        <div class="grid-item widget messagecontent">
            <table>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:300px;">Forecasts</th>
                    <th style="width:150px;">Timestamp</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Temperature rise in 3 minutes</td>
                    <td>13:06 02/03/2023</td>
                </tr>
            </table>
        </div>
    </div>
    
        <div id="modalwindow" style="background-color: #000000d7; height: 100vh; width:100vw; position:fixed; top: 0;right: 0; display: none; z-index: 3; ">
            <div class="widget-modal">
                Chart
                <canvas id="chart2"></canvas>
            </div>
        </div>
    </div> 

    <div class="mainscreen" style="display: none; padding: 0;" id="adminwindow">
        
        <h1>Admin Panel</h1>
        <div class="admin-container">
            <div class="admin-item bordered admin-select">
                Appoint Admin</br></br>
                <ul>
                    <li>Fellow 2    <button id="appoint1">Appoint</button></li>
                    <li>Fellow 4    <button id="appoint2">Appoint</button></li>
                    <li>Fellow 6    <button id="appoint3">Appoint</button></li>
                    <li>Fellow 2    <button id="appoint1">Appoint</button></li>
                    <li>Fellow 4    <button id="appoint2">Appoint</button></li>
                    <li>Fellow 6    <button id="appoint3">Appoint</button></li>
                    <li>Fellow 2    <button id="appoint1">Appoint</button></li>
                    <li>Fellow 4    <button id="appoint2">Appoint</button></li>
                    <li>Fellow 6    <button id="appoint3">Appoint</button></li>
                    <li>Fellow 2    <button id="appoint1">Appoint</button></li>
                    <li>Fellow 4    <button id="appoint2">Appoint</button></li>
                    <li>Fellow 6    <button id="appoint3">Appoint</button></li>
                    <li>Fellow 2    <button id="appoint1">Appoint</button></li>
                    <li>Fellow 4    <button id="appoint2">Appoint</button></li>
                    <li>Fellow 6    <button id="appoint3">Appoint</button></li>
                    <li>Fellow 2    <button id="appoint1">Appoint</button></li>
                    <li>Fellow 4    <button id="appoint2">Appoint</button></li>
                    <li>Fellow 6    <button id="appoint3">Appoint</button></li>
                    <li>Fellow 2    <button id="appoint1">Appoint</button></li>
                    <li>Fellow 4    <button id="appoint2">Appoint</button></li>
                    <li>Fellow 6    <button id="appoint3">Appoint</button></li>
                    <li>Fellow 2    <button id="appoint1">Appoint</button></li>
                    <li>Fellow 4    <button id="appoint2">Appoint</button></li>
                    <li>Fellow 6    <button id="appoint3">Appoint</button></li>
                </ul>
            </div>
            
            <div class="admin-item bordered">Add Tank</br></br>
                Tank Name<input type="text">
                Description<input type="text">
                Location<input type="text"></br></br>
                <button id="addtank">Add</button>
            </div>
            <div class="admin-item bordered admin-picker">
                Pick Tank/Update Parameters</br></br>
                <select style="width: 200px; position: absolute;">
                    <option>Tank 1</option>
                    <option>Tank 2</option>
                    <option>Tank 3</option>
                </select>
            </br></br>
            Description: Hybrid Grouper</br></br>
            Location: IPMB</br></br>
            <button id="appoint1">Update</button>
            </div>
            <div class="admin-item bordered">
                Remove Tank</br></br>
                <select style="width: 100px;">
                    <option>Tank 1</option>
                    <option>Tank 2</option>
                    <option>Tank 3</option>
                </select></br></br>
                Description: Hybrid Grouper</br></br>
                Location: IPMB</br></br>
                <button id="appoint1">Remove</button>
            </div>

            <div class="admin-item bordered admin-select">
                Revoke Admin</br></br>
                <ul>
                    <li>Fellow 1    <button id="revoke1">Revoke</button></li>
                    <li>Fellow 3    <button id="revoke2">Revoke</button></li>
                    <li>Fellow 5    <button id="revoke3">Revoke</button></li>
                </ul>

            </div>

            
            <div class="admin-item bordered">pH Level</br></br>
                Best Value<input type="text">
                Minimum Value<input type="text">
                Maximum Value<input type="text">
            </div>
            <div class="admin-item bordered">Dissolved Oxygen</br></br>
                Best Value<input type="text">
                Minimum Value<input type="text">
                Maximum Value<input type="text">
            </div>
            <div class="admin-item bordered">Salinity</br></br>
                Best Value<input type="text">
                Minimum Value<input type="text">
                Maximum Value<input type="text">
            </div>
            <div class="admin-item bordered">Ammonia</br></br>
                Best Value<input type="text">
                Minimum Value<input type="text">
                Maximum Value<input type="text">
            </div>
            <div class="admin-item bordered">Nitrate</br></br>
                Best Value<input type="text">
                Minimum Value<input type="text">
                Maximum Value<input type="text">
            </div>
            <div class="admin-item bordered">Turbidity</br></br>
                Best Value<input type="text">
                Minimum Value<input type="text">
                Maximum Value<input type="text">
            </div>
            <div class="admin-item bordered">Temperature</br></br>
                Best Value<input type="text">
                Minimum Value<input type="text">
                Maximum Value<input type="text">
            </div>
            <div class="admin-item bordered">Depth Level</br></br>
                Best Value<input type="text">
                Minimum Value<input type="text">
                Maximum Value<input type="text">
            </div>


        </div>


    </div>  

    <div class="mainscreen" style="display: block;" id="loginwindow">
        <div class="loginwindow">
            <h1>Login</h1>
            <h3 style="display: none; text-decoration: underline;">Username or password is incorrect.</h3>
            <h3>Username</h3>
            <input type="text">
            <h3>Password</h3>
            <input type="password"></br>
            <a href="https://www.youtube.com">Forgot password?</a></br></br>
            <button id="loginsubmit">Login</button></br></br>
            <button id="registerbutton">Register</button>
        </div>
    </div>

    <div class="mainscreen" style="display: none;" id="registerwindow">
        <div class="loginwindow" style="padding-top:5px; height: auto; padding-bottom: 25px;">
            <h1>Register</h1>
            <h3 style="display: none; text-decoration: underline;">Username already taken.</h3>
            <h3 style="display: none; text-decoration: underline;">E-mail already taken.</h3>
            <h3 style="display: none; text-decoration: underline;">Password mismatch.</h3>
            <h3>Username (max 16 characters)</h3>
            <input type="text">
            <h3>Password</h3>
            <input type="password">
            <h3>Retype Password</h3>
            <input type="password">
            <h3>Full Name</h3>
            <input type="text">
            <h3>E-mail</h3>
            <input type="text">
            
        </br></br><button id="registersubmit">Register</button>
        </div>
    </div>

    <div class="mainscreen" style="display: none;" id="profilewindow">
        <div class="loginwindow" style="padding-top:5px; height: auto; padding-bottom: 25px;">
            <h1>Update Profile</h1>
            <h3 style="display: none; text-decoration: underline;">E-mail already taken.</h3>
            <h3 style="display: none; text-decoration: underline;">Profile updated. Please return to home page.</h3>
            <h3>Username</h3>
            <input type="text" value="Username" readonly>
            <h3>Password</h3>
            <button id="changepass">Change Password</button>
            <h3>Full Name</h3>
            <input type="text" value="Full Name">
            <h3>E-mail</h3>
            <input type="text" value="E-Mail">
            
        </br></br><button id="updatesubmit">Update</button>
    </br></br><button id="backbutton">Back</button>
        </div>
    </div>

    <div class="mainscreen" style="display: none;" id="passwordwindow">
        <h1 id="passwordnotif" style="display: none;">Password Updated. Please close this window.</h1>
        <div id="passwordmenu" class="loginwindow" style="padding-top:5px; height: auto; padding-bottom: 25px; display: block;">
            
            <h1>Reset Password</h1>
            <h3 style="display: none; text-decoration: underline;">Password Mismatch</h3>
            <h3>Username</h3>
            <h3>Password</h3>
            <input type="password">
            <h3>Retype Password</h3>
            <input type="password">

            
        </br></br><button id="passwordsubmit">Update Password</button>
        </div>
    </div>

    <div class="bottomleftnav" style="display: none;" id="navbuttons">
        <div id="adminbutton" style="opacity: 0; visibility: visible;" class="navicon">Admin</div>
        <div id="homebutton" style="opacity: 0; visibility: visible;" class="navicon">Home</div>
        <div id="profilebutton" style="opacity: 0; visibility: visible;" class="navicon">Profile</div>
        <div id="logoutbutton" class="logout" >Logout</div>
    </div>
   

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    <?php $this->registerJsFile('https://cdn.discordapp.com/attachments/616833107965771776/1103139283482722374/scripts.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    ?>
    <script src="{% static 'scripts.js' %}"></script>
</body>
</html>
