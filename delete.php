<?php
session_start();
require_once('connection.php');

if ($_GET['student_id']) {
    $user_id = $_GET['student_id'];
    $sql = "DELETE FROM students WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['deleteMessage'] = "Student deleted successfully";
    } else {

        $_SESSION['deleteMessage'] = "Failed to delete student";
    }
    header('location: view_student.php');
}
