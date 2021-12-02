<?php include "admin/functions.php" ?>
<?php  
    require 'vendor/autoload.php';
    include "includes/db.php"; 
?>

<?php  include "includes/header.php"; ?>

<?php 
    if(isset($_POST['submit'])) {
        $username = $_POST['username']; 
        $email = $_POST['email']; 
        $password = $_POST['password']; 
        $confirm_password = $_POST['confirm_password'];
        
        $fieldsNotEmpty = !empty($username) && !empty($email) && !empty($password); 
        if($fieldsNotEmpty) {
            if($password === $confirm_password) {
                $username = mysqli_real_escape_string($connection, $username);
                $email = mysqli_real_escape_string($connection, $email);
                $password = mysqli_real_escape_string($connection, $password);

                $query = "SELECT randSalt FROM users LIMIT 1";
                $select_randsalt_query = mysqli_query($connection, $query);
                confirmQuery($select_randsalt_query);

                $row = mysqli_fetch_array($select_randsalt_query);
                $salt = $row['randSalt'] ? $row['randSalt'] : '$2y$10$iusesomecrazystrings22';
                
                // encrypt password with salt
                $password = crypt($password, $salt);
                
                $query = "INSERT INTO users(username, user_email, user_password, user_role) ";
                $query .= "VALUES ('{$username}', '{$email}', '{$password}', 'subscriber') ";
                $register_user_query = mysqli_query($connection, $query);
                confirmQuery($register_user_query);
                
                $message = "Your Registration has been submit" ;
            } else {
                $message = "Confirm Password must be match";
            }
        } else {
            $message = "Fields cannot be empty";
        }
    } else {
        $message = "";
    }    

?>

    <!-- Navigation -->  
    <?php  include "includes/nav.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h6 class="text-center"><?php echo $message ?></h6>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" required>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" required>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password" required>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Confirm Password</label>
                            <input type="password" name="confirm_password" id="key" class="form-control" placeholder="Confirm Your Password" required>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
