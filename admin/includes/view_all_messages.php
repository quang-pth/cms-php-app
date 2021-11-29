<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author Email</th>
            <th>Content</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $query = "SELECT * FROM messages";
            $select_messages = mysqli_query($connection, $query);
            confirmQuery($select_messages);
            
            while($row = mysqli_fetch_assoc($select_messages)) {
                $message_id = $row['message_id'];
                $message_author = $row['message_author_email'];
                $message_content = substr($row['message_content'], 0, 50);
                $created_at = $row['created_at'];

                
                echo "<tr>";
                echo "<td>$message_id</td>";
                echo "<td>$message_author</td>";
                echo "<td>$message_content ....</td>";
                echo "<td>$created_at</td>";
                
                echo "<td><a href='messages.php?source=view_message&m_id=$message_id'>Views</a></td>";
                echo "<td><a href='messages.php?delete=$message_id'>Delete</a></td>";
                echo "</tr>";
            }
        ?>
        <?php
            if(isset($_GET['delete'])) {
                $message_id_to_delete = santizeData($_GET['delete']);
                $query = "DELETE FROM messages WHERE message_id = {$message_id_to_delete} ";
                $delete_query = mysqli_query($connection, $query);
                confirmQuery($delete_query);
                header("Location: messages.php");
            }
        ?>
    </tbody>
</table>