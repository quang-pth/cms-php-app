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

        $query = "SELECT randSalt FROM users LIMIT 1";
        $select_randsalt_query = mysqli_query($connection, $query);
        confirmQuery($select_randsalt_query);
        $row = mysqli_fetch_array($select_randsalt_query);
        $salt = $row['randSalt'];
        $hashed_password = crypt($user_password, $salt);

        // store image 
        // move_uploaded_file($post_image_temp, "../images/$post_image");
        $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) ";

        $query .= " VALUES('{$user_firstname}', '{$user_lastname}',  '{$user_role}', '{$username}', '{$user_email}', '{$hashed_password}') ";

        $create_user_query = mysqli_query($connection, $query);
        confirmQuery($create_user_query);

        echo "User Created: " . " " . "<a href='users.php'>View Users</a>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" name="user_firstname" required>
    </div>
    <div class="form-group">
        <label for="title">Lastname</label>
        <input type="text" class="form-control" name="user_lastname" required>
    </div>
    <div class="form-group">
        <label for="user_role">User role:</label>
        <select name="user_role" id="user_role">
            <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>

    <!-- <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div> -->
    <div class="form-group">
        <label for="">Username</label>
        <input type="text" class="form-control" name="username" required>
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="text" class="form-control" name="user_email" required>
    </div>
    <div class="form-group">
        <label for="">Password</label>
        <input type="password" class="form-control" name="user_password" required>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>
</form>