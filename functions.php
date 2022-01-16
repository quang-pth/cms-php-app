<?php
function users_online() {
    if(isset($_GET['onlineusers'])) {        
        global $connection;    

        if(!$connection) {
            session_start();
            require("vendor/autoload.php");
            include("includes/db.php");
            
            $session = session_id();
            $time = time();

            $query = "SELECT * FROM users_online WHERE session = '$session' ";
            $send_query = mysqli_query($connection, $query);
            confirmQuery($send_query);

            $count = mysqli_num_rows($send_query);
            if($count == NULL) { // new user online
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
            } else { // extend current logged-in user session
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }
            
           echo $session;
        }
    } // end GET onlineusers
}

users_online();

function confirmQuery($query_result) {
    global $connection;
    if(!$query_result) {
            die("QUERY FAILED" . mysqli_errno($connection));
    }
}