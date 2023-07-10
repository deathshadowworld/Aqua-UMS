<?php // Get the database connection
$db = Yii::$app->db;

// Prepare the SQL query
#$sql = 'SELECT user_id, username, password, email, admin FROM "user" WHERE username = :username';
#$params = [':username' => 'same'];

// Execute the query and fetch the result
#$user = $db->createCommand($sql, $params)->queryOne();


$db = Yii::$app->db;
$users = $db -> createCommand('SELECT * FROM "user";') -> queryAll();
$usernames = $db -> createCommand('SELECT username FROM "user";') ->queryAll();



if ($users !== false) {
    // User record found

    foreach($usernames as $index => $username){
        if ($username['username'] == 'marisakirisame'){
            $key = $index;
        }
    }

    if ($key !== false){
        print $users[$key]['fullname'];
    }
    else {
        print "key not found";
    }

    // Do something with the user attributes
    // ...
    

} else {
    print "not found";
    // User record not found
    // Handle the case when the user doesn't exist
    // ...
}
?>
