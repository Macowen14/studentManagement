<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] == 'student') {
    header('location:login.php');
    exit();
} elseif (!isset($_SESSION['admin_name'])) {
    header('location:adminHome.php');
}

require_once 'connection.php';

$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <?php include "./admin_css.php"; ?>
    <style>
        .table {
            width: 90%;
        }
    </style>
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
            <center>
                <h1 class="ms-3 mt-2">View Students Details</h1>
                <span class="text-danger">
                    <?php
                    if (isset($_SESSION['deleteMessage'])) {
                        echo $_SESSION['deleteMessage'];
                        unset($_SESSION['deleteMessage']);
                    }
                    ?>
                </span>
                <table class="table table-striped" border="1px" style="margin-right: 20px;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Course</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <th scope="row"><?= htmlspecialchars($row['id']) ?></th>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['course_id']) ?></td>
                                <td><?= htmlspecialchars($row['gender']) ?></td>
                                <td>
                                    <a onClick="javascript:return confirm('Are you sure you want to DELETE this student permanently?')" href="delete.php?student_id=<?= htmlspecialchars($row['id']) ?>" class="text-danger">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                    <a href="update_student.php?student_id=<?= htmlspecialchars($row['id']) ?>" class="ms-4" title="Update student info">
                                        <i class="bi bi-pen-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile;
                        // free up result
                        mysqli_free_result($result)
                        ?>
                    </tbody>
                </table>
            </center>
        </div>
    </div>

    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>