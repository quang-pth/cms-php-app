<?php 
    $db['db_host'] = "localhost";     
    $db['db_user'] = "quang";     
    $db['db_password'] = "";     
    $db['db_name'] = "cms";
    $db['db_port'] = "3306";   

    // uppercase args to connect database
    foreach($db as $key => $value) {
        define(strtoupper($key), $value);
    }   

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

    if ($connection) {
        // echo "We are connected";
    } else {
        echo "Cant connect to database";
    }

?>