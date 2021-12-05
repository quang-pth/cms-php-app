<?php 
    function confirmCSRF($hidden_token) {
        $isValidRequest = false;
        if(isset($_SESSION['csrf'])) {
            $server_user_token = $_SESSION['csrf'];
            $local_user_token = $hidden_token;
            if ($server_user_token === $local_user_token) {
                $isValidRequest = true;
            }
        }
        return $isValidRequest;
    }
?>