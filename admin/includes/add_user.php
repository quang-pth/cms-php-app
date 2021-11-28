<?php
    if(isset($_POST['create_user'])) {
        $user_firstname = santizeData($_POST['user_firstname']);
        $user_lastname = santizeData($_POST['user_lastname']);
        $user_role = santizeData($_POST['user_role']);
        
        // $post_image = $_FILES['image']['name'];
        // $post_image_temp = $_FILES['image']['tmp_name'];

        $username = santizeData($_POST['username']);
        $user_email = trim(preg_replace('/[^A-Za-z0-9@.\-]/', '', $_POST['user_email']));
        $user_password = santizeData($_POST['user_password']);

        // store image 
        // move_uploaded_file($post_image_temp, "../images/$post_image");
        $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) ";

        $query .= " VALUES('{$user_firstname}', '{$user_lastname}',  '{$user_role}', '{$username}', '{$user_email}', '{$user_password}') ";

        $create_user_query = mysqli_query($connection, $query);
        confirmQuery($create_user_query);
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="title">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <select name="user_role" id="">
        <option value="subscriber">Select Options</option>
        <option value="admin">Admin</option>
        <option value="subscriber">Subscriber</option>
    </select>

    <!-- <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div> -->
    <div class="form-group">
        <label for="">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="text" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="">Password</label>
        <input type="text" class="form-control" name="user_password">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>
</form>