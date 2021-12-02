<?php
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '/../.env');
    $dotenv->load();

    define('DB_HOST', $_ENV['DB_HOST']);
    define('DB_USER', $_ENV['DB_USER']);
    define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
    define('DB_NAME', $_ENV['DB_NAME']);
    define('DB_PORT', $_ENV['DB_PORT']);

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