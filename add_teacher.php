<?php session_start();
if (!isset($_SESSION['username']) || ($_SESSION['user_type'] == 'student')) {
    header('location:login.php');
} elseif (!isset($_SESSION['admin_name'])) {
    header("Location:adminHome.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Teacher</title>
    <?php include "./admin_css.php"; ?>
    <style>
        form {
            width: 700px;
            background: #8700ff;
            padding: 18px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        .d-flex .btn {
            width: 150px;
        }

        .form-label {
            color: white;
            font-weight: bold;
        }

        #hourlyPay {
            width: 550px;
        }
    </style>
</head>

<body>
    <?php include "./admin_sidebar.php"; ?>
    <div class="main">
        <header>
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
        <div class="content">
            <center>
                <h2>Add Teacher</h2>
                <form action="add_teacher_check.php" method="POST" enctype="multipart/form-data">
                    <span class="text-warning">* Fill the required fields</span><br>
                    <span style="color: red; background:white;">
                        <?php if (isset($_SESSION['errorMessage'])) {
                            echo $_SESSION['errorMessage'];
                            unset($_SESSION['errorMessage']);
                        } ?>
                    </span><br>
                    <span class="text-success" style="background-color: white;">
                        <?php if (isset($_SESSION['successMessage'])) {
                            echo $_SESSION['successMessage'];
                            unset($_SESSION['successMessage']);
                        } ?>
                    </span>
                    <div class="d-flex mt-3">
                        <label for="name" class="form-label me-3">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="d-flex mt-3">
                        <label for="email" class="form-label me-3">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="d-flex mt-3">
                        <label for="phone" class="form-label me-3">Phone</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>
                    <div class="d-flex mt-3">
                        <label for="password" class="form-label me-3">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="d-flex mt-3">
                        <label for="course" class="form-label me-3">Course</label>
                        <select name="course" class="form-select" required>
                            <option value="HS101">HS101</option>
                            <option value="HS102">HS102</option>
                            <option value="HS103">HS103</option>
                            <option value="EN101">EN101</option>
                            <option value="EN102">EN102</option>
                            <option value="EN103">EN103</option>
                            <option value="TH101">TH101</option>
                            <option value="TH102">TH102</option>
                            <option value="TH103">TH103</option>
                            <option value="BM101">BM101</option>
                            <option value="BM102">BM102</option>
                            <option value="BM103">BM103</option>
                            <option value="CS101">CS101</option>
                            <option value="CS102">CS102</option>
                            <option value="CS103">CS103</option>
                        </select>
                    </div>
                    <div class="d-flex mt-3">
                        <label for="hourly_pay" class="form-label me-3">Hourly Pay</label>
                        <input type="number" name="hourly_pay" id="hourlyPay" class="form-control" required>
                    </div>
                    <div class="d-flex mt-3">
                        <label for="department" class="form-label me-3">Department</label>
                        <select class="form-select" id="department" name="department" required>
                            <option value="Health Sciences">Health Sciences</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Tourism and Hospitality">Tourism and Hospitality</option>
                            <option value="Business and Management">Business and Management</option>
                            <option value="Computer Science">Computer Science</option>
                        </select>
                    </div>
                    <div class="d-flex mt-3">
                        <label for="imageFile" class="form-label me-3">Image</label>
                        <input type="file" name="imageFile" class="form-control" required>
                    </div>
                    <div class="d-flex mt-3 justify-content-center">
                        <input type="submit" value="Add Teacher" name="add-teacher" class="btn btn-primary">
                    </div>
                </form>
            </center>
        </div>
    </div>
</body>

</html>