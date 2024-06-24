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
// connect to database
include 'connection.php';

$sql = "SELECT * FROM admission";

$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <?php include 'admin_css.php'; ?>
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
                <h1>Applied for Admission</h1>
                <table class="table" border="1px" style="margin-right: 20px;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Message</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <th scope="row"><?= $row['id'] ?></th>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['phone'] ?></td>
                                <td><?= $row['message'] ?></td>
                                <td><a href="update.php"><i class="bi bi-person-dash-fill"></i></a></td>
                            </tr>
                        <?php endwhile; ?>



                    </tbody>
                </table>
            </center>


        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>