<?php 
    include "./admin/functions.php"
?>

<?php
    require 'vendor/autoload.php';
    include "includes/db.php";
?>

<?php 
    include "includes/header.php";

?>

<!-- Navigation -->
<?php 
    include "includes/nav.php";
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

            <!-- First Blog Post -->
            <?php 
                if(isset($_GET['p_id'])) {
                    $post_id_to_view = santizeData($_GET['p_id']);

                    $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $post_id_to_view";
                    $send_query = mysqli_query($connection, $view_query);
                    confirmQuery($send_query);
                    
                    $query = "SELECT * FROM posts WHERE post_id = $post_id_to_view";
                    $select_post_query = mysqli_query($connection, $query);
                    confirmQuery($select_post_query);
                    while($row = mysqli_fetch_assoc($select_post_query)) {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        ?>         
                        <h2>
                            <a href="#"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> 
                        <?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <hr>            
                        <?php
                    } 
                } else {
                    header("Location: index.php");
                }
            ?>

            <!-- Blog Comments -->
            <?php 
                if (isset($_POST['create_comment'])) {
                    $post_id = $_GET['p_id'];
                    $comment_author = santizeData($_POST['comment_author']); 
                    $comment_email = santizeData($_POST['comment_email']); 
                    $comment_content = mysqli_escape_string($connection, $_POST['comment_content']); 

                    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                        $query .= "VALUES ($post_id, '{$comment_author}', '{$comment_email}', '$comment_content', 'unapproved', now())";
                        
                        $create_comment_query = mysqli_query($connection, $query);
                        confirmQuery($create_comment_query);
                        // increase post comment count
                        $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $post_id";
                        $increase_comment_count_query = mysqli_query($connection, $query);
                        confirmQuery($increase_comment_count_query);
                    } else {
                        echo "<script>alert('Fields cannot be empty')</script>";
                    }
                }
            ?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="post.php?p_id=<?php echo $post_id_to_view ?>" method="post">
                        <div class="form-group">
                            <label for="Author">Author</label>
                            <input id="Author" type="text" class="form-control" rows="3" name="comment_author" required>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" id="Email" class="form-control" rows="3" name="comment_email" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Your comment</label>
                            <textarea id="comment" name="comment_content" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <!-- Comment -->
                <?php 
                    $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id_to_view} ";
                    $query .= "AND comment_status = 'approved' ";
                    $query .= "ORDER BY comment_id DESC";

                    $select_comment_query = mysqli_query($connection, $query);
                    confirmQuery($select_comment_query);
                    
                    while ($row = mysqli_fetch_array($select_comment_query)) {
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];
                        ?>
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author ?>
                                    <small><?php echo $comment_date ?></small>
                                </h4>
                                <p>
                                    <?php echo $comment_content ?>
                                </p> 
                            </div>
                        </div>

                    <?php } ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php 
            include "includes/sidebar.php"
        ?>

    </div>
    <!-- /.row -->

    <hr>

<?php 
    include "includes/footer.php";
    
?>
