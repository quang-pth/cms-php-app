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

function confirmQuery($query_result) {
    global $connection;
    if(!$query_result) {
            die("QUERY FAILED" . mysqli_errno($connection));
    }
}

function insert_categories() {   
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $cat_title = trim(str_replace('-', '', $cat_title)); // remove sql comment syntax
            $cat_title = preg_replace('/[^A-Za-z0-9 \-]/', '', $cat_title); // Removes special chars.
            $query = "INSERT INTO categories(cat_title)";
            $query .= " VALUE('{$cat_title}')";
            
            $create_category_query = mysqli_query($connection, $query);
            if(!$create_category_query) {
                die('QUERY FAILED'. mysqli_error($connection));
            }
        }
    }
}

function findAllCategories() {
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);
            
    while($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function deleteCategories() {
    global $connection;
     if (isset($_GET['delete'])) {
        $cat_id_to_delete = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$cat_id_to_delete}";
        $delete_query = mysqli_query($connection, $query);
        if (!$delete_query) {
            die('QUERY FAILED'. mysqli_error($connection));
        }
        header("Location: categories.php"); // refresh page
    }
}

function createPost() {
    global $connection;
    $hidden_token = $_POST['hidden_token'];
    $isValid = confirmCSRF($hidden_token);
    if ($isValid) {
        $post_title = preg_replace('/[^A-Za-z0-9 \-]/', '', trim($_POST['title']));
        $post_author = preg_replace('/[^A-Za-z0-9 \-]/', '', trim($_POST['author']));
        $post_category_id = preg_replace('/[^A-Za-z0-9 \-]/', '', trim($_POST['post_category']));
        $post_status = preg_replace('/[^A-Za-z0-9 \-]/', '', trim($_POST['post_status']));
        
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];

        $post_tags = preg_replace('/[^A-Za-z0-9 \-]/', '', trim($_POST['post_tags']));
        $post_content = mysqli_escape_string($connection, $_POST['post_content']);
        // $post_date = date('d-m-y');
        $post_comment_count = 0;

        // store image 
        move_uploaded_file($post_image_temp, "../images/$post_image");
        $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status)";

        $query .= " VALUES({$post_category_id}, '{$post_title}', '{$post_author}',  now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', '{$post_status}' )";

        $create_post_query = mysqli_query($connection, $query);
        confirmQuery($create_post_query);
        // get lastest post id to redirect user
        $created_post_id = mysqli_insert_id($connection);

        echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$created_post_id}'>View Post</a> or <a href='posts.php'>Edit More Posts</a> </p>";
    } else {
        die('NOT VALID SESSION, REQUEST FAILED!');
    }
}

function updatePost($post_id_to_edit) {
    global $connection;
    $hidden_token = $_POST['hidden_token'];
    $isValid = confirmCSRF($hidden_token);
    if ($isValid) {
        $post_title = preg_replace('/[^A-Za-z0-9 \-]/', '', trim($_POST['title']));
        $post_author = preg_replace('/[^A-Za-z0-9 \-]/', '', trim($_POST['author']));
        $post_category_id = preg_replace('/[^A-Za-z0-9 \-]/', '', trim($_POST['post_category']));
        $post_status = preg_replace('/[^A-Za-z0-9 \-]/', '', trim($_POST['post_status']));
        
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];

        $post_tags = preg_replace('/[^A-Za-z0-9 \-]/', '', trim($_POST['post_tags']));
        $post_content = mysqli_escape_string($connection, $_POST['post_content']);

        move_uploaded_file($post_image_temp, "../images/$post_image");
        if(empty($post_image)) {
            $query = "SELECT * FROM posts WHERE post_id = $post_id_to_edit";
            $select_image = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_image)) {
                $post_image = $row['post_image'];
            }
        }

        $query = "UPDATE posts SET ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_category_id = '{$post_category_id}', ";
        $query .= "post_date = now(), ";
        $query .= "post_author = '{$post_author}', ";
        $query .= "post_status = '{$post_status}', ";
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_content = '{$post_content}', ";
        $query .= "post_image = '{$post_image}' ";
        $query .= "WHERE post_id = {$post_id_to_edit}";

        $update_post = mysqli_query($connection, $query);
        confirmQuery($update_post);
        
        echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$post_id_to_edit}'>View Post</a> or <a href='posts.php'>Edit More Posts</a> </p>";
    } else {
        die('NOT VALID SESSION, REQUEST FAILED!');
    }
}

function santizeData($data) {
    return trim(preg_replace('/[^A-Za-z0-9 @.\-]/', '', $data));
}