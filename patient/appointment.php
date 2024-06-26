<?php
session_start();

include("../connection.php");
include("../functions.php");

$user_data = check_login($con);
if ($_SESSION['user_role'] !== 'patient') {
    header("Location: ../login/login.php");
    exit();
}

$patient_id = $_SESSION['user_id'];

// Fetch all booked appointments
$appointments_query = "SELECT date, time, doctor FROM appointment";
$appointments_result = mysqli_query($con, $appointments_query);

$booked_appointments = [];
while ($row = mysqli_fetch_assoc($appointments_result)) {
    $date = $row['date'];
    $time = $row['time'];
    $doctor = $row['doctor'];

    if (!isset($booked_appointments[$date])) {
        $booked_appointments[$date] = [];
    }
    if (!isset($booked_appointments[$date][$doctor])) {
        $booked_appointments[$date][$doctor] = [];
    }
    $booked_appointments[$date][$doctor][] = $time;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hayat Clinic Appointment Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .date-button:hover {
            background-color: #4299e1;
            color: white;
        }
        .date-button.booked {
            background-color: red;
            color: white;
        }
        .time-option.booked {
            background-color: red;
            color: white;
            pointer-events: none;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const appointmentTypeNodes = document.querySelectorAll('input[name="appointmentType"]');
            const doctorSelect = document.getElementById('doctor-select');
            const timeSelect = document.getElementById('time-select');
            const confirmationDetails = document.querySelectorAll('.confirmation-detail');
            const monthSelect = document.getElementById('month-select');
            const dateButtonsContainer = document.getElementById('date-buttons-container');
            const selectedDateInput = document.getElementById('selected-date');
            const selectedTimeInput = document.getElementById('selected-time');

            const bookedAppointments = <?php echo json_encode($booked_appointments); ?>;
            console.log('Booked Appointments:', bookedAppointments);

            function updateConfirmation() {
                confirmationDetails.forEach(detail => {
                    const category = detail.dataset.category;
                    let value = '';
                    if (category === 'appointmentType') {
                        value = document.querySelector('input[name="appointmentType"]:checked')?.nextElementSibling.textContent;
                    } else if (category === 'date') {
                        value = detail.dataset.value;
                    } else if (category === 'time') {
                        value = timeSelect.value;
                    } else if (category === 'doctor') {
                        value = doctorSelect.options[doctorSelect.selectedIndex].text;
                    }
                    detail.textContent = value;
                });
            }

            function getDayName(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', { weekday: 'long' });
            }

            function updateDateButtons() {
                const selectedMonth = monthSelect.value;
                const year = new Date().getFullYear();
                const monthIndex = new Date(Date.parse(selectedMonth + " 1, " + year)).getMonth();
                const daysInMonth = new Date(year, monthIndex + 1, 0).getDate();

                dateButtonsContainer.innerHTML = '';
                for (let day = 1; day <= daysInMonth; day++) {
                    const dateStr = `${year}-${String(monthIndex + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const dayName = getDayName(dateStr);
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.classList.add('date-button', 'py-2', 'text-sm', 'text-gray-700', 'bg-white', 'border', 'border-gray-200', 'rounded', 'hover:bg-purple-100', 'w-full');
                    button.textContent = `${dayName}, ${day}`;

                    if (bookedAppointments[dateStr]) {
                        button.classList.add('booked');
                        button.disabled = true; // Disable the button for booked dates
                    }

                    button.addEventListener('click', function () {
                        document.querySelectorAll('.date-button').forEach(btn => btn.classList.remove('bg-purple-700', 'text-white'));
                        button.classList.add('bg-purple-700', 'text-white');
                        document.querySelector('.confirmation-detail[data-category="date"]').dataset.value = `${dayName}, ${day} ${selectedMonth}`;
                        selectedDateInput.value = dateStr; // Use the correct format for the date
                        updateConfirmation();

                        // Update time options based on selected date and doctor
                        updateTimeOptions(dateStr, doctorSelect.value);
                    });

                    const wrapper = document.createElement('div');
                    wrapper.classList.add('w-1/5', 'mb-1', 'p-1');
                    wrapper.appendChild(button);
                    dateButtonsContainer.appendChild(wrapper);
                }
            }

            function updateTimeOptions(dateStr, doctor) {
                const times = ["10:00 AM", "11:00 AM", "12:00 PM", "2:00 PM", "4:00 PM", "6:00 PM", "8:00 PM"];
                timeSelect.innerHTML = '';

                times.forEach(time => {
                    const option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;

                    if (bookedAppointments[dateStr] && bookedAppointments[dateStr][doctor] && bookedAppointments[dateStr][doctor].includes(time)) {
                        option.classList.add('booked');
                        option.disabled = true;
                    }

                    timeSelect.appendChild(option);
                });
            }

            appointmentTypeNodes.forEach(node => node.addEventListener('change', updateConfirmation));
            doctorSelect.addEventListener('change', function () {
                updateConfirmation();
                updateTimeOptions(selectedDateInput.value, doctorSelect.value);
            });
            timeSelect.addEventListener('change', updateConfirmation);
            monthSelect.addEventListener('change', updateDateButtons);

            updateDateButtons();
        });
    </script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">
    <header class="bg-white px-6 py-4 shadow-md">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-purple-600 uppercase">HAYAT CLINIC</h1>
            <nav>
                <ul class="flex space-x-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li><a href="logout.php" class="text-white bg-purple-600 hover:bg-purple-900 px-4 py-2 rounded-md"><button class="bg-transparent hover:bg-purple-600 text-white font-semibold hover:text-white py-2 px-4 border border-purple-600 hover:border-transparent rounded">Log out</button></a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="text-white bg-purple-600 hover:bg-purple-900 px-4 py-2 rounded-md"><button class="bg-transparent hover:bg-purple-600 text-white font-semibold hover:text-white py-2 px-4 border border-purple-600 hover:border-transparent rounded">Login</button></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container mx-auto p-5">
        <h1 class="text-3xl font-bold text-center mb-6 uppercase">Hayat Clinic</h1>
        <form action="book-appointment.php" method="POST">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h2 class="text-xl mb-4">Appointment Type</h2>
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="appointmentType" value="General Check-up" required>
                        <span class="ml-2">General Check-up</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" class="form-radio" name="appointmentType" value="Specialist Consultation" required>
                        <span class="ml-2">Specialist Consultation</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" class="form-radio" name="appointmentType" value="Screening" required>
                        <span class="ml-2">Screening</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" class="form-radio" name="appointmentType" value="Vaccine" required>
                        <span class="ml-2">Vaccine</span>
                    </label>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl mb-3">Date and Time Selection</h2>
                    <div class="mb-3">
                        <label for="month-select" class="block text-gray-700 text-sm font-bold mb-2">Select Month:</label>
                        <select id="month-select" class="block appearance-none w-full bg-gray-200 border text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white" required>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    <div class="flex flex-wrap date-container bg-gray-100 p-3 rounded-md" id="date-buttons-container">
                        <!-- Date buttons will be dynamically generated here -->
                    </div>
                    <select class="block appearance-none w-full bg-gray-200 border text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white mt-3" id="time-select" name="time" required>
                        <!-- Time options will be dynamically generated here -->
                    </select>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl mb-3">Doctor Selection</h2>
                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="doctor-select" name="doctor" required>
                        <option value="">Select Doctor</option>
                        <option value="Dr. Syahrul">Dr. Syahrul</option>
                        <!-- Add other doctor options -->
                    </select>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl mb-3">Confirmation</h2>
                    <p>Appointment Type: <span class="font-semibold confirmation-detail" data-category="appointmentType"></span></p>
                    <p>Date: <span class="font-semibold confirmation-detail" data-category="date"></span></p>
                    <p>Time: <span class="font-semibold confirmation-detail" data-category="time"></span></p>
                    <p>Doctor: <span class="font-semibold confirmation-detail" data-category="doctor"></span></p>
                    <textarea class="form-textarea mt-1 block w-full" rows="3" placeholder="Additional Notes" name="notes"></textarea>
                </div>

                <input type="hidden" name="date" id="selected-date" required>
                <input type="hidden" name="time" id="selected-time" required>
                <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($user_data['PatientID']); ?>">
                <button type="submit" class="bg-purple-600 text-white rounded-full px-12 py-4 hover:bg-purple-900 transition">Set Appointment</button>
            </div>
        </form>
        <footer class="text-center text-sm text-gray-500 mt-10">
            <p>Home &nbsp; <i class="fas fa-home"></i> &nbsp; <i class="fab fa-facebook"></i> &nbsp; <i class="fab fa-twitter"></i> &nbsp; <i class="fas fa-envelope"></i> &nbsp; Contact Us</p>
        </footer>
    </div>
</body>
</html>
