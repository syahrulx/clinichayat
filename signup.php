<?php 
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $patient_name = $_POST['patient_name'];
    $patient_dob = $_POST['patient_dob'];
    $patient_address = $_POST['patient_address'];
    $patient_phone = $_POST['patient_phone'];
    $patient_email = $_POST['patient_email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($username) && !empty($password) && !empty($confirm_password) && !empty($patient_name) && !empty($patient_dob) && !empty($patient_address) && !empty($patient_phone) && !empty($patient_email) && !is_numeric($username)) {
        if ($password === $confirm_password) {
            // Check if the user already exists in the database
            $sqlchk = "SELECT * FROM `patient` WHERE `username` = '$username'";
            $chkconn = mysqli_query($con, $sqlchk);
            $countrec = mysqli_num_rows($chkconn);

            if ($countrec == 0) {
                // Save to database
                $query = "INSERT INTO patient (P_Name, P_DoB, P_Address, P_PhoneNo, P_Email, username, password) VALUES ('$patient_name', '$patient_dob', '$patient_address', '$patient_phone', '$patient_email', '$username', '$password')";
                mysqli_query($con, $query);

                header("Location: login.php");
                die;
            } else {
                echo "<script>alert('User already exists in the database!');history.go(-1);</script>";
            }
        } else {
            echo "<script>alert('Passwords do not match!');history.go(-1);</script>";
        }
    } else {
        echo "<script>alert('Please enter some valid information!');history.go(-1);</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Medical Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto">
        <div class="flex justify-center px-6 my-12">
            <div class="w-full xl:w-3/4 lg:w-11/12 flex">
                <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg" style="background-image: url('image/pic2.png')"></div>
                <div class="w-full lg:w-1/2 bg-white p-5 rounded-lg lg:rounded-l-none">
                    <h3 class="pt-4 text-2xl text-center">Sign Up</h3>
                    <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded" method="post">
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="patient_name">
                                Full Name
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="patient_name" id="patient_name" placeholder="Your full name">
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="patient_dob">
                                Date of Birth
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="date" name="patient_dob" id="patient_dob">
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="patient_address">
                                Address
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="patient_address" id="patient_address" placeholder="Your address">
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="patient_phone">
                                Phone Number
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="patient_phone" id="patient_phone" placeholder="Your phone number">
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="patient_email">
                                Email
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="email" name="patient_email" id="patient_email" placeholder="Your email">
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="username">
                                Username
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="username" id="username" placeholder="Your username">
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="password">
                                Password
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="password" name="password" id="password" placeholder="Your password">
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="confirm_password">
                                Confirm Password
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password">
                        </div>
                        <div class="mb-6 text-center">
                            <button class="w-full px-4 py-2 font-bold text-white bg-purple-500 rounded-full hover:bg-purple-700 focus:outline-none focus:shadow-outline" type="submit">
                                Sign Up
                            </button>
                        </div>
                        <div class="text-center">
                            <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800" href="login.php">
                                Already have an account? Log in
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
