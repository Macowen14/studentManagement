<?php
// Database connection settings
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'schoolProject';
$port = 3307; // specify the port to connect to

// Connect to the database
$conn = mysqli_connect($host, $user, $pass, $db, $port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create administrators table
$sql = "CREATE TABLE IF NOT EXISTS administrators (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    description TEXT,
    phone VARCHAR(20),
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Principal', 'Vice Principal', 'Head of Department') NOT NULL,
    created_at DATETIME NOT NULL
)";

if (mysqli_query($conn, $sql)) {
    echo "Administrators table created successfully or already exists.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Sample data for administrators
$administrators = [
    ['name' => 'John Doe', 'image' => 'uploads/johndoe.jpg', 'description' => 'Principal of the school.', 'phone' => '123-456-7890', 'email' => 'john.doe@example.com', 'username' => 'johndoe', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'Principal', 'created_at' => '2024-06-20 09:08:06'],
    ['name' => 'Jane Smith', 'image' => 'uploads/janesmith.jpg', 'description' => 'Vice Principal.', 'phone' => '234-567-8901', 'email' => 'jane.smith@example.com', 'username' => 'janesmith', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'Vice Principal', 'created_at' => '2024-06-20 09:08:06'],
    ['name' => 'Michael Brown', 'image' => 'uploads/michaelbrown.jpg', 'description' => 'Head of Science Department.', 'phone' => '345-678-9012', 'email' => 'michael.brown@example.com', 'username' => 'michaelbrown', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'Head of Department', 'created_at' => '2024-06-20 09:08:06'],
    ['name' => 'Emily Davis', 'image' => 'uploads/emilydavis.jpg', 'description' => 'Head of Mathematics Department.', 'phone' => '456-789-0123', 'email' => 'emily.davis@example.com', 'username' => 'emilydavis', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'Head of Department', 'created_at' => '2024-06-20 09:08:06']
];

// Insert data into administrators table
foreach ($administrators as $admin) {
    $stmt = $conn->prepare("INSERT INTO administrators (name, image, description, phone, email, username, password, role, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $admin['name'], $admin['image'], $admin['description'], $admin['phone'], $admin['email'], $admin['username'], $admin['password'], $admin['role'], $admin['created_at']);
    if ($stmt->execute()) {
        echo "Administrator " . $admin['name'] . " inserted successfully.<br>";
    } else {
        echo "Error inserting administrator " . $admin['name'] . ": " . $stmt->error . "<br>";
    }
}

// Create courses table
$sql = "CREATE TABLE IF NOT EXISTS courses (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    course_id VARCHAR(10) NOT NULL UNIQUE,
    course_name VARCHAR(255) NOT NULL,
    faculty_id INT NOT NULL,
    FOREIGN KEY (faculty_id) REFERENCES faculties(id) ON DELETE SET NULL
)";

if (mysqli_query($conn, $sql)) {
    echo "Courses table created successfully or already exists.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Sample data for courses
$courses = [
    ['course_id' => 'HS101', 'course_name' => 'Introduction to Health Sciences', 'faculty_id' => 1],
    ['course_id' => 'HS102', 'course_name' => 'Nutrition and Dietetics', 'faculty_id' => 1],
    ['course_id' => 'HS103', 'course_name' => 'Public Health', 'faculty_id' => 1],
    ['course_id' => 'EN101', 'course_name' => 'Introduction to Engineering', 'faculty_id' => 2],
    ['course_id' => 'EN102', 'course_name' => 'Mechanical Engineering', 'faculty_id' => 2],
    ['course_id' => 'EN103', 'course_name' => 'Electrical Engineering', 'faculty_id' => 2],
    ['course_id' => 'TH101', 'course_name' => 'Introduction to Tourism', 'faculty_id' => 3],
    ['course_id' => 'TH102', 'course_name' => 'Hospitality Management', 'faculty_id' => 3],
    ['course_id' => 'TH103', 'course_name' => 'Tourism Marketing', 'faculty_id' => 3],
    ['course_id' => 'BM101', 'course_name' => 'Introduction to Business', 'faculty_id' => 4],
    ['course_id' => 'BM102', 'course_name' => 'Business Administration', 'faculty_id' => 4],
    ['course_id' => 'BM103', 'course_name' => 'Marketing Management', 'faculty_id' => 4],
    ['course_id' => 'CS101', 'course_name' => 'Introduction to Computer Science', 'faculty_id' => 5],
    ['course_id' => 'CS102', 'course_name' => 'Software Engineering', 'faculty_id' => 5],
    ['course_id' => 'CS103', 'course_name' => 'Database Systems', 'faculty_id' => 5]
];

// Insert data into courses table
foreach ($courses as $course) {
    $stmt = $conn->prepare("INSERT INTO courses (course_id, course_name, faculty_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $course['course_id'], $course['course_name'], $course['faculty_id']);
    if ($stmt->execute()) {
        echo "Course " . $course['course_name'] . " inserted successfully.<br>";
    } else {
        echo "Error inserting course " . $course['course_name'] . ": " . $stmt->error . "<br>";
    }
}

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    user_type ENUM('admin', 'student', 'staff') NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if (mysqli_query($conn, $sql)) {
    echo "Users table created successfully or already exists.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Sample data for users
$users = [
    ['username' => 'admin', 'user_type' => 'admin', 'password' => password_hash('@admin12345', PASSWORD_DEFAULT)],
    ['username' => 'student', 'user_type' => 'student', 'password' => password_hash('student254', PASSWORD_DEFAULT)],
    ['username' => 'staff', 'user_type' => 'staff', 'password' => password_hash('staff#e-learn', PASSWORD_DEFAULT)]
];

// Insert data into users table
foreach ($users as $user) {
    $stmt = $conn->prepare("INSERT INTO users (username, user_type, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user['username'], $user['user_type'], $user['password']);
    if ($stmt->execute()) {
        echo "User " . $user['username'] . " inserted successfully.<br>";
    } else {
        echo "Error inserting user " . $user['username'] . ": " . $stmt->error . "<br>";
    }
}

// Create admission table
$sql = "CREATE TABLE IF NOT EXISTS admission (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    message TEXT,
    created_at DATETIME NOT NULL
)";

if (mysqli_query($conn, $sql)) {
    echo "Admission table created successfully or already exists.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Sample data for admission
$admissions = [
    ['name' => 'Mwinga Macowen Keru', 'email' => 'mwingamacowen@gmail.com', 'phone' => '0715622198', 'message' => 'full stack development', 'created_at' => '2024-06-16 09:53:27'],
    ['name' => 'John Doe', 'email' => 'johnd@gmail.com', 'phone' => '0783522356', 'message' => 'cyber security', 'created_at' => '2024-06-16 10:03:38']
];

// Insert data into admission table
foreach ($admissions as $admission) {
    $stmt = $conn->prepare("INSERT INTO admission (name, email, phone, message, created_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $admission['name'], $admission['email'], $admission['phone'], $admission['message'], $admission['created_at']);
    if ($stmt->execute()) {
        echo "Admission record for " . $admission['name'] . " inserted successfully.<br>";
    } else {
        echo "Error inserting admission record for " . $admission['name'] . ": " . $stmt->error . "<br>";
    }
}

// Create faculties table
$sql = "CREATE TABLE IF NOT EXISTS faculties (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
)";

if (mysqli_query($conn, $sql)) {
    echo "Faculties table created successfully or already exists.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Sample data for faculties
$faculties = [
    ['name' => 'Health Sciences'],
    ['name' => 'Engineering'],
    ['name' => 'Tourism and Hospitality'],
    ['name' => 'Business and Management'],
    ['name' => 'Computer Science']
];

// Insert data into faculties table
foreach ($faculties as $faculty) {
    $stmt = $conn->prepare("INSERT INTO faculties (name) VALUES (?)");
    $stmt->bind_param("s", $faculty['name']);
    if ($stmt->execute()) {
        echo "Faculty " . $faculty['name'] . " inserted successfully.<br>";
    } else {
        echo "Error inserting faculty " . $faculty['name'] . ": " . $stmt->error . "<br>";
    }
}

// Close the connection
mysqli_close($conn);
