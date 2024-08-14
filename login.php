<?php
error_reporting(0);
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./dist/login.css">
</head>

<body background="./images/NewAdminFront.jpg" class="body">
    <a href="index.php" role="button" class="btn btn-outline-dark">Home</a>
    <center>
        <div class="form-div">
            <h2>Login Form</h2>
            <form action="login_check.php" method="POST">
                <span class="text-danger">
                    <?php
                    if (isset($_SESSION['loginMessage'])) {
                        echo $_SESSION['loginMessage'];
                        unset($_SESSION['loginMessage']);
                    }
                    ?>
                </span>
                <div class="d-flex input-div">
                    <label class="form-label" for="username">Username</label>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>