<?php session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
} elseif ($_SESSION['user_type'] == 'admin') {
    header('location:login.php');
}

// include the database connection
include "connection.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>student</title>
    <?php include 'admin_css.php'; ?>
    <link rel="stylesheet" href="./dist/login.css">
</head>

<body>
    <?php include "./student_sidebar.php"; ?>
    <div class="main">
        <header class="header">
            <nav class="navbar bg-info">
                <span class="ms-3"><a href="#" class="navbar-brand text-light">Student Dashboard</a></span>
                <ul class="nav">
                    <li class="nav-item">
                        <a href="./logout.php" class="btn btn-outline-primary"><i class="bi bi-box-arrow-left text-light"></i> Logout</a>
                    </li>
                </ul>
            </nav>

        </header>
        <div class="content">
            <h1>Sidebar Accordion</h1>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Amet ab dolorem expedita. Suscipit officia deleniti at doloribus deserunt dolorem magni ea quibusdam magnam expedita sapiente, tempore voluptates, excepturi id quo!
                Consectetur praesentium iste maxime incidunt exercitationem consequatur, in et eum sed, tenetur commodi perspiciatis aliquam. Perferendis vitae hic at consectetur ullam nemo deserunt? Dolorem, facilis ab aliquam commodi qui molestiae.</p>
            <center>
                <div class="form-div">
                    <span class="text-danger fs-6 ">Enter your name and password inorder to login to your studet account</span>
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                        <div class="d-flex input-div">
                            <label class="form-label" for="username">Name</label>
                            <input class="form-control" type="text" name="username" id="username" required>
                        </div>
                        <div class="d-flex input-div">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" type="password" name="password" id="password" required>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <input class="btn btn-primary" type="submit" value="Login" name="submit">
                        </div>
                    </form>
                </div>
            </center>

        </div>
    </div>
</body>

</html>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve and sanitize user input
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // SQL injection prevention: Use prepared statements
    $sql = "SELECT * FROM students WHERE name REGEXP ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        // Credentials matched, set session variables and redirect
        $_SESSION['student_name'] = ucwords($username);
        $_SESSION['user_type'] = 'student';
        header('Location: student_profile.php'); // Redirect to student dashboard or desired page
        exit;
    } else {
        // Credentials did not match, display error message
        echo '<script>alert("Invalid username or password. Please try again.");</script>';
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>