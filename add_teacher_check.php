<?php
session_start();
// include the database connection
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['course'], $_POST['department'], $_POST['hourly_pay'])) {
        // Function to sanitize data
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $name = test_input($_POST['name']);
        $email = test_input($_POST['email']);
        $phone = test_input($_POST['phone']);
        $password = test_input($_POST['password']);
        $course = test_input($_POST['course']);
        $hourlyPay = test_input($_POST['hourly_pay']);
        $department = test_input($_POST['department']);

        $target_dir = "uploads/";
        $file_name = basename($_FILES["imageFile"]["name"]);
        $unique_file_name = uniqid() . '_' . $file_name;
        $target_file = $target_dir . $unique_file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['errorMessage'] = "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $_SESSION['errorMessage'] = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["imageFile"]["size"] > 1000000) {
            $_SESSION['errorMessage'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $_SESSION['errorMessage'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // If there were no errors with the image upload
        if ($uploadOk == 1) {
            // Prepare SQL statement
            $sql = "INSERT INTO teachers (name, email, phone, password, course_id, hourly_pay, department, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssssssss", $name, $email, $phone, $password, $course, $hourlyPay, $department, $unique_file_name);
                try {
                    $stmt->execute();
                    // If data inserted successfully, move the uploaded file
                    if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file)) {
                        $_SESSION['successMessage'] = "Successfully added teacher";
                    } else {
                        $_SESSION['errorMessage'] = "Sorry, there was an error uploading your file.";
                    }
                    header("location: add_teacher.php");
                    exit();
                } catch (mysqli_sql_exception $e) {
                    $_SESSION['errorMessage'] = 'An error occurred: ' . $e->getMessage();
                }
                $stmt->close();
            } else {
                $_SESSION['errorMessage'] = 'Database preparation failed.';
            }
        }
    } else {
        // If any required field is missing
        $_SESSION['errorMessage'] = "Please fill the required fields.";
    }

    header("Location: add_teacher.php");
    exit();
}
