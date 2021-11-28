<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $query);
            confirmQuery($select_users);
            
            while($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                $user_password = $row['user_password'];
                $user_firstname = $row['user_firstname'];
                $user_lastname = $row['user_lastname'];
                $user_email = $row['user_email'];
                $user_image = $row['user_image'];
                $user_role = $row['user_role'];
                
                echo "<tr>";
                echo "<td>$user_id</td>";
                echo "<td>$username</td>";
                echo "<td>$user_firstname</td>";
                
                // $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
                // $select_categories_id = mysqli_query($connection, $query);
                // while($row = mysqli_fetch_assoc($select_categories_id)) {
                //     $cat_id = $row['cat_id'];
                //     $cat_title = $row['cat_title'];
                //     echo "<td> $cat_title</td>";
                // }

                echo "<td>$user_lastname</td>";
                echo "<td>$user_email</td>";
                echo "<td>$user_role</td>";
                
                // $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                // $select_post_id_query = mysqli_query($connection, $query);
                // $exist = false; // comment related-post
                // while ($row = mysqli_fetch_assoc($select_post_id_query)) {
                //     $post_id = $row['post_id'];
                //     $post_title = $row['post_title'];
                //     echo "<td><a href='../post.php?p_id=$post_id'>$post_title</td>";
                //     $exist = true;
                // }
                // if(!$exist) {
                //     echo "<td>DELETED or NOT EXIST</td>";
                // }
                
                echo "<td><a href='comments.php?approve='>Approve</a></td>";
                echo "<td><a href='comments.php?unapprove='>Unapprove</a></td>";
                echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
                echo "</tr>";
            }
        ?>
        <?php 
            if(isset($_GET['approve'])) {
                $comment_id_to_approve = santizeData($_GET['approve']);
                $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$comment_id_to_approve} ";
                $approve_query = mysqli_query($connection, $query);
                confirmQuery($approve_query);
                header("Location: comments.php");
            }

            if(isset($_GET['unapprove'])) {
                $comment_id_to_unapprove = santizeData($_GET['unapprove']);
                $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$comment_id_to_unapprove} ";
                $unapprove_query = mysqli_query($connection, $query);
                confirmQuery($unapprove_query);
                header("Location: comments.php");
            }

            if(isset($_GET['delete'])) {
                $user_id_to_delete = santizeData($_GET['delete']);
                $query = "DELETE FROM users WHERE user_id = {$user_id_to_delete} ";
                $delete_query = mysqli_query($connection, $query);
                confirmQuery($delete_query);
                header("Location: users.php");
            }
        ?>
    </tbody>
</table>