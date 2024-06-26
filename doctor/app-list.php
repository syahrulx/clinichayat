<?php
session_start();

$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/connection.php");
include($baseDir . "/functions.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User ID not set in session.";
    header("Location: login.php");
    exit;
}

// Correct the SQL query by removing the trailing comma after 'notes'
$sql = "SELECT Ap_ID, appointmentType, date, time, doctor, notes, patient_id, status FROM appointment ORDER BY FIELD(status, 'pending', 'done'), date ASC, time ASC";
$result = $con->query($sql);

$appointments = array();
if ($result) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
    } else {
        echo "0 results";
    }
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Appointments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .done {
            background-color: #e0e0e0;
            color: #888;
        }
        .done a {
            pointer-events: none;
            color: #888;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-1/5 bg-gray-200 p-4">
            <div class="text-2xl font-bold flex items-center mb-6">
                <i class="fas fa-clinic-medical mr-2"></i> Clinic HAYAT
            </div>
            <ul>
                <li class="mb-4"><a href="#" class="text-gray-700 hover:text-black"><i class="fas fa-calendar-alt mr-2"></i>Appointments</a></li>
                <li class="mb-4"><a href="#" class="text-gray-700 hover:text-black"><i class="fas fa-prescription-bottle-alt mr-2"></i>Prescriptions</a></li>
                <li class="mb-4"><a href="#" class="text-gray-700 hover:text-black"><i class="fas fa-user mr-2"></i>Profile</a></li>
            </ul>
        </div>

        <!-- Main content -->
        <div class="flex-1 p-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Appointments</h1>
                <div class="flex items-center space-x-4">
                    <i class="fas fa-bell"></i>
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
            <div class="space-y-4">
                <?php if (!empty($appointments)): ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <div class="bg-white p-6 rounded-lg shadow flex justify-between items-center <?php echo $appointment['status'] === 'done' ? 'done' : ''; ?>">
                            <div>
                                <div class="text-sm">Date & Time: <?php echo htmlspecialchars($appointment['date']) . ' ' . htmlspecialchars($appointment['time']); ?></div>
                                <div class="text-sm">Type: <?php echo htmlspecialchars($appointment['appointmentType']); ?></div>
                                <div class="text-sm">Doctor: <?php echo htmlspecialchars($appointment['doctor']); ?></div>
                                <div class="text-sm">Note: <?php echo htmlspecialchars($appointment['notes']); ?></div>
                            </div>
                            <a href="consultform.php?appointment_id=<?php echo $appointment['Ap_ID']; ?>&patient_id=<?php echo $appointment['patient_id']; ?>" class="text-blue-500">Details</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-white p-6 rounded-lg shadow">
                        No appointments found.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
