<?php
session_start();


// Define the base directory using __DIR__ to get the directory of the current script
$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/connection.php");
include($baseDir . "/functions.php");


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User ID not set in session.";
    header("Location: ../login.php");
    exit;
}

// Fetch doctors, patients, and staff from the database
$doctors_query = "SELECT * FROM doctor";
$patients_query = "SELECT * FROM patient";
$staff_query = "SELECT * FROM staff";

$doctors_result = mysqli_query($con, $doctors_query);
$patients_result = mysqli_query($con, $patients_query);
$staff_result = mysqli_query($con, $staff_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="items-center justify-center">
<header class="bg-white px-6 py-4 shadow-md">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-purple-600">HAYAT CLINIC</h1>
        <nav>
            <ul class="flex space-x-4">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li>
                        <a href="../logout.php" class="text-white bg-purple-600 hover:bg-purple-900 px-4 py-2 rounded-md">
                            <button class="bg-transparent hover:bg-purple-600 text-white font-semibold hover:text-white py-2 px-4 border border-purple-600 hover:border-transparent rounded">
                                Log out
                            </button>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="../login.php" class="text-white bg-purple-600 hover:bg-purple-900 px-4 py-2 rounded-md">
                            <button class="bg-transparent hover:bg-purple-600 text-white font-semibold hover:text-white py-2 px-4 border border-purple-600 hover:border-transparent rounded">
                                Login
                            </button>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<main class="container mx-auto p-8 bg-white shadow-2xl rounded-lg mt-10">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-purple-700 mb-2 uppercase">Manage Your Hospital's Data</h1>
        <p class="text-gray-600 text-lg">Easily manage doctors, patients, and staff</p>
    </div>
    <div class="flex justify-center space-x-6 mb-8">
        <button class="py-2 px-4 border-2 border-purple-600 text-black rounded-lg hover:bg-purple-500 transition duration-200" onclick="showTab('doctors')">Doctors</button>
        <button class="py-2 px-4 border-2 border-purple-600 text-black rounded-lg hover:bg-purple-500 transition duration-200" onclick="showTab('patients')">Patients</button>
        <button class="py-2 px-4 border-2 border-purple-600 text-black rounded-lg hover:bg-purple-500 transition duration-200" onclick="showTab('staff')">Staff</button>
    </div>
    <div id="doctors" class="tab-content">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Doctors</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class=" text-purple-800 border-4 ">
                    <tr>
                        <th class="py-3 px-6 text-center">ID</th>
                        <th class="py-3 px-6 text-center">Name</th>
                        <th class="py-3 px-6 text-center">Specialization</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($doctor = mysqli_fetch_assoc($doctors_result)) { ?>
                    <tr class="hover:bg-gray-100 transition-colors duration-200">
                        <td class="hover:text-purple-600 py-3 px-6 text-center border-b border-gray-300"><?php echo $doctor['DoctorID']; ?></td>
                        <td class="py-3 px-6 text-center border-b border-gray-300"><?php echo $doctor['D_Name']; ?></td>
                        <td class="py-3 px-6 text-center border-b border-gray-300"><?php echo $doctor['D_Specialize']; ?></td>
                        <td class="py-3 px-6 text-center border-b border-gray-300"><?php echo generateActionButtons($doctor['DoctorID'], 'doctor'); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="patients" class="tab-content hidden">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Patients</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class= "text-purple-800 border-4">
                    <tr>
                        <th class="py-3 px-6 text-center">ID</th>
                        <th class="py-3 px-6 text-center">Name</th>
                        <th class="py-3 px-6 text-center">Phone Number</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($patient = mysqli_fetch_assoc($patients_result)) { ?>
                    <tr class="hover:bg-gray-100 transition-colors duration-200">
                        <td class="py-3 px-6 text-center border-b border-gray-300"><?php echo $patient['PatientID']; ?></td>
                        <td class="py-3 px-6 text-center border-b border-gray-300"><?php echo $patient['P_Name']; ?></td>
                        <td class="py-3 px-6 text-center border-b border-gray-300"><?php echo $patient['P_PhoneNo']; ?></td>
                        <td class="py-3 px-6 text-center border-b border-gray-300"><?php echo generateActionButtons($patient['PatientID'], 'patient'); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="staff" class="tab-content hidden">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Staff</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="text-purple-800 border-4">
                    <tr>
                        <th class="py-3 px-6 text-center">ID</th>
                        <th class="py-3 px-6 text-center">Name</th>
                        <th class="py-3 px-6 text-center">Position</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($staff = mysqli_fetch_assoc($staff_result)) { ?>
                    <tr class="hover:bg-gray-100 transition-colors duration-200">
                        <td class="py-3 px-6 text-center border-b border-gray-300"><?php echo $staff['StaffID']; ?></td>
                        <td class="py-3 px-6 text-center border-b border-gray-300"><?php echo $staff['S_Name']; ?></td>
                        <td class="py-3 px-6 text-center border-b border-gray-300"><?php echo $staff['S_Position']; ?></td>
                        <td class="py-3 px-6 text-center border-b border-gray-300"><?php echo generateActionButtons($staff['StaffID'], 'staff'); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <button class="mt-10">
    <a href="registerform.php" class="text-center border-2 font-semibold border-purple-700 text-black py-3 px-4 mt-6 rounded-lg hover:bg-purple-500 transition duration-200">Register New Doctor/Staff</a>
    </button>
   
</main>
<script>
    function showTab(tabName) {
        const tabs = document.querySelectorAll('.tab-content');
        tabs.forEach(tab => {
            tab.classList.add('hidden');
        });
        document.getElementById(tabName).classList.remove('hidden');
    }

    // Set default tab to show
    document.addEventListener("DOMContentLoaded", function() {
        showTab('doctors');
    });
</script>
</body>
</html>
