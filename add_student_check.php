<?php
session_start();
require_once 'connection.php';

// Function to sanitize input data
function sanitizeData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input data
    $name = ucwords(sanitizeData($_POST['name']));
    $email = sanitizeData($_POST['email']);
    $phone = sanitizeData($_POST['phone']);
    $password = sanitizeData($_POST['password']);
    $gender = sanitizeData($_POST['gender']);
    $course_id = sanitizeData($_POST['course_id']);
    $registration_date = sanitizeData($_POST['registration_date']);

    if (isset($name, $email, $registration_date, $phone, $password, $gender, $course_id)) {
        // Validate email uniqueness
        $sql_check_email = "SELECT COUNT(*) AS count FROM students WHERE email = ?";
        $stmt_check_email = $conn->prepare($sql_check_email);
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $result_check_email = $stmt_check_email->get_result();
        $row_check_email = $result_check_email->fetch_assoc();

        if ($row_check_email['count'] > 0) {
            $_SESSION['error_message'] = "Student with this email already exists. Please use a different email.";
            header('Location: addStudentForm.php');
            exit();
        }

        // Insert into database
        $sql_insert_student = "INSERT INTO students (name, email, phone, password, gender, course_id, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_student = $conn->prepare($sql_insert_student);
        $stmt_insert_student->bind_param("sssssss", $name, $email, $phone, $password, $gender, $course_id, $registration_date);

        if ($stmt_insert_student->execute()) {
            $_SESSION['submitMessage'] = "Student added successfully!";
            header('Location: add_student.php');
            exit();
        } else {
            $_SESSION['submitMessage'] = "Error inserting student. Please try again.";
            header('Location: add_student.php');
            exit();
        }
    } else {
        $_SESSION['submitMessage'] = "ALL Fieldde are required. Please try again.";
        header('Location: add_student.php');
        exit();
    }
} else {
    // If the form was not submitted
    $_SESSION['studenMessage'] = "Form submission error. Please try again.";
    header('Location: add_student.php');
    exit();
}
