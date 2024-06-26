<?php
session_start();
$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/connection.php");
include($baseDir . "/functions.php");

$user_data = check_login($con);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $user_data['PatientID'];
    $emergency_contact = mysqli_real_escape_string($con, $_POST['emergency']);
    $allergies = mysqli_real_escape_string($con, $_POST['allergies']);
    $chronic_disease = mysqli_real_escape_string($con, $_POST['disease']);
    $past_surgeries = mysqli_real_escape_string($con, $_POST['surgeries']);
    $medical_conditions = mysqli_real_escape_string($con, $_POST['conditions']);
    $medical_history = mysqli_real_escape_string($con, $_POST['history']);
    $family_history = mysqli_real_escape_string($con, $_POST['family']);

    // Update the patient's medical history in the database
    $query = "UPDATE patient SET 
              emergency_contact = '$emergency_contact', 
              allergies = '$allergies', 
              chronic_disease = '$chronic_disease', 
              past_surgeries = '$past_surgeries', 
              medical_conditions = '$medical_conditions', 
              medical_history = '$medical_history', 
              family_history = '$family_history' 
              WHERE PatientID = '$patient_id'";

    if (mysqli_query($con, $query)) {
        $_SESSION['message'] = "Medical history updated successfully.";
    } else {
        $_SESSION['message'] = "Failed to update medical history.";
    }

    header("Location:patient/index.php");
    exit();
}
?>
