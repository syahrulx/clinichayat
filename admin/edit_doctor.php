<?php
session_start();

// Define the base directory using __DIR__ to get the directory of the current script
$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/connection.php");


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM doctor WHERE DoctorID = '$id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $doctor = mysqli_fetch_assoc($result);
    } else {
        die("Query Failed: " . mysqli_error($con));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $specialize = $_POST['specialize'];
    // Update more fields as necessary

    $query = "UPDATE doctor SET D_Name = '$name', D_Specialize = '$specialize' WHERE DoctorID = '$id'";
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
    <title>Edit Doctor</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1> Doctor</h1>
        <form method="post" action="edit_doctor.php">
            <input type="hidden" name="id" value="<?php echo $doctor['DoctorID']; ?>">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo $doctor['D_Name']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="text" class="form-control" name="D_DoB" value="<?php echo $doctor['D_DoB']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" name="Address" value="<?php echo $doctor['D_Address']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="Phone" value="<?php echo $doctor['D_PhoneNo']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email" value="<?php echo $doctor['D_Email']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Specialization</label>
                <input type="text" class="form-control" name="specialize" value="<?php echo $doctor['D_Specialize']; ?>" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
