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
    <title>Check-Ups</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        .checkup-card {
    display: flex;
    transition: transform 0.3s;
}

.checkup-card:hover {
    transform: scale(1.05);
}

.checkup-card img {
    flex-shrink: 0; /* Prevent image from shrinking */
    width: 40%;
    height: auto;
    aspect-ratio: 3/2; /* Maintain 3x2 aspect ratio */
}

.card-title {
    font-size: 1.5rem;
    font-weight: bold;
}

.card-text {
    font-size: 1.2rem;
}
.card-img-left {
    padding-right: 20px; /* Add space to the right of the image */
}

    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header class="bg-white px-6 py-4 shadow-md">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-purple-600">HAYAT CLINIC</h1>
            <nav>
                <ul class="flex space-x-4"></ul>
            </nav>
        </div>
    </header>

    <main class="bg-gray-100 py-8">
        <section class="container mx-auto">
            <h2 class="text-4xl font-semibold mb-10 text-center">Check-Ups</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card checkup-card flex-row">
                        <img src="images/general_checkup.jpg" class="card-img-left" alt="General Health Check-Up">
                        <div class="card-body">
                            <h5 class="card-title">General Health Check-Up</h5>
                            <p class="card-text">A comprehensive check-up to assess your overall health status. It includes blood tests, physical examination, and vital sign monitoring.</p>
                            <p class="card-text"><strong>Benefits:</strong> Early detection of health issues, baseline health data, and personalized health advice.</p>
                            <p class="card-text"><strong>Price:</strong> RM 150</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card checkup-card flex-row">
                        <img src="images/cardiovascular_checkup.jpg" class="card-img-left" alt="Cardiovascular Check-Up">
                        <div class="card-body">
                            <h5 class="card-title">Cardiovascular Check-Up</h5>
                            <p class="card-text">Focused on heart health, this check-up includes an ECG, blood pressure monitoring, cholesterol tests, and stress tests.</p>
                            <p class="card-text"><strong>Benefits:</strong> Identifies risk factors for heart disease, helps manage existing conditions, and provides heart health advice.</p>
                            <p class="card-text"><strong>Price:</strong> RM 200</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card checkup-card flex-row">
                        <img src="images/diabetes_checkup.jpg" class="card-img-left" alt="Diabetes Check-Up">
                        <div class="card-body">
                            <h5 class="card-title">Diabetes Check-Up</h5>
                            <p class="card-text">This check-up includes blood sugar testing, HbA1c test, and nutritional counseling to help manage or prevent diabetes.</p>
                            <p class="card-text"><strong>Benefits:</strong> Early detection of diabetes, monitoring of blood sugar levels, and dietary advice.</p>
                            <p class="card-text"><strong>Price:</strong> RM 180</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card checkup-card flex-row">
                        <img src="images/cancer_screening.jpg" class="card-img-left" alt="Cancer Screening">
                        <div class="card-body">
                            <h5 class="card-title">Cancer Screening</h5>
                            <p class="card-text">A series of tests aimed at detecting early signs of cancer, including mammograms, colonoscopies, and skin checks.</p>
                            <p class="card-text"><strong>Benefits:</strong> Early cancer detection, increased treatment options, and better prognosis.</p>
                            <p class="card-text"><strong>Price:</strong> RM 250</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card checkup-card flex-row">
                        <img src="images/womens_health_checkup.jpg" class="card-img-left" alt="Women's Health Check-Up">
                        <div class="card-body">
                            <h5 class="card-title">Women's Health Check-Up</h5>
                            <p class="card-text">Includes a pelvic exam, Pap smear, breast exam, and hormone level tests to ensure women's health and well-being.</p>
                            <p class="card-text"><strong>Benefits:</strong> Early detection of reproductive health issues, hormone balance monitoring, and overall health assessment.</p>
                            <p class="card-text"><strong>Price:</strong> RM 220</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card checkup-card flex-row">
                        <img src="images/mens_health_checkup.jpg" class="card-img-left" alt="Men's Health Check-Up">
                        <div class="card-body">
                            <h5 class="card-title">Men's Health Check-Up</h5>
                            <p class="card-text">Includes prostate exam, testosterone level test, and screenings for common male health issues.</p>
                            <p class="card-text"><strong>Benefits:</strong> Early detection of prostate issues, hormone balance monitoring, and overall health assessment.</p>
                            <p class="card-text"><strong>Price:</strong> RM 200</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="text-center mb-20">
            <a href="#">
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
