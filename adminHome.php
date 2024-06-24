<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] == 'student') {
    header('Location: login.php');
    exit();
}

include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve and sanitize user input
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // SQL injection prevention: Use prepared statements
    $sql = "SELECT * FROM teachers WHERE name = ? AND password = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            // Credentials matched, set session variables and redirect
            $_SESSION['admin_name'] = ucwords($username);
            $_SESSION['adminMessage'] = 'You have successfully logged in and may now proceed.';
            $myFile = fopen('login.txt', 'a');
            $txt = $_SESSION['admin_name'] . " has loged in successfully at " . date('Y-m-d H:i:sa') . "\n";
            fwrite($myFile, $txt);
            fclose($myFile);
            header('Location: adminHome.php'); // Redirect to the admin dashboard
            exit();
        } else {
            // Credentials did not match, set error message
            $_SESSION['errorMessage'] = "Invalid username or password. Please try again.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['errorMessage'] = "Database query failed.";
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Main Page</title>
    <?php include 'admin_css.php'; ?>
    <style>
        .form-div {
            background-color: #d7a717;
            border-radius: 13px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            padding: 10px;
        }
    </style>
</head>

<body>
    <?php include "./admin_sidebar.php"; ?>
    <div class="main">
        <header class="header">
            <nav class="navbar bg-info">
                <span class="ms-3">
                    <a class="menu-icon" id="menuIcon">
                        <i class="bi bi-list fs-3"></i>
                    </a>
                    <a href="#" class="navbar-brand text-light">Admin Dashboard</a>
                </span>
                <ul class="nav">
                    <li class="nav-item me-3"><a href="./logout.php" class="btn btn-success">Logout</a></li>
                </ul>
            </nav>
        </header>
        <h2>Admin Main Page</h2>
        <center>
            <h6 class="ms-3">Welcome,
                <?php
                if (isset($_SESSION['admin_name'])) {
                    echo $_SESSION['admin_name'] . " you may now proceed .";
                } else {
                    echo 'Admin, Please login to proceed.';
                }
                ?>
            </h6>
            <div class="form-div" style="width: 600px;">
                <?php if (isset($_SESSION['errorMessage'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['errorMessage'];
                        unset($_SESSION['errorMessage']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['adminMessage'])) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['adminMessage'];
                        unset($_SESSION['adminMessage']); ?>
                    </div>
                <?php endif; ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="d-flex input-div mt-2 mb-3">
                        <label class="form-label me-2 d-flex" for="username">Admin Name</label>
                        <input class="form-control" type="text" name="username" id="username" required>
                    </div>
                    <div class="d-flex input-div mt-2 mb-3">
                        <label class="form-label me-2" for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password" required>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-2 mb-3">
                        <input class="btn btn-primary" type="submit" value="Login" name="submit">
                    </div>
                </form>
            </div>
        </center>

    </div>
</body>

</html>