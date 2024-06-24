<?php session_start();
if (!isset($_SESSION['username']) || ($_SESSION['user_type'] == 'admin')) {
    header('location:login.php');
} elseif (!isset($_SESSION['student_name'])) {
    header('location:studentHome.php');
    exit;
}

// includ database connectiion
include "connection.php";

$studentName = $_SESSION['student_name'];
// Fetch current student details from database
$sql = "SELECT email, password, course_id, phone, gender FROM students WHERE name = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $studentName);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $email, $password, $course_id, $phone, $gender);
// fetch the row
mysqli_stmt_fetch($stmt);
// close the statement
mysqli_stmt_close($stmt);

// Handle form submission for updating details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve and sanitize user input
    $new_email = htmlspecialchars($_POST['email']);
    $new_password = htmlspecialchars($_POST['password']);
    $new_course_id = htmlspecialchars($_POST['course_id']);
    $new_phone = htmlspecialchars($_POST['phone']);
    $new_gender = htmlspecialchars($_POST['gender']);

    // Check if the new email already exists in the database (excluding current user)
    $sql_check_email = "SELECT name FROM students WHERE email = ? AND name != ?";
    $stmt_check_email = mysqli_prepare($conn, $sql_check_email);
    mysqli_stmt_bind_param($stmt_check_email, "ss", $new_email, $studentName);
    mysqli_stmt_execute($stmt_check_email);
    mysqli_stmt_store_result($stmt_check_email);

    if (mysqli_stmt_num_rows($stmt_check_email) > 0) {
        // Email already exists for another user, show error message
        echo '<script>alert("Email already exists. Please choose a different email.");</script>';
    } else {
        // Update student details in the database
        $sql_update = "UPDATE students SET email = ?, password = ?, course_id = ?, phone = ?, gender = ? WHERE name = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "ssissi", $new_email, $new_password, $new_course_id, $new_phone, $new_gender, $username);

        if (mysqli_stmt_execute($stmt_update)) {
            // Update successful
            echo '<script>alert("Details updated successfully.");</script>';
        } else {
            // Update failed
            echo '<script>alert("Failed to update details. Please try again later.");</script>';
        }

        mysqli_stmt_close($stmt_update);
    }

    mysqli_stmt_close($stmt_check_email);
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>student Profile</title>
    <?php include 'admin_css.php'; ?>
</head>

<body>
    <?php include "./student_sidebar.php"; ?>
    <div class="main">
        <header class="header">
            <nav class="navbar bg-info">
                <span class="ms-3"><a href="#" class="navbar-brand text-light"><?php echo $studentName ?>'s Profile</a></span>
                <ul class="nav">
                    <li class="nav-item">
                        <a href="./logout.php" class="btn btn-outline-primary"><i class="bi bi-box-arrow-left text-light"></i> Logout</a>
                    </li>
                </ul>
            </nav>
        </header>
        <div class="content">
            <h1>Edit Profile</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Email</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $studentName; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="course_id" class="form-label">Course ID</label>
                    <input type="text" class="form-control" id="course_id" name="course_id" value="<?php echo $course_id; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="male" <?php if ($gender == 'male') echo 'selected'; ?>>Male</option>
                        <option value="female" <?php if ($gender == 'female') echo 'selected'; ?>>Female</option>
                        <option value="other" <?php if ($gender == 'other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Update</button>
            </form>
        </div>
    </div>

</body>

</html>