<?php
use app\models\DBHandler;
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=satao.db.elephantsql.com;port=5432;dbname=dxtshkjc',
    'username' => 'dxtshkjc',
    'password' => DBHandler::getDBPassword(),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
