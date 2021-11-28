<?php 

function confirmQuery($query_result) {
    global $connection;
    if(!$query_result) {
            die("QUERY FAILED" . mysqli_errno($connection));
    }
}

function insert_categories() {   
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $cat_title = trim(str_replace('-', '', $cat_title)); // remove sql comment syntax
            $cat_title = preg_replace('/[^A-Za-z0-9 \-]/', '', $cat_title); // Removes special chars.
            $query = "INSERT INTO categories(cat_title)";
            $query .= " VALUE('{$cat_title}')";
            
            $create_category_query = mysqli_query($connection, $query);
            if(!$create_category_query) {
                die('QUERY FAILED'. mysqli_error($connection));
            }
        }
    }
}

function findAllCategories() {
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);
            
    while($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function deleteCategories() {
    global $connection;
     if (isset($_GET['delete'])) {
        $cat_id_to_delete = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$cat_id_to_delete}";
        $delete_query = mysqli_query($connection, $query);
        if (!$delete_query) {
            die('QUERY FAILED'. mysqli_error($connection));
        }
        header("Location: categories.php"); // refresh page
    }
}