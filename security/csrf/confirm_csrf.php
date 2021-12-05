<?php 
    function confirmCSRF($hidden_token) {
        $isValidRequest = false;

        if(isset($_SESSION['user_token'])) {
            $server_user_token = $_SESSION['user_token'];
            $local_user_token = $hidden_token;
            if ($server_user_token === $local_user_token) {
                $isValidRequest = true;
            }
        }
        return $isValidRequest;
    }
?>