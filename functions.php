<?php
function users_online() {
    if(isset($_GET['onlineusers'])) {        
        global $connection;    

        if(!$connection) {
            session_start();
            include("includes/db.php");
            
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 5;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session' ";
            $send_query = mysqli_query($connection, $query);
            confirmQuery($send_query);

            $count = mysqli_num_rows($send_query);
            if($count == NULL) { // new user online
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
            } else { // extend current logged-in user session
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }
            
            $user_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
            echo mysqli_num_rows($user_online_query);
        }
    } // end GET onlineusers
}

users_online();