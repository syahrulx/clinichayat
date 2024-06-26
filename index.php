<?php 

session_start();


// Define the base directory using __DIR__ to get the directory of the current script
$baseDir = dirname(__DIR__);

// Include necessary files using absolute paths
include($baseDir . "/connection.php");
include($baseDir . "/functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hayat Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php
            if (isset($_SESSION['appointment_success'])) {
                echo 'Swal.fire("Success", "' . $_SESSION['appointment_success'] . '", "success");';
                unset($_SESSION['appointment_success']); // Clear the session variable after displaying the message
            }

            if (isset($_SESSION['login_success'])) {
                echo 'Swal.fire("Success", "' . $_SESSION['login_success'] . '", "success");';
                unset($_SESSION['login_success']); // Clear the session variable after displaying the message
            }
            ?>
        });
    </script>
</head>
<body class="bg-white font-sans">
    <header class="bg-white py-4 px-6  shadow-md">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-purple-600">HAYAT CLINIC</h1>
            <nav>
                <ul class="flex space-x-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <li class=" mt-2" ><span class="uppercase font-semibold text-purple-700">Hi patient <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>!</span></li>
                        <li><a href="../logout.php" class="text-white bg-purple-600 hover:bg-purple-900 px-4 py-2 rounded-md"><button class="bg-transparent hover:bg-purple-600 text-white font-semibold hover:text-white py-2 px-4 border border-purple-600 hover:border-transparent rounded">Log out</button></a></li>
                    <?php else: ?>
                        <li><a href="../login.php" class="text-white bg-purple-600 hover:bg-purple-900 px-4 py-2 rounded-md"><button class="bg-transparent hover:bg-purple-600 text-white font-semibold hover:text-white py-2 px-4 border border-purple-600 hover:border-transparent rounded">Login</button></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="bg-gray-100 py-3">
        <section class="relative" style="background-image: url('../image/pic1.jpg'); background-repeat: no-repeat; background-position: center; background-size: cover; height: 60vh;">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative z-10 flex justify-center items-center h-full">
                <div class="text-center text-white">
                    <h2 class="text-4xl font-semibold mb-4">Access quality healthcare services for a healthier you.</h2>
                    <div class="flex justify-center">
                        <input type="text" placeholder="Search for your services" class="text-black border-2 border-gray-300 rounded-md p-2 w-1/2">
                        <button class="bg-purple-600 text-white rounded-md px-4 py-2 ml-2 hover:bg-purple-900">Submit</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="container mx-auto mt-20 ">
            <div class="flex justify-around text-center mb-20">
                <a href="../services/checkup.php" class="transform transition hover:scale-105">
                    <div class="bg-white p-10 rounded-lg shadow-md w-72 hover:bg-gray-200">
                        <i class="fas fa-stethoscope fa-2x mb-4 text-purple-600"></i>
                        <p class="text-lg font-semibold">Check-ups</p>
                    </div>
                </a>
                <a href="../services/consultation.php" class="transform transition hover:scale-105">
                    <div class="bg-white p-10 rounded-lg shadow-md w-72 hover:bg-gray-200">
                        <i class="fas fa-user-md fa-2x mb-4 text-purple-600"></i>
                        <p class="text-lg font-semibold">Consultation</p>
                    </div>
                </a>
                <a href="../services/screening.php" class="transform transition hover:scale-105">
                    <div class="bg-white p-10 rounded-lg shadow-md w-72 hover:bg-gray-200">
                        <i class="fas fa-microscope fa-2x mb-4 text-purple-600"></i>
                        <p class="text-lg font-semibold">Screening</p>
                    </div>
                </a>
                <a href="../services/vaccine.php" class="transform transition hover:scale-105">
                    <div class="bg-white p-10 rounded-lg shadow-md w-72 hover:bg-gray-200">
                        <i class="fas fa-syringe fa-2x mb-4 text-purple-600"></i>
                        <p class="text-lg font-semibold">Vaccine</p>
                    </div>
                </a>
            </div>
        </section>

        <div class="text-center mb-20">
        <a href="<?php 
                if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'patient') {
                    echo 'check_medical_history.php';
                } else {
                    echo '../login.php';
                }
            ?>">
        <button class="bg-purple-600 text-white rounded-full px-12 py-4 hover:bg-purple-900 transition">Set Appointment</button>
    </a>
        </div>
    </main>

    <footer class="bg-gray-800 text-gray-200 py-8">
        <div class="container mx-auto flex justify-between">
            <div class="flex-1">
                <h3 class="font-bold text-lg mb-2">Connect with Us</h3>
                <div class="flex">
                    <input type="email" placeholder="Enter your email address" class="border-2 border-gray-300 rounded-md p-2 w-2/3">
                    <button class="bg-purple-600 text-white rounded-md px-4 py-2 ml-2 hover:bg-purple-900">Submit</button>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-lg mb-2">Company</h3>
                <ul>
                    <li class="mb-1"><a href="#" class="hover:text-white">About Services</a></li>
                    <li class="mb-1"><a href="#" class="hover:text-white">Contact</a></li>
                    <li class="mb-1"><a href="#" class="hover:text-white">Careers</a></li>
                    <li><a href="#" class="hover:text-white">Updates Help</a></li>
                </ul>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-lg mb-2">Connect with</h3>
                <ul>
                    <li class="mb-1"><a href="#" class="hover:text-white">Facebook</a></li>
                    <li class="mb-1"><a href="#" class="hover:text-white">Twitter</a></li>
                    <li class="mb-1"><a href="#" class="hover:text-white">LinkedIn</a></li>
                    <li><a href="#" class="hover:text-white">Instagram</a></li>
                </ul>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-lg mb-2">For Healthcare</h3>
                <ul>
                    <li class="mb-1"><a href="#" class="hover:text-white">Partnerships</a></li>
                    <li class="mb-1"><a href="#" class="hover:text-white">Collaborations</a></li>
                    <li class="mb-1"><a href="#" class="hover:text-white">Appointment Listings</a></li>
                    <li><a href="#" class="hover:text-white">Business Support</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-8 text-center">
            <p>&copy; 2023 Hayat Clinic. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

