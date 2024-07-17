<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../vendor/autoload.php';

$_PCENV = 'D:\Projects\UMS\LI\Aqua-UMS';
$_AWSENV = '/home/ec2-user/Aqua-UMS/';

$dotenv = Dotenv\Dotenv::createImmutable($_AWSENV);
$dotenv->load();

$GLOBALS['HOSTNAME'] = $_ENV['HOSTNAME'];


$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
