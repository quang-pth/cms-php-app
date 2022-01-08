<?php 
    include "../security/csrf/confirm_csrf.php";
?>

<?php 
    if(isset($_GET['p_id'])) {
        $post_id_to_edit = preg_replace('/[^A-Za-z0-9 \-]/', '', $_GET['p_id']); // removes special characters in query id
    }
    
    $query = "SELECT * FROM posts WHERE post_id = {$post_id_to_edit}";
    $select_posts_by_id = mysqli_query($connection, $query);
    confirmQuery($select_posts_by_id);

    while($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_content = $row['post_content'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
    }

    if(isset($_POST['update_post'])) {
        updatePost($post_id_to_edit);
   }   

?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="hidden_token" value="<?php echo $_SESSION['csrf'] ?>">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $post_title; ?>">
    </div>
    <div class="form-group">
        <select name="post_category" id="post_category">
            <?php 
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection, $query);
                confirmQuery($select_categories);

                while($row = mysqli_fetch_assoc($select_categories)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="author" value="<?php echo $post_author; ?>">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status: </label>
        <select name="post_status" id="post_status">
            <option value="<?php echo $post_status; ?>"><?php echo ucfirst($post_status) ?></option>
            <?php 
                if($post_status == 'published') {
                    echo "<option value='draft'>Draft</option>";
                } else {
                    echo "<option value='published'>Publish</option>";
                }
            ?>
        </select>
    </div>

    <!-- <div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" class="form-control" name="post_status" value="<?php echo $post_status; ?>">
    </div> -->
    <div class="form-group">
        <img style="width: 100px;" src="../images/<?php echo $post_image ?>" alt="Post Image">
        <input type="file" class="form-control" name="image">

    </div>
    <div class="form-group">
        <label for="post_author">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"><?php echo $post_content; ?>
        </textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>
</form>