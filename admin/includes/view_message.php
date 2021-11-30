<?php
    if(isset($_GET['m_id'])) {
        $message_to_view_id = santizeData($_GET['m_id']);
        $query = "SELECT * FROM messages WHERE message_id = $message_to_view_id";
        $select_message_by_id = mysqli_query($connection, $query);
        confirmQuery($select_message_by_id);
            
        while($row = mysqli_fetch_assoc($select_message_by_id)) {
            $message_id = $row['message_id'];
            $message_author_email = $row['message_author_email'];
            $message_content = $row['message_content'];
            $created_at = $row['created_at'];
        }
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Message ID</label>
        <input type="text" class="form-control" name="message_id" value="<?php echo $message_id ?>" disabled>
    </div>
    <div class="form-group">
        <label for="title">Author Email</label>
        <input type="text" class="form-control" name="message_author_email" value="<?php echo $message_author_email ?>" disabled>
    </div>
    <div class="form-group">
        <label for="">Created At</label>
        <input type="date" class="form-control" name="created_at" value="<?php echo $created_at ?>" disabled>
    </div>
    <div class="form-group">
        <label for="">Content</label>
        <textarea class="form-control" name="message_content" id="" cols="30" rows="10" disabled>
            <?php echo $message_content; ?>
        </textarea>
    </div>
    <!-- <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update">
    </div> -->
</form>