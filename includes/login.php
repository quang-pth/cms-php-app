<?php 
    require '../vendor/autoload.php';
    include "db.php"; 
?>

<?php include "../admin/functions.php" ?>
<?php include "../security/csrf/confirm_csrf.php" ?>

<!-- turn on session to set logged in user's info -->
<?php 
    session_start();
?>

<?php
    if(isset($_POST['login'])) {
        $hidden_token = $_POST['csrf_token'];
        $isValid = confirmCSRF($hidden_token);

        if($isValid) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            // clean data prevent SQL Injection
            $username = mysqli_real_escape_string($connection, $username); 
            $password = mysqli_real_escape_string($connection, $password); 

            $query = "SELECT * FROM users WHERE username = '{$username}'";
            $select_user_query = mysqli_query($connection, $query);
            confirmQuery($select_user_query);

            while($row = mysqli_fetch_array($select_user_query)) {
                $db_user_id = $row['user_id'];
                $db_username = $row['username'];
                $db_user_password = $row['user_password'];
                $db_user_firstname = $row['user_firstname'];
                $db_user_lastname = $row['user_lastname'];
                $db_user_role = $row['user_role'];
                $db_randSalt = $row['randSalt'];
            }

            if (password_verify($password, $db_user_password)) {
                $_SESSION['username'] = $db_username;
                $_SESSION['firstname'] = $db_user_firstname;
                $_SESSION['lastname'] = $db_user_lastname;
                $_SESSION['user_role'] = $db_user_role;
                $_SESSION['csrf'] = md5(uniqid());
                header("Location: ../admin");
            } else {
                header("Location: ../index.php");
            }
        } else {
            die('SESSION NOT VALID! REQUEST FAILED');
        }

    }
?>