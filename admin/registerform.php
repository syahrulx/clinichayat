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
    <title>Register Doctor/Staff - Medical Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 for the popup -->
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto py-12">
        <div class="flex justify-center px-6 my-12">
            <div class="w-full xl:w-3/4 lg:w-11/12 flex">
                <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg" style="background-image: url('../image/pic2.png')"></div>
                <div class="w-full lg:w-1/2 bg-white p-8 rounded-lg lg:rounded-l-none shadow-lg">
                    <h3 class="pt-4 text-3xl text-center text-purple-700 font-bold">REGISTER DOCTOR & STAFF</h3>
                    <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded" method="post" action="insertdata.php">
                        <!-- Form fields -->
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold text-gray-700" for="user_role">
                                User Role
                            </label>
                            <select class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border border-gray-300 rounded shadow appearance-none focus:outline-none focus:shadow-outline focus:border-purple-500" name="user_role" id="user_role" required>
                                <option value="doctor">Doctor</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold text-gray-700" for="user_name">
                                Username
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border border-gray-300 rounded shadow appearance-none focus:outline-none focus:shadow-outline focus:border-purple-500" type="text" name="user_name" id="user_name" placeholder="Username" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold text-gray-700" for="password">
                                Password
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border border-gray-300 rounded shadow appearance-none focus:outline-none focus:shadow-outline focus:border-purple-500" type="password" name="password" id="password" placeholder="Password" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold text-gray-700" for="name">
                                Full Name
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border border-gray-300 rounded shadow appearance-none focus:outline-none focus:shadow-outline focus:border-purple-500" type="text" name="name" id="name" placeholder="Full Name" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold text-gray-700" for="dob">
                                Date of Birth
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border border-gray-300 rounded shadow appearance-none focus:outline-none focus:shadow-outline focus:border-purple-500" type="date" name="dob" id="dob" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold text-gray-700" for="address">
                                Address
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border border-gray-300 rounded shadow appearance-none focus:outline-none focus:shadow-outline focus:border-purple-500" type="text" name="address" id="address" placeholder="Address" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold text-gray-700" for="phone">
                                Phone Number
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border border-gray-300 rounded shadow appearance-none focus:outline-none focus:shadow-outline focus:border-purple-500" type="text" name="phone" id="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold text-gray-700" for="email">
                                Email
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border border-gray-300 rounded shadow appearance-none focus:outline-none focus:shadow-outline focus:border-purple-500" type="email" name="email" id="email" placeholder="Email" required>
                        </div>

                        <!-- Additional fields for doctor -->
                        <div class="mb-4" id="doctor-fields">
                            <label class="block mb-2 text-sm font-semibold text-gray-700" for="specialization">
                                Specialization
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border border-gray-300 rounded shadow appearance-none focus:outline-none focus:shadow-outline focus:border-purple-500" type="text" name="specialize" id="specialize" placeholder="Specialization">
                        </div>

                        <!-- Additional fields for staff -->
                        <div class="mb-4" id="staff-fields" style="display: none;">
                            <label class="block mb-2 text-sm font-semibold text-gray-700 mt-4" for="position">
                                Position
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border border-gray-300 rounded shadow appearance-none focus:outline-none focus:shadow-outline focus:border-purple-500" type="text" name="position" id="position" placeholder="Position">
                            <label class="block mb-2 text-sm font-semibold text-gray-700 mt-4" for="salary">
                                Salary
                            </label>
                            <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border border-gray-300 rounded shadow appearance-none focus:outline-none focus:shadow-outline focus:border-purple-500" type="number" name="salary" id="salary" placeholder="Salary">
                        </div>
                        <div class="mb-6 text-center">
                            <button class="w-full px-4 py-2 font-bold text-white bg-purple-600 rounded-full hover:bg-purple-700 focus:outline-none focus:shadow-outline" type="submit">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('user_role').addEventListener('change', function() {
            var staffFields = document.getElementById('staff-fields');
            var doctorFields = document.getElementById('doctor-fields');
            
            if (this.value === 'staff') {
                staffFields.style.display = 'block';
                doctorFields.style.display = 'none';
            } else {
                doctorFields.style.display = 'block';
                staffFields.style.display = 'none';
            }
        });
    </script>
</body>
</html>

