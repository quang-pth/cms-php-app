<?php 
    include "./admin/functions.php"
?>

<?php 
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
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>            
                        <?php
                    }
                    }
            ?>

            <!-- Blog Comments -->
            <?php 
                if (isset($_POST['create_comment'])) {
                    $post_id = $_GET['p_id'];
                    $comment_author = santizeData($_POST['comment_author']); 
                    $comment_email = santizeData($_POST['comment_email']); 
                    $comment_content = santizeData($_POST['comment_content']); 

                    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                    $query .= "VALUES ($post_id, '{$comment_author}', '{$comment_email}', '$comment_content}', 'unapproved', now())";
                    
                    $create_comment_query = mysqli_query($connection, $query);
                    confirmQuery($create_comment_query);
                }
            ?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="post.php?p_id=<?php echo $post_id_to_view ?>" method="post">
                        <div class="form-group">
                            <label for="Author">Author</label>
                            <input id="Author" type="text" class="form-control" rows="3" name="comment_author">
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" id="Email" class="form-control" rows="3" name="comment_email">
                        </div>
                        <div class="form-group">
                            <label for="comment">Your comment</label>
                            <textarea id="comment" name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    </div>
                </div>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        <!-- Nested Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
                        <!-- End Nested Comment -->
                    </div>
                </div>

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
