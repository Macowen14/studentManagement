<?php session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
} elseif ($_SESSION['user_type'] == 'student') {
    header('location:login.php');
} else {
    if (!isset($_SESSION['admin_name'])) {
        header('location:adminHome.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin-addstudent</title>
    <?php include "./admin_css.php"; ?>
    <link rel="stylesheet" href="./dist/login.css">
</head>

<body>
    <?php include "./admin_sidebar.php"; ?>
    <div class="main ">
        <header class="header">
            <nav class="navbar bg-info">
                <span class="ms-3"><a href="#" class="navbar-brand text-light">Admin Dashboard</a></span>
                <ul class="nav">
                    <li class="nav-item me-3"> <a href="./logout.php" class="btn btn-success">Logout</a></li>
                </ul>
            </nav>
        </header>
        <div class="content">
            <h1 class="ms-3 mt-3" style="text-align: center; color:darkblue;">Add Student</h1>
            <center>
                <div class="form-div">
                    <span class="text-danger"><?php if (isset($_SESSION['error_message'])) {
                                                    echo $_SESSION['error_message'];
                                                    unset($_SESSION['error_message']);
                                                } ?></span>
                    <form action="add_student_check.php" method="POST">
                        <div class="mb-3 input-div d-flex">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3 input-div d-flex">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3 input-div d-flex">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3 input-div d-flex">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3 input-div d-flex">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3 input-div d-flex">
                            <label for="course_id" class="form-label">Course ID</label>
                            <input type="text" class="form-control" id="course_id" name="course_id" required>
                        </div>
                        <div class="mb-3 input-div d-flex">
                            <label for="registration_date" class="form-label">Registration Date</label>
                            <input type="date" class="form-control" id="registration_date" name="registration_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </center>

        </div>

    </div>



</body>
<script type="text/javascript">
    <?php
    if (isset($_SESSION['submitMessage'])) {
        echo "alert('" . $_SESSION['submitMessage'] . "');";
        unset($_SESSION['submitMessage']);
    }
    ?>
</script>

</html>