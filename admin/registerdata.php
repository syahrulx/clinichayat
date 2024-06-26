<?php
session_start();
// Define the base directory using __DIR__ to get the directory of the current script
$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/connection.php");
include($baseDir . "/functions.php");

// Handle registration before checking login
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_role = $_POST['user_role'];
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $specialization = $_POST['specialize'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];

    // Basic validation
    if (!empty($user_role) && !empty($user_name) && !empty($password) && !empty($name) && !empty($dob) && !empty($address) && !empty($phone) && !empty($email)) {
        // Escaping special characters for security
        $user_role = mysqli_real_escape_string($con, $user_role);
        $user_name = mysqli_real_escape_string($con, $user_name);
        $password = mysqli_real_escape_string($con, $password);
        $name = mysqli_real_escape_string($con, $name);
        $dob = mysqli_real_escape_string($con, $dob);
        $address = mysqli_real_escape_string($con, $address);
        $phone = mysqli_real_escape_string($con, $phone);
        $email = mysqli_real_escape_string($con, $email);
        $position = mysqli_real_escape_string($con, $position);
        $salary = mysqli_real_escape_string($con, $salary);
        $specialization = mysqli_real_escape_string($con, $specialization);

        if ($user_role == 'doctor') {
            $query = "INSERT INTO doctor (D_Name, D_DoB, D_Address, D_PhoneNo, D_Email, D_Specialize, username, password) VALUES ('$name', '$dob', '$address', '$phone', '$email','$specialization','$user_name', '$password')";
        } elseif ($user_role == 'staff') {
            $query = "INSERT INTO staff (S_Name, S_DoB, S_Address, S_PhoneNo, S_Email, S_Position, S_Salary, username, password) VALUES ('$name', '$dob', '$address', '$phone', '$email', '$position', '$salary', '$user_name', '$password')";
        }

        // Debugging: Log the query
        error_log("Executing query: $query");

        if (mysqli_query($con, $query)) {
            $_SESSION['registration_success'] = "Doctor/Staff successfully registered!";
            header("Location: admin_dashboard.php");
            die;
        } else {
            // Debugging: Log the error
            error_log("Error executing query: " . mysqli_error($con));
            echo "Error: " . $query . "<br>" . mysqli_error($con);
        }
    } else {
        echo "Please fill in all required fields.";
    }
}

// Check login status after handling registration
$user_data = check_login($con);
?>
