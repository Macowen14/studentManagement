<?php
session_start();

include '.conncet.php';

// Check connection
if ($conn === false) {
    $_SESSION['application_message'] = "Error connecting to database";
    header("Location: index.php");
    exit();
}

// Function to clean data
function cleanData($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

// Input validation function
function validateInput($fullname, $email, $phone, $message)
{
    $errors = [];

    if (empty($fullname)) {
        $errors[] = "Name is required.";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {
        $errors[] = "Only letters and white space allowed in name.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($phone)) {
        $errors[] = "Phone is required.";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        $errors[] = "Invalid phone number.";
    }

    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    return $errors;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply'])) {
    $fullname = cleanData($_POST['fullname']);
    $email = cleanData($_POST['email']);
    $phone = cleanData($_POST['phone']);
    $message = cleanData($_POST['message']);

    // Validate inputs
    $errors = validateInput($fullname, $email, $phone, $message);

    if (empty($errors)) {
        // Check if the email already exists in the database
        $sql = "SELECT * FROM admission WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['application_message'] = "An application with this email already exists.";
        } else {
            // Insert into database
            $sql = "INSERT INTO admission (name, email, phone, message) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssss', $fullname, $email, $phone, $message);

            if ($stmt->execute()) {
                $_SESSION['application_message'] = "Application sent successfully.";
            } else {
                $_SESSION['application_message'] = "Application failed: " . $stmt->error;
            }
        }
    } else {
        $_SESSION['application_message'] = implode('<br>', $errors);
    }
    // Close the statement
    $stmt->close();

    // Close the database connection
    mysqli_close($conn);

    // Redirect to the home page
    header("Location: index.php");
    exit();
}
