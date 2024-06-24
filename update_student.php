<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] == 'student') {
    header('location:login.php');
    exit();
} elseif (!isset($_SESSION['admin_name'])) {
    header('location:adminHome.php');
}
// Include the database connection
require_once "connection.php";

if (isset($_GET['student_id'])) {
    $id = htmlspecialchars($_GET['student_id']);

    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    try {
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    } catch (mysqli_sql_exception $e) {
        $_SESSION['FetchError'] = "Error: " . $e->getMessage();
        header('location: view_student.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    if (
        isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['course_id'], $_POST['gender'], $_POST['registration_date'])
    ) {
        // Sanitize data
        function sanitizeData($data)
        {
            return htmlspecialchars(trim($data));
        }

        $name = sanitizeData($_POST['name']);
        $email = sanitizeData($_POST['email']);
        $phone = sanitizeData($_POST['phone']);
        $password = sanitizeData($_POST['password']);
        $course = sanitizeData($_POST['course_id']);
        $gender = sanitizeData($_POST['gender']);
        $registration_date = sanitizeData($_POST['registration_date']);

        $sql = "UPDATE students SET name = ?, email = ?, password = ?, phone = ?, course_id = ?, gender = ?, registration_date = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssi', $name, $email, $password, $phone, $course, $gender, $registration_date, $id);

        try {
            if ($stmt->execute()) {
                $_SESSION['successMessage'] = 'Successfully updated student information';
            } else {
                $_SESSION['updateFailureMessage'] = 'Failed to update student information.';
            }
        } catch (mysqli_sql_exception $e) {
            $_SESSION['updateFailureMessage'] = 'Failed to update student information: ' . $e->getMessage();
        }
    } else {
        $_SESSION['emptyFieldMessage'] = 'Please fill all required fields';
    }

    header("Location: update_student.php?student_id=$id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <?php include 'admin_css.php'; ?>
    <link rel="stylesheet" href="./dist/login.css">
</head>

<body>
    <?php include "./admin_sidebar.php"; ?>
    <div class="main">
        <header class="header">
            <nav class="navbar bg-info">
                <span class="ms-3"><a href="#" class="navbar-brand text-light">Admin Dashboard</a></span>
                <ul class="nav">
                    <li class="nav-item me-3"> <a href="./logout.php" class="btn btn-success">Logout</a></li>
                </ul>
            </nav>
        </header>
        <div class="content">
            <a href="view_student.php" class="btn btn-success">Back</a>
            <center>
                <h1 class="ms-3 text-success">Update Student</h1>
                <div class="form-div">
                    <span class="text-danger">
                        <?php
                        if (isset($_SESSION['emptyFieldMessage'])) {
                            echo $_SESSION['emptyFieldMessage'];
                            unset($_SESSION['emptyFieldMessage']);
                        } elseif (isset($_SESSION['updateFailureMessage'])) {
                            echo $_SESSION['updateFailureMessage'];
                            unset($_SESSION['updateFailureMessage']);
                        } elseif (isset($_SESSION['FetchError'])) {
                            echo $_SESSION['FetchError'];
                            unset($_SESSION['FetchError']);
                        }
                        ?>
                    </span>
                    <span class="text-success">
                        <?php
                        if (isset($_SESSION['successMessage'])) {
                            echo $_SESSION['successMessage'];
                            unset($_SESSION['successMessage']);
                        }
                        ?>
                    </span>
                    <form action="update_student.php?student_id=<?= $id ?>" method="POST">
                        <div class="mb-3 input-div d-flex">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($row['name']) ?>">
                        </div>
                        <div class="mb-3 input-div d-flex">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($row['email']) ?>">
                        </div>
                        <div class="mb-3 input-div d-flex">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required value="<?= htmlspecialchars($row['phone']) ?>">
                        </div>
                        <div class="mb-3 input-div d-flex">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required value="<?= htmlspecialchars($row['password']) ?>">
                        </div>
                        <div class="mb-3 input-div d-flex">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?= $row['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= $row['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= $row['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                        <div class="mb-3 input-div d-flex">
                            <label for="course_id" class="form-label">Course ID</label>
                            <input type="text" class="form-control" id="course_id" name="course_id" required value="<?= htmlspecialchars($row['course_id']) ?>">
                        </div>
                        <div class="mb-3 input-div d-flex">
                            <label for="registration_date" class="form-label">Registration Date</label>
                            <input type="date" class="form-control" id="registration_date" name="registration_date" required value="<?= htmlspecialchars($row['registration_date']) ?>">
                        </div>
                        <button type="submit" class="btn btn-success" name="update">Update</button>
                    </form>
                </div>
            </center>
        </div>
    </div>
</body>

</html>
<?php
// Close the database connection
mysqli_close($conn);
?>