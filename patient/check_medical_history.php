<?php
session_start();

// Enable error reporting for debugging purposes (optional)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the base directory using __DIR__ to get the directory of the current script
$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/connection.php");
include($baseDir . "/functions.php");

// Check if user is logged in and get their patient ID
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'patient') {
    header("Location: ../login/login.php");
    exit();
}

$patient_id = $_SESSION['user_id'];

// Check medical history completeness
$check_medical_history_query = "SELECT emergency_contact, allergies, chronic_disease, past_surgeries, medical_conditions, medical_history, family_history FROM patient WHERE PatientID = '$patient_id'";
$medical_history_result = mysqli_query($con, $check_medical_history_query);

if (!$medical_history_result) {
    die('Query failed: ' . mysqli_error($con));
}

$medical_history = mysqli_fetch_assoc($medical_history_result);

// Ensure all values are trimmed to avoid issues with extra spaces
foreach ($medical_history as $key => $value) {
    $medical_history[$key] = trim($value);
}

// Check if any of the required fields are empty
$incomplete = false;
foreach ($medical_history as $key => $value) {
    if ($value === '') {
        $incomplete = true;
    }
}

if ($incomplete) {
    $_SESSION['message'] = "Please complete your medical history before booking an appointment.";
    header("Location: medform.php");
    exit();
} else {
    header("Location: appointment.php");
    exit();
}
?>
