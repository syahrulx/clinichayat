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
    <title>Consultations</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .consultation-card {
            display: flex;
            flex-direction: row;
            transition: transform 0.3s;
            width: 100%;
        }

        .consultation-card:hover {
            transform: scale(1.05);
        }

        .consultation-card img {
            width: 40%;
            height: auto;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1.2rem;
        }

        .card-body {
            padding: 20px;
            width: 60%;
        }
    </style>
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
            <h2 class="text-4xl font-semibold mb-10 text-center">Consultations</h2>
            <div class="flex flex-col space-y-8">
                <div class="consultation-card bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="images/generalconsult.avif" alt="General Consultation">
                    <div class="card-body">
                        <h5 class="card-title">General Consultation</h5>
                        <p class="card-text">A comprehensive consultation to address your health concerns. It includes a physical examination and health advice.</p>
                        <p class="card-text"><strong>Benefits:</strong> Personalized health advice and treatment recommendations.</p>
                        <p class="card-text"><strong>Price:</strong> RM 150</p>
                    </div>
                </div>

                <div class="consultation-card bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="images/Nutritional-Consult.jpg" alt="Nutrition Consultation">
                    <div class="card-body">
                        <h5 class="card-title">Nutrition Consultation</h5>
                        <p class="card-text">Focused on your dietary needs, this consultation includes a nutrition assessment and personalized dietary plans.</p>
                        <p class="card-text"><strong>Benefits:</strong> Improved dietary habits and better health outcomes.</p>
                        <p class="card-text"><strong>Price:</strong> RM 200</p>
                    </div>
                </div>

                <div class="consultation-card bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="images/mentalhealth.jpg" alt="Mental Health Consultation">
                    <div class="card-body">
                        <h5 class="card-title">Mental Health Consultation</h5>
                        <p class="card-text">This consultation focuses on your mental well-being and includes an assessment and counseling.</p>
                        <p class="card-text"><strong>Benefits:</strong> Better mental health and coping strategies.</p>
                        <p class="card-text"><strong>Price:</strong> RM 180</p>
                    </div>
                </div>

                <div class="consultation-card bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="images/specialconsult.jpg" alt="Specialist Consultation">
                    <div class="card-body">
                        <h5 class="card-title">Specialist Consultation</h5>
                        <p class="card-text">A detailed consultation with a specialist in various medical fields for specific health concerns.</p>
                        <p class="card-text"><strong>Benefits:</strong> Expert advice and specialized treatment plans.</p>
                        <p class="card-text"><strong>Price:</strong> RM 250</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="text-center mb-20 mt-10">
            <a href="#">
                <button class="bg-purple-600 text-white rounded-full px-12 py-4 hover:bg-purple-900 transition">Set Appointment</button>
            </a>
        </div>
    </main>

    <footer class="bg-gray-800 text-gray-200 py-8">
        <div class="container mx-auto flex flex-wrap justify-between">
            <div class="w-full md:w-1/4 mb-4 md:mb-0">
                <h3 class="font-bold text-lg mb-2">Connect with Us</h3>
                <div class="flex">
                    <input type="email" placeholder="Enter your email address" class="border-2 border-gray-300 rounded-md p-2 w-2/3">
                    <button class="bg-purple-600 text-white rounded-md px-4 py-2 ml-2 hover:bg-purple-900">Submit</button>
                </div>
            </div>
            <div class="w-full md:w-1/4 mb-4 md:mb-0">
                <h3 class="font-bold text-lg mb-2">Company</h3>
                <ul>
                    <li class="mb-1"><a href="#" class="hover:text-white">About Services</a></li>
                    <li class="mb-1"><a href="#" class="hover:text-white">Contact</a></li>
                    <li class="mb-1"><a href="#" class="hover:text-white">Careers</a></li>
                    <li><a href="#" class="hover:text-white">Updates Help</a></li>
                </ul>
            </div>
            <div class="w-full md:w-1/4 mb-4 md:mb-0">
                <h3 class="font-bold text-lg mb-2">Connect with</h3>
                <ul>
                    <li class="mb-1"><a href="#" class="hover:text-white">Facebook</a></li>
                    <li class="mb-1"><a href="#" class="hover:text-white">Twitter</a></li>
                    <li class="mb-1"><a href="#" class="hover:text-white">LinkedIn</a></li>
                    <li><a href="#" class="hover:text-white">Instagram</a></li>
                </ul>
            </div>
            <div class="w-full md:w-1/4 mb-4 md:mb-0">
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
