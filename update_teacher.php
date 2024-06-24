<?php
session_start();
require_once "connection.php";

$id = htmlspecialchars($_GET['teacher_id']);
$sql = "SELECT * FROM `teachers` WHERE `id` = $id";
$result = mysqli_query($conn, $sql);

// Ensure the query is successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$teacher = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - update Teacher</title>
    <style>
        form {
            width: 700px;
            background: skyblue;
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
    <?php include "./admin_css.php"; ?>
</head>

<body>
    <?php include "./admin_sidebar.php"; ?>
    <div class="main">
        <header>
            <nav class="navbar bg-info">
                <span class="ms-3">
                    <img src="<?php echo $teacher['image']; ?>" alt="teacher image" style="width: 45px; height:45px; border-radius:50%;">
                    <a href="#" class="navbar-brand text-light">Admin Dashboard</a>
                </span>
                <ul class="nav">
                    <li class="nav-item me-3"><a href="./logout.php" class="btn btn-success">Logout</a></li>
                </ul>
            </nav>
        </header>
        <div class="content">
            <center>
                <h2>Update details about <?php echo ucwords($teacher['name']); ?></h2>

                <form action="update_teacher_check.php" method="POST" enctype="multipart/form-data">
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
                    <input type="hidden" name="teacher_id" value="<?php echo $teacher['id']; ?>">
                    <div class="d-flex mt-3">
                        <label for="name" class="form-label me-3">Name</label>
                        <input type="text" class="form-control" name="name" required readonly value="<?php echo $teacher['name']; ?>">
                    </div>
                    <div class="d-flex mt-3">
                        <label for="email" class="form-label me-3">Email</label>
                        <input type="email" name="email" class="form-control" required value="<?php echo $teacher['email']; ?>">
                    </div>
                    <div class="d-flex mt-3">
                        <label for="phone" class="form-label me-3">Phone</label>
                        <input type="tel" name="phone" class="form-control" required value="<?php echo $teacher['phone']; ?>">
                    </div>
                    <div class="d-flex mt-3">
                        <label for="password" class="form-label me-3">Password</label>
                        <input type="password" name="password" class="form-control" required value="<?php echo $teacher['password']; ?>">
                    </div>
                    <div class="d-flex mt-3">
                        <label for="course" class="form-label me-3">Course</label>
                        <select name="course" class="form-select" required>
                            <option value="HS101" <?php if ($teacher['course_id'] == 'HS101') echo 'selected'; ?>>HS101</option>
                            <option value="HS102" <?php if ($teacher['course_id'] == 'HS102') echo 'selected'; ?>>HS102</option>
                            <option value="HS103" <?php if ($teacher['course_id'] == 'HS103') echo 'selected'; ?>>HS103</option>
                            <option value="EN101" <?php if ($teacher['course_id'] == 'EN101') echo 'selected'; ?>>EN101</option>
                            <option value="EN102" <?php if ($teacher['course_id'] == 'EN102') echo 'selected'; ?>>EN102</option>
                            <option value="EN103" <?php if ($teacher['course_id'] == 'EN103') echo 'selected'; ?>>EN103</option>
                            <option value="TH101" <?php if ($teacher['course_id'] == 'TH101') echo 'selected'; ?>>TH101</option>
                            <option value="TH102" <?php if ($teacher['course_id'] == 'TH102') echo 'selected'; ?>>TH102</option>
                            <option value="TH103" <?php if ($teacher['course_id'] == 'TH103') echo 'selected'; ?>>TH103</option>
                            <option value="BM101" <?php if ($teacher['course_id'] == 'BM101') echo 'selected'; ?>>BM101</option>
                            <option value="BM102" <?php if ($teacher['course_id'] == 'BM102') echo 'selected'; ?>>BM102</option>
                            <option value="BM103" <?php if ($teacher['course_id'] == 'BM103') echo 'selected'; ?>>BM103</option>
                            <option value="CS101" <?php if ($teacher['course_id'] == 'CS101') echo 'selected'; ?>>CS101</option>
                            <option value="CS102" <?php if ($teacher['course_id'] == 'CS102') echo 'selected'; ?>>CS102</option>
                            <option value="CS103" <?php if ($teacher['course_id'] == 'CS103') echo 'selected'; ?>>CS103</option>
                        </select>
                    </div>
                    <div class="d-flex mt-3">
                        <label for="hourly_pay" class="form-label me-3">Hourly Pay</label>
                        <input type="number" name="hourly_pay" id="hourlyPay" class="form-control" required value="<?php echo $teacher['hourly_pay']; ?>">
                    </div>
                    <div class="d-flex mt-3">
                        <label for="department" class="form-label me-3">Department</label>
                        <select class="form-select" id="department" name="department" required>
                            <option value="Health Sciences" <?php if ($teacher['department'] == 'Health Sciences') echo 'selected'; ?>>Health Sciences</option>
                            <option value="Engineering" <?php if ($teacher['department'] == 'Engineering') echo 'selected'; ?>>Engineering</option>
                            <option value="Tourism and Hospitality" <?php if ($teacher['department'] == 'Tourism and Hospitality') echo 'selected'; ?>>Tourism and Hospitality</option>
                            <option value="Business and Management" <?php if ($teacher['department'] == 'Business and Management') echo 'selected'; ?>>Business and Management</option>
                            <option value="Computer Science" <?php if ($teacher['department'] == 'Computer Science') echo 'selected'; ?>>Computer Science</option>
                        </select>
                    </div>
                    <div class="d-flex mt-3">
                        <label for="imageFile" class="form-label me-3">Image</label>
                        <input type="file" name="imageFile" class="form-control" required>
                    </div>
                    <div class="d-flex mt-3 justify-content-center">
                        <input type="submit" value="Update Teacher" name="update-teacher" class="btn btn-primary">
                    </div>
                </form>
            </center>
        </div>
    </div>
</body>

</html>