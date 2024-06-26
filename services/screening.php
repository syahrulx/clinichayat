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
    <style>
        .info-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 100%;
        margin: 20px;
        padding: 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center; 
        align-items: center; 
        }
        .info-container img {
            width: 300px; 
            height: 200px; 
            object-fit: cover; 
            border-radius: 10px;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .info-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin: 20px;
            padding: 20px;
            text-align: center;
        }
        .info-container img {
            width: 300px; 
            height: 200px; 
            object-fit: cover; 
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .info-container h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .info-container p {
            color: #555;
            margin-bottom: 20px;
        }
        .main-button {
            background-color: #6b46c1;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .main-button:hover {
            background-color: #5a38a9;
        }
    </style>
</head>
<body>
    <header class="bg-white px-6 py-4 shadow-md w-full flex justify-between items-center">
        <h1 class="text-2xl font-bold text-purple-600">HAYAT CLINIC</h1>
        <nav>
            <ul class="flex space-x-4">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="../logout.php" class="main-button">Log out</a></li>
                <?php else: ?>
                    <li><a href="../login.php" class="main-button">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="bg-gray-100 py-8 flex-grow w-full flex flex-wrap justify-center">
        <div class="flex flex-grow shadow-md rounded-lg bg-white w-[600px] m-[20px] p-[20px] gap-x-8">
            <img class="w-[400px] h-[300px]" src="images/blood_pressure.jpeg" alt="Blood Pressure Check">
            <div class="flex flex-col gap-8 ">
            <h2 class="text-xl font-bold">Blood Pressure Check</h2>
            <p>Regular blood pressure checks are essential to monitor and maintain heart health. High blood pressure can lead to serious conditions like heart disease and stroke.</p>
            </div>
        </div>
        <div class="flex flex-grow shadow-md rounded-lg bg-white w-[600px] m-[20px] p-[20px] gap-x-8">
            <img class="w-[400px] h-[300px]"src="images/cholesterol_test.jpg" alt="Cholesterol Test">
            <div class="flex flex-col gap-8 ">
            <h2 class="text-xl font-bold">Cholesterol Test</h2>
            <p>Cholesterol testing helps identify your risk for cardiovascular diseases. High cholesterol levels can lead to plaque buildup in arteries, increasing the risk of heart attacks and strokes.</p>
                </div>
        </div>
        <div class="flex flex-grow shadow-md rounded-lg bg-white w-[600px] m-[20px] p-[20px] gap-x-8">
            <img class="w-[400px] h-[300px]" src="images/diabetes_screening.webp" alt="Diabetes Screening">
            <div class="flex flex-col gap-8 ">
            <h2 class="text-xl font-bold">Diabetes Screening</h2>
            <p>Diabetes screening is crucial for early detection and management of diabetes. Early detection can help prevent complications and maintain a healthier lifestyle.</p>
            </div>
        </div>
        <div class="flex flex-grow shadow-md rounded-lg bg-white w-[600px] m-[20px] p-[20px] gap-x-8">
            <img class="w-[400px] h-[300px]"  src="images/cancer_screening.jpeg" alt="Cancer Screening">
            <div class="flex flex-col gap-8 ">
            <h2 class="text-xl font-bold">Cancer Screening</h2>
            <p>Early detection of cancer through screening can save lives. We offer screenings for various types of cancer including breast, cervical, and colorectal cancers.</p>
            </div>
        </div>
        <div class="flex flex-grow shadow-md rounded-lg bg-white w-[600px] m-[20px] p-[20px] gap-x-8">
            <img class="w-[400px] h-[300px]" src="images/eye_exams.jpg" alt="Eye Exams">
            <div class="flex flex-col gap-8 ">
            <h2 class="text-xl font-bold">Eye Exams</h2>
            <p>Regular eye exams help detect vision problems, glaucoma, and other eye conditions.</p>
            </div>
        </div>
        <div class="flex flex-grow shadow-md rounded-lg bg-white w-[600px] m-[20px] p-[20px] gap-x-8">
            <img class="w-[400px] h-[300px]" src="images/dental_check-up.jpeg" alt="Dental Check-Up">
            <div class="flex flex-col gap-8">
            <h2 class="text-xl font-bold">Dental Check-Up</h2>
            <p>Regular dental check-ups help prevent oral health issues, such as cavities, gum disease, and oral infections.</p>
            </div>
        </div>
    </main>

    <div class="text-center mb-20">
        <a href="<?php echo isset($_SESSION['user_id']) ? '../patient/appointment.php' : 'login.php'; ?>">
            <button class="bg-purple-600 text-white rounded-full px-12 py-4 hover:bg-purple-900 transition">Set Appointment</button>
        </a>
    </div>

    <footer class="bg-gray-800 text-gray-200 py-8 w-full">
        <div class="flex justify-between mx-4">
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
