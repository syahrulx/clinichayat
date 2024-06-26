<?php 
session_start();

// Clear any existing session variables
session_unset();

// Define the base directory
$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/login/connection.php");
include($baseDir . "/login/functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // Array of table names to check
        $tables = ['admin', 'doctor', 'staff', 'patient'];
        $user_data = null;
        $user_role = '';

        // Iterate over each table to find the user
        foreach ($tables as $table) {
            $query = "SELECT * FROM $table WHERE username = '$user_name' LIMIT 1";
            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                $user_role = $table; // Set the role based on the table name
                break;
            }
        }

        // Verify password
        if ($user_data && $password == $user_data['password']) {
            switch ($user_role) {
                case 'admin':
                    $_SESSION['user_id'] = $user_data['AdminID']; // Correct column name for admin table
                    break;
                case 'doctor':
                    $_SESSION['user_id'] = $user_data['DoctorID'];
                    break;
                case 'staff':
                    $_SESSION['user_id'] = $user_data['StaffID'];
                    break;
                case 'patient':
                    $_SESSION['user_id'] = $user_data['PatientID'];
                    break;
            }
            $_SESSION['user_role'] = $user_role;
            $_SESSION['user_name'] = $user_data['username']; // Store username in session
            $_SESSION['login_success'] = "Login successful!";

            // Debugging: Check session variables after setting them
            echo '<pre>';
            echo "Session Variables after  setting:\n";
            print_r($_SESSION);
            echo '</pre>';

            // Redirect based on user role
            switch ($user_role) {
                case 'admin':
                    header("Location: admin/admin_page.php");
                    break;
                case 'doctor':
                    header("Location: doctor/app-list.php");
                    break;
                case 'staff':
                    header("Location: staff/staff_page.php");
                    break;
                case 'patient':
                    header("Location: patient/index.php");
                    break;
            }
            exit;
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "Please enter valid username and password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    <div class="container mx-auto p-8">
        <div class="flex justify-center items-center">
            <div class="w-full lg:w-1/2   bg-white shadow-2xl rounded-lg">
                <h3 class="pt-4 text-2xl text-center font-semibold">Login</h3>
                <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded" method="post">
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="user_name">
                            Username
                        </label>
                        <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="user_name" id="user_name" placeholder="Your username" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="password">
                            Password
                        </label>
                        <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="password" name="password" id="password" placeholder="Your password" required>
                    </div>
                    <div class="mb-6 text-center">
                        <button class="w-full px-4 py-2 font-bold text-white bg-purple-500 rounded-full hover:bg-purple-700 focus:outline-none focus:shadow-outline" type="submit">
                            Login
                        </button>
                    </div>
                    <div class="text-center">
                        <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800" href="signup.php">
                            Don't have an account? Sign Up
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

