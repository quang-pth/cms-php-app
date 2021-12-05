<?php 
    include "../security/csrf/confirm_csrf.php";
?>

<?php
    if(isset($_POST['create_post'])) {
       createPost();
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="hidden_token" value="<?php echo $_SESSION['user_token'] ?>">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
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
        <input type="text" class="form-control" name="author">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status: </label>
        <select name="post_status" id="post_status">
            <option value="draft" selected disabled>Selection Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
        </select>        
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_author">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>