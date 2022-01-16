<?php 
    require 'vendor/autoload.php';
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
            <!-- First Blog Post -->
            <?php
                    if (isset($_POST['submit'])) {
                    $search = $_POST['search'];
                    // replace special characters
                    $search = str_replace(' ', '-', $search); // Replaces all spaces with hyphens.
                    $search = preg_replace('/[^A-Za-z0-9\-]/', '', $search); // Removes special chars.

                    $query = "SELECT * FROM posts WHERE post_status = 'published' and post_tags LIKE '%$search%' ";
                    $search_query = mysqli_query($connection, $query);

                    if (!$search_query) {
                        die("QUERY FAILED" . mysqli_error($connection));
                    }

                    $count = mysqli_num_rows($search_query);
                    
                    if($count == 0) {
                        echo "<h1>NO RESULTS</h1>";
                    } else {                        
                        while($row = mysqli_fetch_assoc($search_query)) {
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = $row['post_content'];
                            ?>         
                            <h2>
                                <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
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
                            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                            <hr>            
                        <?php
                        }
                        
                    }
                }?>
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
