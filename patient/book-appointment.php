<?php
session_start();

include("../connection.php");
include("../functions.php");

$user_data = check_login($con);

$patient_id = $user_data['PatientID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointmentType = $_POST['appointmentType'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $doctor = $_POST['doctor'];
    $notes = $_POST['notes'];
    $patient_id = $_POST['patient_id'];

    // Debugging: Display received data
    echo "Received data:<br>";
    echo "Appointment Type: $appointmentType<br>";
    echo "Date: $date<br>";
    echo "Time: $time<br>";
    echo "Doctor: $doctor<br>";
    echo "Notes: $notes<br>";
    echo "Patient ID: $patient_id<br>";

    // Validate the date format
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
        $_SESSION['appointment_success'] = "Invalid date format. Please use YYYY-MM-DD.";
        echo "Invalid date format. Please use YYYY-MM-DD.<br>";
        exit();
    }

    // Ensure the date is valid and not in the past
    $current_date = date("Y-m-d");
    if ($date < $current_date) {
        $_SESSION['appointment_success'] = "The selected date cannot be in the past.";
        echo "The selected date cannot be in the past.<br>";
        exit();
    }

    // Determine the price based on appointment type
    $price = 0;
    switch ($appointmentType) {
        case 'General Check-up':
            $price = 50.00;
            break;
        case 'Specialist Consultation':
            $price = 100.00;
            break;
        case 'Screening':
            $price = 75.00;
            break;
        case 'Vaccine':
            $price = 25.00;
            break;
    }
    echo "Price: $price<br>";

    // Check if patient_id exists in the patient table
    $patient_check_query = "SELECT * FROM patient WHERE PatientID = '$patient_id' LIMIT 1";
    $patient_result = mysqli_query($con, $patient_check_query);

    if (mysqli_num_rows($patient_result) > 0) {
        if (!empty($appointmentType) && !empty($date) && !empty($time) && !empty($doctor) && !empty($patient_id)) {
            // Insert the appointment into the database
            $status = "pending";
            $query = "INSERT INTO appointment (appointmentType, date, time, doctor, notes, patient_id, price, status) 
                      VALUES ('$appointmentType', '$date', '$time', '$doctor', '$notes', '$patient_id', '$price', '$status')";

            if (mysqli_query($con, $query)) {
                $_SESSION['appointment_success'] = "Appointment booked successfully!";
                echo "Appointment booked successfully!<br>";
                exit();
            } else {
                $_SESSION['appointment_success'] = "Failed to book appointment. Please try again.";
                echo "Failed to book appointment. Please try again.<br>";
                echo "MySQL error: " . mysqli_error($con) . "<br>"; // Log MySQL error for debugging
                exit();
            }
        } else {
            $_SESSION['appointment_success'] = "Please fill in all required fields.";
            echo "Please fill in all required fields.<br>";
            exit();
        }
    } else {
        $_SESSION['appointment_success'] = "Invalid patient ID.";
        echo "Invalid patient ID.<br>";
        exit();
    }
}
?>
