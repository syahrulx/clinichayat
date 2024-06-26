<?php
session_start();
$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/connection.php");
include($baseDir . "/functions.php");

$appointment = null;
$patient = null;
$medicines = [];

// Fetch medicines from the medicine table
$med_query = "SELECT * FROM medicine";
$med_result = $con->query($med_query);
if ($med_result && $med_result->num_rows > 0) {
    while ($row = $med_result->fetch_assoc()) {
        $medicines[] = $row;
    }
}

if (isset($_GET['appointment_id']) && isset($_GET['patient_id'])) {
    $appointment_id = $_GET['appointment_id'];
    $patient_id = $_GET['patient_id'];

    // Fetch appointment details
    $sql = "SELECT * FROM appointment WHERE Ap_ID = '$appointment_id' LIMIT 1";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $appointment = $result->fetch_assoc();

        // Fetch patient details including medical history
        $sql_patient = "SELECT * FROM patient WHERE PatientID = '$patient_id' LIMIT 1";
        $result_patient = $con->query($sql_patient);

        if ($result_patient && $result_patient->num_rows > 0) {
            $patient = $result_patient->fetch_assoc();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $patient_id = $_POST['patient_id'];
    $doctor_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $symptoms = !empty($_POST['symptoms']) ? $_POST['symptoms'] : null;
    $severity = !empty($_POST['severity']) ? $_POST['severity'] : null;
    $duration = !empty($_POST['duration']) ? $_POST['duration'] : null;
    $notes = $_POST['notes'];
    $diagnosis = !empty($_POST['diagnosis']) && $_POST['diagnosis'] != 'Select Diagnosis' ? $_POST['diagnosis'] : null;
    $medication = !empty($_POST['medication']) ? $_POST['medication'] : null;
    $dosage = !empty($_POST['dosage']) ? $_POST['dosage'] : null;
    $frequency = !empty($_POST['frequency']) ? $_POST['frequency'] : null;
    $special_instructions = $_POST['special_instructions'];

    if ($doctor_id !== null) {
        // Insert into consultation table
        $query = "INSERT INTO consultation (patient_id, doctor_id, appointment_id, symptoms, severity, duration, notes, diagnosis) 
                  VALUES ('$patient_id', '$doctor_id', '$appointment_id', '$symptoms', '$severity', '$duration', '$notes', '$diagnosis')";

        if (mysqli_query($con, $query)) {
            // Fetch the price of the selected medication
            $price_query = "SELECT Price FROM medicine WHERE MedName = '$medication' LIMIT 1";
            $price_result = $con->query($price_query);
            $price = 0;
            if ($price_result && $price_result->num_rows > 0) {
                $price_row = $price_result->fetch_assoc();
                $price = $price_row['Price'];
            }

            // Insert into prescription table
            $query = "INSERT INTO prescription (PatientID, DoctorID, Pr_MedName, Pr_Dosage, Pr_Frequency, Pr_Instruction, Pr_Price, appointment_id) 
                      VALUES ('$patient_id', '$doctor_id', '$medication', '$dosage', '$frequency', '$special_instructions', '$price', '$appointment_id')";

            if (mysqli_query($con, $query)) {
                // Update the appointment status to done
                $update_status_query = "UPDATE appointment SET status = 'done' WHERE Ap_ID = '$appointment_id'";
                if (mysqli_query($con, $update_status_query)) {
                    $_SESSION['message'] = "Consultation and prescription saved. Appointment status updated to done.";
                    header("Location: app-list.php");
                    exit();
                } else {
                    echo "Error updating appointment status: " . mysqli_error($con);
                }
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($con);
            }
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con);
        }
    } else {
        echo "Error: Doctor ID is not set in the session.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Consultation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-1/5 bg-gray-200 p-4">
            <div class="text-2xl font-bold flex items-center mb-6">
                <i class="fas fa-clinic-medical mr-2"></i> Clinic HAYAT
            </div>
            <ul>
                <li class="mb-4"><a href="doctor-dashboard.php" class="text-gray-700 hover:text-black"><i class="fas fa-calendar-alt mr-2"></i>Appointments</a></li>
                <li class="mb-4"><a href="#" class="text-gray-700 hover:text-black"><i class="fas fa-prescription-bottle-alt mr-2"></i>Prescriptions</a></li>
                <li class="mb-4"><a href="#" class="text-gray-700 hover:text-black"><i class="fas fa-user mr-2"></i>Profile</a></li>
            </ul>
        </div>

        <!-- Main content -->
        <div class="flex-1 p-10">
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h2 class="text-xl font-bold mb-4">Patient Details</h2>
                <?php if ($patient): ?>
                    <p>Name: <?php echo htmlspecialchars($patient['P_Name']); ?></p>
                    <p>Date of Birth: <?php echo htmlspecialchars($patient['P_DoB']); ?></p>
                    <p>Address: <?php echo htmlspecialchars($patient['P_Address']); ?></p>
                    <p>Phone Number: <?php echo htmlspecialchars($patient['P_PhoneNo']); ?></p>
                    <p>Email: <?php echo htmlspecialchars($patient['P_Email']); ?></p>
                    <p>Emergency Contact: <?php echo htmlspecialchars($patient['emergency_contact']); ?></p>
                    <p>Allergies: <?php echo htmlspecialchars($patient['allergies']); ?></p>
                    <p>Chronic Disease: <?php echo htmlspecialchars($patient['chronic_disease']); ?></p>
                    <p>Past Surgeries: <?php echo htmlspecialchars($patient['past_surgeries']); ?></p>
                    <p>Medical Conditions: <?php echo htmlspecialchars($patient['medical_conditions']); ?></p>
                    <p>Medical History: <?php echo htmlspecialchars($patient['medical_history']); ?></p>
                    <p>Family History: <?php echo htmlspecialchars($patient['family_history']); ?></p>
                <?php else: ?>
                    <p>No patient details found.</p>
                <?php endif; ?>
            </div>

            <form method="POST" action="">
                <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment_id); ?>">
                <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient_id); ?>">
                <div class="bg-white p-6 rounded-lg shadow mb-6">
                    <h2 class="text-xl font-bold mb-4">Consultation</h2>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <input type="text" name="symptoms" placeholder="Symptoms" class="border border-gray-300 rounded-lg px-4 py-2">
                        <input type="text" name="severity" placeholder="Severity" class="border border-gray-300 rounded-lg px-4 py-2">
                        <input type="text" name="duration" placeholder="Duration" class="border border-gray-300 rounded-lg px-4 py-2">
                        <input type="text" name="notes" placeholder="Notes" class="border border-gray-300 rounded-lg px-4 py-2" required>
                    </div>
                    <select name="diagnosis" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                        <option>Select Diagnosis</option>
                        <!-- Add diagnosis options here -->
                    </select>
                </div>

                <div class="bg-white p-6 rounded-lg shadow mb-6">
                    <h2 class="text-xl font-bold mb-4">Treatment</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <select name="medication" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                            <option>Select Medication</option>
                            <?php foreach ($medicines as $medicine): ?>
                                <option value="<?php echo htmlspecialchars($medicine['MedName']); ?>"><?php echo htmlspecialchars($medicine['MedName']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="dosage" placeholder="Dosage" class="border border-gray-300 rounded-lg px-4 py-2">
                        <input type="text" name="frequency" placeholder="Frequency" class="border border-gray-300 rounded-lg px-4 py-2">
                        <input type="text" name="special_instructions" placeholder="Special Instructions" class="border border-gray-300 rounded-lg px-4 py-2" required>
                    </div>
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg mt-4">Add Prescription</button>
                </div>
            </form>
            
            <footer class="bg-white p-4 rounded-lg shadow mt-6 flex justify-between">
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-600 hover:text-black">Home</a>
                    <a href="#" class="text-gray-600 hover:text-black">Appointments</a>
                    <a href="#" class="text-gray-600 hover:text-black">Services</a>
                    <a href="#" class="text-gray-600 hover:text-black">Prescriptions</a>
                    <a href="#" class="text-gray-600 hover:text-black">Consultation</a>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-600 hover:text-black">Terms of Service</a>
                    <a href="#" class="text-gray-600 hover:text-black">Privacy Policy</a>
                    <a href="#" class="text-gray-600 hover:text-black">Contact Us</a>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>



