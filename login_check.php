ks<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include "connection.php";

    if ($conn === false) {
        $_SESSION['loginMessage'] = "Could not connect to database";
        header('Location: login.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = strtolower(trim($_POST['username']));
        $password = trim($_POST['password']);

        if ($stmt = $conn->prepare("SELECT user_type FROM `users` WHERE username = ? AND password = ?")) {
            $stmt->bind_param("ss", $name, $password);
            $stmt->execute();
            $stmt->bind_result($user_type);
            $stmt->fetch();

            if ($user_type) {
                $_SESSION['username'] = $name;
                $_SESSION['user_type'] = $user_type;

                if ($user_type == 'student') {
                    header('Location: studentHome.php');
                    exit();
                } elseif ($user_type == 'admin') {
                    header('Location: adminHome.php');
                    exit();
                } else {
                    $_SESSION['loginMessage'] = "Invalid user type";
                    header('Location: login.php');
                    exit();
                }
            } else {
                $_SESSION['loginMessage'] = "Username and password are not found";
                header('Location: login.php');
                exit();
            }
            $stmt->close();
        } else {
            $_SESSION['loginMessage'] = "Failed to prepare the SQL statement";
            header('Location: login.php');
            exit();
        }
    }

    $conn->close();
