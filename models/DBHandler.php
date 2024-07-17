<?php

namespace app\models;

use Yii;

class DBHandler
{

    public static function getDBPassword()
    {
        return $_ENV['DB_Password'];
    }

    public function __construct()
    {

    }
    #############################
    #                           #
    #                           #
    #       GET TABLES          #
    #                           #
    #                           #
    #############################
    public static function getUser()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "SELECT * FROM \"user\";";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        $listresult = array();
        foreach ($list as $each) {
            $listresult[(string) $each['id']] = [
                ########
                'id' => $each['id'],
                'username' => $each['username'],
                'password' => $each['password'],
                'fullname' => $each['fullname'],
                'email' => $each['email'],
                'admin' => $each['admin'],
                'authKey' => $each['authkey'],
                'accessToken' => $each['accesstoken'],
                ########
            ];
        }
        pg_close($connection);
        return $listresult;
    }
    public static function getOrg()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "SELECT * FROM \"organization\";";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        $listresult = array();
        foreach ($list as $each) {
            $listresult[(string) $each['id']] = [
                ########
                'id' => $each['id'],
                'username' => $each['username'],
                'password' => $each['password'],
                'fullname' => $each['fullname'],
                'email' => $each['email'],
                'admin' => $each['admin'],
                'authKey' => $each['authkey'],
                'accessToken' => $each['accesstoken'],
                ########
            ];
        }
        pg_close($connection);
        return $listresult;
    }
    public static function getAssoc()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "SELECT * FROM \"association\";";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        $listresult = array();
        foreach ($list as $each) {
            $listresult[(string) $each['id']] = [
                ########
                'id' => $each['id'],
                'username' => $each['username'],
                'password' => $each['password'],
                'fullname' => $each['fullname'],
                'email' => $each['email'],
                'admin' => $each['admin'],
                'authKey' => $each['authkey'],
                'accessToken' => $each['accesstoken'],
                ########
            ];
        }
        pg_close($connection);
        return $listresult;
    }
    public static function getTank()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "SELECT * FROM \"tank\";";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        $listresult = array();
        foreach ($list as $each) {
            $listresult[] = [
                ########
                'id' => $each['tank_id'],
                'name' => $each['name'],
                'desc' => $each['description'],
                'location' => $each['location'],
                'org_id' => $each['org_id'],
            ];
        }


        pg_close($connection);
        return $listresult;
    }

    public static function getSensor()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "SELECT * FROM \"sensor\";";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        $listresult = array();
        foreach ($list as $each) {
            $listresult[] = [
                ########
                'id' => $each['sensor_id'],
                'tank' => $each['tank_id'],
                'name' => $each['name'],
                'type' => $each['type'],
            ];
        }
        pg_close($connection);
        return $listresult;
    }

    public static function findSensor($id)
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "SELECT * FROM \"sensor\" WHERE sensor_id = $id";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_assoc($result);
        pg_close($connection);
        return $list;
    }
    public static function getMessage()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "SELECT * FROM \"message\";";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        $listresult = array();
        foreach ($list as $each) {
            $listresult[(string) $each['id']] = [
                ########
                'id' => $each['id'],
                'username' => $each['username'],
                'password' => $each['password'],
                'fullname' => $each['fullname'],
                'email' => $each['email'],
                'admin' => $each['admin'],
                'authKey' => $each['authkey'],
                'accessToken' => $each['accesstoken'],
                ########
            ];
        }
        pg_close($connection);
        return $listresult;
    }
    public static function getLog()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "SELECT * FROM \"waterlog\";";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        $listresult = array();
        foreach ($list as $each) {
            $listresult[(string) $each['id']] = [
                ########
                'id' => $each['id'],
                'username' => $each['username'],
                'password' => $each['password'],
                'fullname' => $each['fullname'],
                'email' => $each['email'],
                'admin' => $each['admin'],
                'authKey' => $each['authkey'],
                'accessToken' => $each['accesstoken'],
                ########
            ];
        }
        pg_close($connection);
        return $listresult;
    }
    public static function getParam()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "SELECT * FROM \"parameter\";";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        $listresult = array();
        foreach ($list as $each) {
            $listresult[] = [
                ########
                'id' => $each['tank_id'],
                'ph_min' => $each['ph_min'],
                'ph_max' => $each['ph_max'],
                'do_min' => $each['do_min'],
                'do_max' => $each['do_max'],
                'salinity_min' => $each['salinity_min'],
                'salinity_max' => $each['salinity_max'],
                'ammonia_min' => $each['ammonia_min'],
                'ammonia_max' => $each['ammonia_max'],
                'nitrate_min' => $each['nitrate_min'],
                'nitrate_max' => $each['nitrate_max'],
                'turbidity_min' => $each['turbidity_min'],
                'turbidity_max' => $each['turbidity_max'],
                'temp_min' => $each['temp_min'],
                'temp_max' => $each['temp_max'],
                'depth_min' => $each['depth_min'],
                'depth_max' => $each['depth_max'],
                'cycle_length' => $each['cycle_length'],

                ########
            ];
        }
        pg_close($connection);
        return $listresult;
    }

    #############################
    #                           #
    #                           #
    #                           #
    #                           #
    #                           #
    #############################
    public static function getAdmins()
    {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        $query = "SELECT id,fullname FROM \"user\" WHERE admin = true;";
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        pg_close($connection);
        return $list;
    }
    public static function getNonAdmins()
    {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        $query = "SELECT id,fullname FROM \"user\" WHERE admin = false;";
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        pg_close($connection);
        return $list;
    }


    public static function getUserIDs()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        $query = "SELECT id FROM \"user\";";
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        #####
        $idlist = array();
        foreach ($list as $each) {
            $idlist[] = $each['id'] . '';
        }
        pg_close($connection);
        return $idlist;
    }
    public static function getTankIDs()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        $query = "SELECT tank_id FROM \"tank\";";
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        #####
        $idlist = array();
        foreach ($list as $each) {
            $idlist[] = $each['tank_id'] . '';
        }
        pg_close($connection);
        return $idlist;
    }
    public static function getSensorIDs()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        $query = "SELECT sensor_id FROM \"sensor\";";
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        #####
        $idlist = array();
        foreach ($list as $each) {
            $idlist[] = $each['sensor_id'] . '';
        }
        pg_close($connection);
        return $idlist;
    }
    public static function getMessageIDs()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        $query = "SELECT message_id FROM \"message\";";
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        #####
        $idlist = array();
        foreach ($list as $each) {
            $idlist[] = $each['message_id'] . '';
        }
        pg_close($connection);
        return $idlist;
    }
    public static function getLogIDs()
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        $query = "SELECT log_id FROM \"waterlog\";";
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        #####
        $idlist = array();
        foreach ($list as $each) {
            $idlist[] = $each['log_id'] . '';
        }
        pg_close($connection);
        return $idlist;
    }

    public static function getUsernamebyID($id)
    {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        $query = "SELECT username FROM \"user\" WHERE id = $id;";
        $result = pg_query($connection, $query);
        $list = pg_fetch_assoc($result)['username'];
        pg_close($connection);
        return $list;
    }
    public static function getUsernamesbyID()
    {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        $query = "SELECT username FROM \"user\";";
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        $idlist = array();
        foreach ($list as $each) {
            $idlist[] = $each['username'];
        }

        pg_close($connection);
        return $idlist;
    }

    public static function searchUsernameDuplicate($name)
    {
        $list = self::getUsernamesbyID();
        foreach ($list as $each) {
            if ($name == $each) {
                return false;
            }
        }
        return true;
    }

    public static function generateUserID()
    {
        $list = DBHandler::getUserIDs();
        $id = mt_rand(100000, 999999) . '';
        $__id = false;
        $__stop = true;
        while ($__stop) {
            foreach ($list as $each) {
                if ($id == $each) {
                    $__id = true;
                } else {
                    $__id = false;
                }
            }
            if ($__id) {
                $id = mt_rand(100000, 999999) . '';
            } else {

                $__stop = false;
            }
        }
        return $id;
    }
    public static function generateTankID()
    {
        $list = DBHandler::getTankIDs();
        $id = mt_rand(100000, 999999) . '';
        $__id = false;
        $__stop = true;
        while ($__stop) {
            foreach ($list as $each) {
                if ($id == $each) {
                    $__id = true;
                } else {
                    $__id = false;
                }
            }
            if ($__id) {
                $id = mt_rand(100000, 999999) . '';
            } else {

                $__stop = false;
            }
        }
        return $id;
    }
    public static function generateSensorID()
    {
        $list = DBHandler::getSensorIDs();
        $id = mt_rand(100000, 999999) . '';
        $__id = false;
        $__stop = true;
        while ($__stop) {
            foreach ($list as $each) {
                if ($id == $each) {
                    $__id = true;
                } else {
                    $__id = false;
                }
            }
            if ($__id) {
                $id = mt_rand(100000, 999999) . '';
            } else {

                $__stop = false;
            }
        }
        return $id;
    }



    public static function generateLogID()
    {
        $list = DBHandler::getLogIDs();
        $id = mt_rand(100000, 999999) . '';
        $__id = false;
        $__stop = true;
        while ($__stop) {
            foreach ($list as $each) {
                if ($id == $each) {
                    $__id = true;
                } else {
                    $__id = false;
                }
            }
            if ($__id) {
                $id = mt_rand(100000, 999999) . '';
            } else {

                $__stop = false;
            }
        }
        return $id;
    }

    public static function generateMessageID()
    {
        $list = DBHandler::getMessageIDs();
        $id = mt_rand(100000, 999999) . '';
        $__id = false;
        $__stop = true;
        while ($__stop) {
            foreach ($list as $each) {
                if ($id == $each) {
                    $__id = true;
                } else {
                    $__id = false;
                }
            }
            if ($__id) {
                $id = mt_rand(100000, 999999) . '';
            } else {

                $__stop = false;
            }
        }
        return $id;
    }

    public static function addUser($user)
    {

        $username = $user->username;
        $password = hash('sha256', $user->password);
        $fullname = $user->fullname;
        $email = $user->email;
        $id = self::generateUserID();
        $authkey = 'key-' . $id . '-auth';
        $token = 'token-' . $id . '-access';
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $dbpassword = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$dbpassword");
        $query = "INSERT INTO \"user\" (id,username,password,fullname,email,admin,authkey,accesstoken) VALUES (" . $id . ",'" . $username . "','" . $password . "','" . $fullname . "','" . $email . "',false,'" . $authkey . "','" . $token . "');";
        $result = pg_query($connection, $query);
        pg_close($connection);
        return $result;
    }

    public static function addTank($tank)
    {
        $name = $tank['name'];
        $desc = $tank['desc'];
        $location = $tank['location'];
        $id = self::generateTankID();
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $dbpassword = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$dbpassword");
        $query = "INSERT INTO \"tank\" (tank_id,name,description,location,org_id) VALUES (" . $id . ",'" . $name . "','" . $desc . "','" . $location . "',0);";
        $resulttank = pg_query($connection, $query);
        pg_close($connection);
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$dbpassword");
        $query = "INSERT INTO \"parameter\" 
        (tank_id,ph_min,
        ph_max,
        do_min,
        do_max,
        salinity_min,
        salinity_max,
        ammonia_min,
        ammonia_max,
        nitrate_min,
        nitrate_max,
        turbidity_min,
        turbidity_max,
        temp_min,
        temp_max,
        depth_min,
        depth_max,
        cycle_length)
        VALUES (
            $id,6,8,0,0,0,0,0,0,0,0,0,0,23,30,0,0,60
        );";
        $result = pg_query($connection, $query);
        $mid = $id + 1;
        $mid2 = $mid + 1;
        $mid3 = $mid2 + 1;
        $query = "INSERT INTO \"message\" (message_id,type,tank_id,time_posted,content) VALUES 
        ($mid,  0, $id, NOW(), 'Warning Content'),
        ($mid2, 1, $id, NOW(), 'Sensor Content'),
        ($mid3, 2, $id, NOW(), 'Forecast Content')";
        pg_query($connection, $query);


        pg_close($connection);
        return $resulttank;
    }



    public static function addSensor($new)
    {
        $name = $new['name'];
        $type = $new['type'];
        $tank = $new['tank'];
        $id = self::generateSensorID();
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $dbpassword = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$dbpassword");
        $query = "INSERT INTO \"sensor\" (sensor_id,tank_id,name,type) VALUES (" . $id . ",'" . $tank . "','" . $name . "','" . $type . "');";
        $result = pg_query($connection, $query);
        pg_close($connection);
        return $id;
    }

    public static function addLog($new)
    {
        $sensor_id = $new['sensor_id'];
        $datetime = $new['datetime'];
        $ph = $new['ph'];
        $do = $new['do'];
        $sal = $new['sal'];
        $amm = $new['amm'];
        $nit = $new['nit'];
        $tur = $new['tur'];
        $temp = $new['temp'];
        $dep = $new['dep'];
        $type = $new['type'];
        $id = self::generateLogID();
        $tank_id = self::findTankforSensor($sensor_id);
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $dbpassword = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$dbpassword");
        $query = "INSERT INTO \"waterlog\" (log_id,sensor_id,time_taken,\"pH\",\"Do\",salinity,ammonia, nitrate, turbidity,temp,depth,type) VALUES 
        (" . $id . ",'" . $sensor_id . "','" . $datetime . "','" . $ph . "','" . $do . "','" . $sal . "','" . $amm . "','" . $nit . "','" . $tur . "','" . $temp . "','" . $dep . "','" . $type . "');";
        $result = pg_query($connection, $query);
        $query = "INSERT INTO \"message\" (message_id,type,tank_id,time_posted,content) VALUES 
        ($id,  1, $tank_id, NOW(), 'Data is collected.')";
        pg_query($connection, $query);

        pg_close($connection);
        return $result;
    }

    #############################
    #                           #
    #                           #
    #                           #
    #                           #
    #############################

    public static function findTankforSensor($value)
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        #####
        $query = "SELECT tank_id FROM \"sensor\" WHERE sensor_id = '$value';";
        $result = pg_query($connection, $query);
        $row = pg_fetch_assoc($result);
        pg_close($connection);
        return $row['tank_id'];
    }

    public static function findUser($value)
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        #####
        $query = "SELECT * FROM \"user\" WHERE username = '$value';";
        $result = pg_query($connection, $query);
        $row = pg_fetch_assoc($result);
        return $row;
    }

    public static function findAdmin()
    {
        $user = self::findUser(Yii::$app->user->identity->username);
        if (Yii::$app->user->identity->admin == 't') {
            return true;
        } else {
            return false;
        }
    }

    public static function findMaster()
    {
        if (Yii::$app->user->identity->id == '815121') {
            return true;
        } else {
            return false;
        }
    }

    public static function findAdminbyID($id)
    {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = DBHandler::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        $query = "SELECT admin FROM \"user\" WHERE id = '$id';";
        $result = pg_query($connection, $query);
        $row = pg_fetch_assoc($result);
        if ($row) {
            if ($row['admin'] == 't') {
                return true;
            }
        }
        return false;
    }

    public static function findTankSensors($id)
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        #####
        $query = "SELECT sensor_id FROM \"sensor\" WHERE tank_id = '$id';";
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        return $list;
    }

    public static function findTankParam($id)
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        #####
        $query = "SELECT * FROM \"parameter\" WHERE tank_id = '$id';";
        $result = pg_query($connection, $query);
        $list = pg_fetch_assoc($result);
        return $list;
    }

    public static function findSensorLogs($id)
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        #####
        $sensors = self::findTankSensors($id);
        $loglist = array();
        foreach ($sensors as $each) {
            $query = "SELECT * FROM \"waterlog\" WHERE sensor_id = $each[sensor_id];";
            $result = pg_query($connection, $query);
            $list = pg_fetch_all($result);
            $loglist[] = $list;
        }
        $loglist['sensor_ids'] = $sensors;
        return $loglist;
    }

    public static function findParam($value)
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "SELECT * FROM \"parameter\" WHERE tank_id = $value;";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_assoc($result);
        pg_close($connection);
        return $list;
    }

    public static function updateParam($tank)
    {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "UPDATE \"parameter\" SET 
        ph_min = $tank[ph_min],
        ph_max = $tank[ph_max],
        do_min = $tank[do_min],
        do_max = $tank[do_max],
        salinity_min = $tank[salinity_min],
        salinity_max = $tank[salinity_max],
        ammonia_min = $tank[ammonia_min],
        ammonia_max = $tank[ammonia_max],
        nitrate_min = $tank[nitrate_min],
        nitrate_max = $tank[nitrate_max],
        turbidity_min = $tank[turbidity_min],
        turbidity_max = $tank[turbidity_max],
        temp_min = $tank[temp_min],
        temp_max = $tank[temp_max],
        depth_min = $tank[depth_min],
        depth_max = $tank[depth_max],
        cycle_length = 60
        WHERE tank_id = $tank[tank_id];";

        $result = pg_query($connection, $query);
        $list = pg_fetch_assoc($result);
        pg_close($connection);
        return $list;
    }

    public static function sortedMessages($id)
    {
        #####
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        #####
        $query = "SELECT * FROM \"message\" WHERE tank_id = '$id';";
        $result = pg_query($connection, $query);
        $list = pg_fetch_all($result);
        $warning = array();
        $sensor = array();
        $forecast = array();
        $other = array();
        foreach ($list as $each) {
            if ($each['type'] == '0') {
                $warning[] = $each;
            } elseif ($each['type'] == '1') {
                $sensor[] = $each;
            } elseif ($each['type'] == '2') {
                $forecast[] = $each;
            } else {
                $other[] = $each;
            }
        }
        $messages = [
            'warning' => $warning,
            'sensor' => $sensor,
            'forecast' => $forecast,
            'other' => $other,
        ];
        return $messages;
    }

    public static function addAdmin($id)
    {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "UPDATE \"user\" SET admin = true WHERE id = $id;";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_assoc($result);
        pg_close($connection);
        return $list;
    }

    public static function removeAdmin($id)
    {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "UPDATE \"user\" SET admin = false WHERE id = $id;";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_assoc($result);
        pg_close($connection);
        return $list;
    }



    public static function updateUser($arr)
    {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        ####
        $query = "UPDATE \"user\" SET fullname = '$arr[fullname]', email = '$arr[email]' WHERE username = '$arr[username]';";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_assoc($result);
        pg_close($connection);
        return $list;
    }

    public static function updatePassword($arr)
    {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");
        $hashed = hash('sha256', $arr['password']);
        ####
        $query = "UPDATE \"user\" SET password = '$hashed' WHERE username = '$arr[username]';";
        ####
        $result = pg_query($connection, $query);
        $list = pg_fetch_assoc($result);
        pg_close($connection);
        return $list;
    }


    public static function deleteTank($id)
    {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = self::getDBPassword();
        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");

        $query = "DELETE FROM parameter WHERE tank_id = $id;";
        pg_query($connection, $query);

        $query = "DELETE FROM message WHERE tank_id = $id;";
        pg_query($connection, $query);

        $query = "DELETE FROM waterlog
    WHERE sensor_id IN (
        SELECT sensor_id
        FROM sensor
        WHERE tank_id = $id);";
        pg_query($connection, $query);

        $query = "DELETE FROM sensor
    WHERE tank_id = $id;";
        pg_query($connection, $query);

        $query = "DELETE FROM tank WHERE tank_id = $id;";
        pg_query($connection, $query);
        return true;
    }

}