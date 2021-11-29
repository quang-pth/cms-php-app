<?php include "db.php"; ?>
<?php include "../admin/functions.php" ?>

<?php 
    if(isset($_POST['feedback'])) {
        $message_author_email = santizeData($_POST['message_author_email']);
        $message_content = santizeData($_POST['message_content']);
        // store feedback
        $query = "INSERT INTO messages(message_author_email, message_content, created_at) ";
        $query .= "VALUES ('{$message_author_email}', '{$message_content}', now()) ";
        $create_feedback_query = mysqli_query($connection, $query);
        confirmQuery($create_feedback_query);

        header("Location: ../index.php");
    }

?>