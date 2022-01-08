<?php
    if(isset($_GET['edit_user'])) {
        $user_id_to_edit = santizeData($_GET['edit_user']);
        $query = "SELECT * FROM users WHERE user_id = $user_id_to_edit";
        $select_user_by_id = mysqli_query($connection, $query);
        confirmQuery($select_user_by_id);
            
        while($row = mysqli_fetch_assoc($select_user_by_id)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
            $randSalt = $row['randSalt'];
        }
    }

    if(isset($_POST['edit_user'])) {
        $user_firstname = santizeData($_POST['user_firstname']);
        $user_lastname = santizeData($_POST['user_lastname']);
        $user_role = santizeData($_POST['user_role']);
        
        // $post_image = $_FILES['image']['name'];
        // $post_image_temp = $_FILES['image']['tmp_name'];

        $username = santizeData($_POST['username']);
        $user_email = trim(preg_replace('/[^A-Za-z0-9@.\-]/', '', $_POST['user_email']));
        $user_password = santizeData($_POST['user_password']);

        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));;

        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$hashed_password}' ";
        $query .= "WHERE user_id = {$user_id_to_edit}";

        $edit_user_query = mysqli_query($connection, $query);
        confirmQuery($edit_user_query);

        header("Location: users.php?source=edit_user&edit_user={$user_id_to_edit}");
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname ?>">
    </div>
    <div class="form-group">
        <label for="title">Lastname</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname ?>">
    </div>
    <div class="form-group">
        <label for="user_role">User role:</label>
        <select name="user_role" id="user_role">
            <option value="<?php echo $user_role; ?>"><?php echo ucfirst($user_role); ?></option>
            <?php 
                if($user_role == 'admin') {
                    echo "<option value='subscriber'>Subscriber</option>";
                } else {
                    echo "<option value='admin'>Admin</option>";
                }
            ?>
        </select>
    </div>

    <!-- <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div> -->
    <div class="form-group">
        <label for="">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username ?>">
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="text" class="form-control" name="user_email" value="<?php echo $user_email ?>">
    </div>
    <div class="form-group">
        <label for="">Password</label>
        <input type="password" class="form-control" name="user_password" autocomplete="off" required>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update">
    </div>
</form>