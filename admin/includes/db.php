<?php 
    define('DB_HOST', 'localhost');
    define('DB_USER', 'quang');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'cms');
    define('DB_PORT', '3306');

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

    if ($connection) {
        // echo "We are connected";
    } else {
        echo DB_HOST;
        echo DB_USER;
        echo DB_PASSWORD;
        echo DB_NAME;
        echo DB_PORT;
        echo "Cant connect to database";
    }


?>