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
		.vaccine-container {
		background-color: #fff;
		border-radius: 10px;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		max-width: 400px;
		overflow: hidden;
		text-align: center;
		margin: 20px;
		flex: 1 0 300px; /* Adjust width as needed */
		}

		.vaccine-container img {
			width: 100%;
			height: auto;
		}

		.vaccine-details {
			padding: 20px;
		}

		.vaccine-details h2 {
			margin: 0;
			color: #333;
		}

		.vaccine-details p {
			margin: 10px 0;
			color: #555;
		}

		.vaccine-details .price {
			font-size: 1.2em;
			color: #e74c3c;
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

	<main class="bg-gray-100 py-8 flex-grow w-full flex flex-wrap justify-center ">
        
        <div class="vaccine-container">
            <img src="images/vaccine-bcg.jpg" alt="BCG Vaccine Image">
            <div class="vaccine-details">
                <h2>BCG Vaccine</h2>
                <p><strong>Description:</strong> For newborn baby</p>
                <p><strong>Benefits:</strong> Basile Calmette-Guerin, A vaccine that protects against Tuberculosis.</p>
                <p class="price"><strong>Price:</strong> RM20 per dose</p>
            </div>
        </div>

		<div class="vaccine-container">
            <img src="images/v-dtap.jpeg" alt="DTap Vaccine Image">
            <div class="vaccine-details">
                <h2>DTap and DT Vaccine</h2>
                <p><strong>Description:</strong> For 2,3,5,18 month baby</p>
                <p><strong>Benefits:</strong> Vaccine combination that provides protection against Diphtheria, Tetanus and Pertussis.</p>
                <p class="price"><strong>Price:</strong> RM18 per dose</p>
            </div>
        </div>

		<div class="vaccine-container">
            <img src="images/v-hepatitis.jpg" alt="Hepatitis B Vaccine Image">
            <div class="vaccine-details">
                <h2>Hib Vaccine</h2>
                <an<strong>Description:</strong> For newborn, first month and 6 month baby</p>
                <p><strong>Benefits:</strong> For Haemophilus Influenzae type B.</p>
                <p class="price"><strong>Price:</strong> RM14 per dose</p>
            </div>
        </div>

		<div class="vaccine-container">
            <img src="images/v-hpv.jpg" alt="MMR Vaccine Image">
            <div class="vaccine-details">
                <h2>MMR Vaccine</h2>
                <p><strong>Description:</strong> For 9 and 12 month baby</p>
                <p><strong>Benefits:</strong> For Measles,Mumps dan Rubella.</p>
                <p class="price"><strong>Price:</strong> RM50 per dose</p>
            </div>
        </div>

		<div class="vaccine-container">
            <img src="images/v-mmr.jpg" alt="HPV Vaccine Image">
            <div class="vaccine-details">
                <h2>HPV Vaccine</h2>
                <p><strong>Description:</strong> This vaccine is only for teenage girls 13 years old. Dose 2 is given within 6 months after Dose 1.</p>
                <p><strong>Benefits:</strong> --</p>
                <p class="price"><strong>Price:</strong> RM23 per dose</p>
            </div>
        </div>

		<div class="vaccine-container">
            <img src="images/v-tetanus.webp" alt="Tetanus Vaccine Image">
            <div class="vaccine-details">
                <h2>Tetanus Vaccine</h2>
                <p><strong>Description:</strong> For 15 years old</p>
                <p><strong>Benefits:</strong> --</p>
                <p class="price"><strong>Price:</strong> RM21 per dose</p>
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