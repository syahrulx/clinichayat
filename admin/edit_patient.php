<?php
session_start();

// Define the base directory using __DIR__ to get the directory of the current script
$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/connection.php");


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM patient WHERE PatientID = '$id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $patient = mysqli_fetch_assoc($result);
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
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Update more fields as necessary
    $query = "UPDATE patient SET 
                P_Name = '$name', 
                P_DoB = '$dob', 
                P_Address = '$address', 
                P_PhoneNo = '$phone', 
                P_Email = '$email', 
                username = '$username', 
                password = '$password' 
              WHERE PatientID = '$id'";
              
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
    <title>Edit Patient</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Patient</h1>
        <form method="post" action="edit_patient.php">
            <input type="hidden" name="id" value="<?php echo $patient['PatientID']; ?>">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo $patient['P_Name']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="dob" value="<?php echo $patient['P_DoB']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" name="address" value="<?php echo $patient['P_Address']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone" value="<?php echo $patient['P_PhoneNo']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $patient['P_Email']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?php echo $patient['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" value="<?php echo $patient['password']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
