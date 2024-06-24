<?php
session_start();

require_once "connection.php";

// Fetch administrators from the database
$sql = "SELECT name, image, description FROM administrators";
$result = $conn->query($sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <nav class="navbar bg-primary">
        <span class="logo ms-4"><a href="#about" class="navbar-brand text-light">E-Learner</a></span>
        <ul class="nav">
            <li class="nav-item"><a href="#" class="nav-link text-light">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-light">Contact</a></li>
            <li class="nav-item"><a href="#admission" class="nav-link text-light">Admission</a></li>
            <li><a href="./login.php" role="button" class="btn btn-success me-3">Login</a></li>
        </ul>
    </nav>
    <div class="hero">
        <img src="./images/classroom.jpg" alt="Classroom Image">
        <div class="hero-text">
            <h1>Welcome to E-Learner</h1>
            <p>Your journey to knowledge starts here</p>
        </div>
    </div>
    <div class="about mt-2 row" id="about">
        <div class="school-img col-3">
            <img src="./images/NewAdminFront.jpg" alt="School Image" class="img-fluid">
        </div>
        <div class="school-text col-9">
            <h4>About E-Learning</h4>
            <p>Welcome to E-Learning, the cutting-edge virtual campus where the future of technology and creativity converge. Our comprehensive curriculum is designed to empower the next generation of innovators and thinkers. With state-of-the-art courses in technology, marketing, and graphic design, our students are equipped to excel in the fast-paced digital world. Our tech programs cover everything from software development to cybersecurity, ensuring a robust understanding of the digital landscape.</p>
            <p>At E-Learning, we believe in a hands-on approach to education. Our marketing courses offer real-world projects that provide insight into market analysis and strategy, while our graphic design track allows students to unleash their creativity through practical assignments using the latest design software. Join us at E-Learning, where your passion for technology and design transforms into a thriving career.</p>
        </div>

    </div>
    <div class="teachers">
        <h3>Our Administrators</h3>
        <div class="admin-container">
            <div class="row">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="teacher col-md-3 clo-sm-6">';
                        echo '<img src="' . $row["image"] . '" alt="' . $row["name"] . '" class="img-fluid">';
                        echo '<h4>' . $row["name"] . '</h4>';
                        echo '<p>' . $row["description"] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No administrators found.</p>';
                }
                ?>
            </div>

        </div>
    </div>
    <div class="courses">
        <h3>Our courses</h3>
        <div class="row">
            <div class="course col-md-3 col-sm-4 ">
                <img src="./images/software development.jpg" alt="course 1" class="img-fluid">
                <h4>Software development</h4>
            </div>
            <div class="course col-md-3 col-sm-4">
                <img src="./images/web development.jpg" alt="course 2" class="img-fluid">
                <h4>Full stack development</h4>
            </div>
            <div class="course col-md-3 col-sm-4">
                <img src="./images/cyber-security.jpg" alt="course 3" class="img-fluid">
                <h4>Cyber Security</h4>
            </div>
            <div class="course col-md-3 col-sm-4">
                <img src="./images/multimedia-courses.webp" alt="course 3" class="img-fluid">
                <h4>Multimedia Courses</h4>
            </div>
        </div>
    </div>
    <div class="admission_form" id="admission">
        <h3>Admission Form</h3>
        <form action="data_check.php" method="POST">
            <span class="text-warning">* All fields are required</span><br>
            <div class="input-div">
                <label for="fullname" class="label_text">Name : </label>
                <input type="text" name="fullname" id="name" class="form-control" required>
            </div>
            <div class="input-div">
                <label for="email" class="label_text">Email : </label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="input-div">
                <label for="phone" class="label_text">Phone : </label>
                <input type="tel" name="phone" id="phone" class="form-control" required>
            </div>
            <div class="input-div">
                <label for="message" class="label_text">Message : </label>
                <textarea name="message" id="message" cols="35" rows="5" class="form-control" required placeholder="Enter the course you would like to learn at E-learning"></textarea>
            </div>
            <div class="input-div align-items-center justify-content-center">
                <button type="submit" class="btn btn-success" name="apply">Apply</button>
            </div>
        </form>
    </div>
    <footer class="bg-primary d-flex align-items-center justify-content-end">
        <span class="text-light">All @copyright reserved by Macowen Keru <?php echo date('Y') ?></span>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        <?php
        if (isset($_SESSION['application_message'])) {
            echo "alert('" . $_SESSION['application_message'] . "');";
            unset($_SESSION['application_message']);
        }
        ?>
    </script>
</body>

</html>