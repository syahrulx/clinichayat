<?php
session_start();
// Define the base directory using __DIR__ to get the directory of the current script
$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/connection.php");
include($baseDir . "/functions.php");


$user_data = check_login($con);

if (isset($_SESSION['message'])) {
    echo '<p class="text-center text-red-500 mb-4">' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']);
}

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
        header("Location:appointment.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to update medical history.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical History Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f8f8f8;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            color: #6b46c1;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-label {
            color: #6b46c1;
        }
        .form-input {
            border-color: #6b46c1;
        }
        .form-input:focus {
            border-color: #6b46c1;
            box-shadow: 0 0 0 1px #6b46c1;
        }
        .form-button {
            background-color: #6b46c1;
            border-color: #6b46c1;
        }
        .form-button:hover {
            background-color: #553c9a;
        }
    </style>
</head>
<body class="bg-gray-100">
<header class="bg-white py-4 px-6 shadow-md ">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-purple-600">HAYAT CLINIC</h1>
            <nav>
                <ul class="flex space-x-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li><span class="text-gray-700">Hi patient <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?></span></li>
                        <li><a href="../logout.php" class="text-white bg-purple-600 hover:bg-purple-900 px-4 py-2 rounded-md"><button class="bg-transparent hover:bg-purple-600 text-white font-semibold hover:text-white py-2 px-4 border border-purple-600 hover:border-transparent rounded">Log out</button></a></li>
                    <?php else: ?>
                        <li><a href="../login.php" class="text-white bg-purple-600 hover:bg-purple-900 px-4 py-2 rounded-md"><button class="bg-transparent hover:bg-purple-600 text-white font-semibold hover:text-white py-2 px-4 border border-purple-600 hover:border-transparent rounded">Login</button></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container mx-auto px-4 py-8">
       
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h1 class="header text-2xl font-semibold mb-6">Medical History</h1>
            <form action="medformdata.php" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="emergency" class="form-label block text-sm font-medium mb-1">Emergency Contact</label>
                        <input type="text" name="emergency" id="emergency" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" placeholder="Emergency Contact">
                    </div>
                    <div>
                        <label for="allergies" class="form-label block text-sm font-medium mb-1">Allergies</label>
                        <input type="text" name="allergies" id="allergies" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" placeholder="Allergies">
                    </div>
                    <div>
                        <label for="disease" class="form-label block text-sm font-medium mb-1">Chronic Disease</label>
                        <input type="text" name="disease" id="disease" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" placeholder="Chronic Disease">
                    </div>
                    <div>
                        <label for="surgeries" class="form-label block text-sm font-medium mb-1">Past Surgeries</label>
                        <input type="text" name="surgeries" id="surgeries" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" placeholder="Past Surgeries">
                    </div>
                    <div>
                        <label for="conditions" class="form-label block text-sm font-medium mb-1">Medical Conditions</label>
                        <input type="text" name="conditions" id="conditions" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" placeholder="Medical Conditions">
                    </div>
                    <div>
                        <label for="history" class="form-label block text-sm font-medium mb-1">Medical History</label>
                        <input type="text" name="history" id="history" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" placeholder="Medical History">
                    </div>
                    <div>
                        <label for="family" class="form-label block text-sm font-medium mb-1">Family History</label>
                        <input type="text" name="family" id="family" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" placeholder="Family History">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="form-button px-4 py-2 text-white rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
