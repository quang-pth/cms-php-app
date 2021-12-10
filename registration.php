<?php include "admin/functions.php" ?>
<?php  
    require 'vendor/autoload.php';
    include "includes/db.php"; 
?>

<?php  
    include "includes/header.php";
?>

<?php 
    if(isset($_POST['submit'])) {
        $user_firstname = $_POST['user_firstname']; 
        $user_lastname = $_POST['user_lastname']; 
        $username = $_POST['username']; 
        $email = $_POST['email']; 
        $password = $_POST['password']; 
        $confirm_password = $_POST['confirm_password'];
        
        $fieldsNotEmpty = !empty($username) && !empty($email) && !empty($password); 
        if($fieldsNotEmpty) {
            if($password === $confirm_password) {
                $user_firstname = mysqli_real_escape_string($connection, $user_firstname);
                $user_lastname = mysqli_real_escape_string($connection, $user_lastname);
                $username = mysqli_real_escape_string($connection, $username);
                $email = mysqli_real_escape_string($connection, $email);
                $password = mysqli_real_escape_string($connection, $password);

                $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
                
                $query = "INSERT INTO users(username, user_email, user_password, user_firstname, user_lastname, user_image, user_role) ";
                $query .= "VALUES ('{$username}', '{$email}', '{$password}',  '{$user_firstname}', '{$user_lastname}', 0, 'subscriber') ";
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
                            <label for="firstname" class="sr-only">First Name</label>
                            <input type="text" name="user_firstname" id="firstname" class="form-control" placeholder="Enter Desired Firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">Last Name</label>
                            <input type="text" name="user_lastname" id="lastname" class="form-control" placeholder="Enter Desired Username" required>
                        </div>
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
