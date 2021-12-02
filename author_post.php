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
                All Post By 
                <small><?php echo santizeData($_GET['author']) ?></small>
            </h1>

            <!-- First Blog Post -->
            <?php 
                if(isset($_GET['p_id'])) {
                    $post_id_to_view = santizeData($_GET['p_id']);
                    $post_author = santizeData($_GET['author']);

                    $query = "SELECT * FROM posts WHERE post_author = '{$post_author}'";
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
                        <p><span class="glyphicon glyphicon-time"></span> 
                        <?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <hr>            
                        <?php
                    }
                    }
            ?>
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
