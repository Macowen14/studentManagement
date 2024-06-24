<?php
require "connection.php";
echo "delete Teacher";

if ($_GET['teacher_id']) {
    $user_id = $_GET['teacher_id'];
    $sql = "DELETE FROM teachers WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['deleteMessage'] = "Teacher deleted successfully";
    } else {
        $_SESSION['deleteMessage'] = "Failed to delete teacher";
    }

    // Close the database connection
    mysqli_close($conn);
    header("Location: view_teacher.php");
    exit();
}
