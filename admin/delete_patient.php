<?php
session_start();

include("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM patient WHERE PatientID = '$id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        header("Location: admin_dashboard.php");
    } else {
        die("Delete Failed: " . mysqli_error($con));
    }
}
?>
