<?php 
    session_start();

    if(isset($_SESSION['user_token'])) {
        $server_user_token = $_SESSION['user_token'];
        $local_user_token = $_POST['hidden_token'];
        if ($server_user_token === $local_user_token) {
            echo "This request is valid";
        } else {
            echo "Potential CSRF Vulnerable";
        }
    } else {
        echo "Nothing";
    }

    session_write_close();
?>