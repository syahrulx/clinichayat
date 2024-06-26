<?php
session_start();
// Define the base directory using __DIR__ to get the directory of the current script
$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/connection.php");


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM staff WHERE StaffID = '$id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $staff = mysqli_fetch_assoc($result);
    } else {
        die("Query Failed: " . mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <div class="bg-gray-100 h-screen items-center justify-center flex flex-col">
        <div class="bg-white shadow-lg rounded-lg w-full max-w-md  ">
            <div class="bg-purple-700 text-white p-4 rounded-t-lg text-center">
                <h1>View Staff</h1>
            </div>
                <div class="p-6">
                <table class="min-w-full table-auto">
                <tr>
                <th>ID</th>
                <td><?php echo $staff['StaffID']; ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?php echo $staff['S_Name']; ?></td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td><?php echo $staff['S_DoB']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $staff['S_PhoneNo']; ?></td>
            </tr>
            <tr>
                <th>Position</th>
                <td><?php echo $staff['S_Position']; ?></td>
            </tr>
            <tr>
                <th>Salary</th>
                <td><?php echo $staff['S_Salary']; ?></td>
            </tr>

                    
                </table>
            </div>

            <button class="bg-purple-400 text-white rounded-full px-4 py-2 hover:bg-purple-900 transition">
                <a href="admin_page.php" class="btn btn-primary">Back</a>
             </button>
               
        </div>
            
            
            
    </div>
    
</body>
</html>





