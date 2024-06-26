<?php
// Define the base directory using __DIR__ to get the directory of the current script
$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/connection.php");

// Update payment status
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];

    // Fetch appointment details
    $appointment_sql = "SELECT patient_id, price FROM appointment WHERE Ap_ID=$appointment_id";
    $appointment_result = $con->query($appointment_sql);
    $appointment = $appointment_result->fetch_assoc();

    $patient_id = $appointment['patient_id'];
    $amount = $appointment['price'];

    // Fetch total prescription fee for the appointment
    $prescription_sql = "SELECT SUM(Pr_Price) AS total_fee FROM prescription WHERE appointment_id=$appointment_id";
    $prescription_result = $con->query($prescription_sql);
    $prescription = $prescription_result->fetch_assoc();
    $total_fee = $amount + ($prescription['total_fee'] ?? 0);

    // Check if a payment record exists for the appointment
    $check_sql = "SELECT * FROM payments WHERE appointment_id=$appointment_id";
    $check_result = $con->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Update existing payment record
        $sql = "UPDATE payments SET status='$status', amount=$total_fee WHERE appointment_id=$appointment_id";
    } else {
        // Insert new payment record with default amount and provided status
        $sql = "INSERT INTO payments (appointment_id, patient_id, amount, status) VALUES ($appointment_id, $patient_id, $total_fee, '$status')";
    }

    if ($con->query($sql) === TRUE) {
        echo "Payment status updated successfully";
    } else {
        echo "Error updating payment status: " . $con->error;
    }

    // Redirect back to the staff page
    header("Location: staff_page.php");
    exit();
}

$con->close();
?>
