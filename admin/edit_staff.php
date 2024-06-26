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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Update more fields as necessary
    $query = "UPDATE staff SET 
                S_Name = '$name', 
                S_DoB = '$dob', 
                S_Address = '$address', 
                S_PhoneNo = '$phone', 
                S_Email = '$email', 
                S_Position = '$position', 
                S_Salary = '$salary', 
                username = '$username', 
                password = '$password' 
              WHERE StaffID = '$id'";
              
    $result = mysqli_query($con, $query);

    if ($result) {
        header("Location: admin_dashboard.php");
    } else {
        die("Update Failed: " . mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Staff</h1>
        <form method="post" action="edit_staff.php">
            <input type="hidden" name="id" value="<?php echo $staff['StaffID']; ?>">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo $staff['S_Name']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="dob" value="<?php echo $staff['S_DoB']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" name="address" value="<?php echo $staff['S_Address']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone" value="<?php echo $staff['S_PhoneNo']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $staff['S_Email']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Position</label>
                <input type="text" class="form-control" name="position" value="<?php echo $staff['S_Position']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Salary</label>
                <input type="number" class="form-control" name="salary" value="<?php echo $staff['S_Salary']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?php echo $staff['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" value="<?php echo $staff['password']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
