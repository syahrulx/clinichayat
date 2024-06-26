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

// Fetch appointments with status 'done', payment statuses, and prescription fees
$sql = "SELECT a.Ap_ID, a.appointmentType, a.date, a.time, a.doctor, a.price,
              COALESCE(prescription.total_fee, 0) AS prescription_fee,
              COALESCE(payments.status, 'unpaid') AS payment_status,
              COALESCE(payments.amount, a.price + COALESCE(prescription.total_fee, 0)) AS total_amount
       FROM appointment a
       LEFT JOIN (
           SELECT appointment_id, SUM(Pr_Price) AS total_fee
           FROM prescription
           GROUP BY appointment_id
       ) prescription ON a.Ap_ID = prescription.appointment_id
       LEFT JOIN payments ON a.Ap_ID = payments.appointment_id
       WHERE a.status = 'done'
       ORDER BY payments.status = 'paid', a.date ASC, a.time ASC";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Page - Payment Status</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body >
<header class="bg-white py-4 px-6  shadow-md">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-purple-600">HAYAT CLINIC</h1>
            <nav>
                <ul class="flex space-x-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <li class=" mt-2" ><span class="uppercase font-semibold text-purple-700">Hi patient <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?></span></li>
                        <li><a href="../logout.php" class="text-white bg-purple-600 hover:bg-purple-900 px-4 py-2 rounded-md"><button class="bg-transparent hover:bg-purple-600 text-white font-semibold hover:text-white py-2 px-4 border border-purple-600 hover:border-transparent rounded">Log out</button></a></li>
                    <?php else: ?>
                        <li><a href="../login.php" class="text-white bg-purple-600 hover:bg-purple-900 px-4 py-2 rounded-md"><button class="bg-transparent hover:bg-purple-600 text-white font-semibold hover:text-white py-2 px-4 border border-purple-600 hover:border-transparent rounded">Login</button></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <div class="bg-gray-100  min-h-screen flex flex-col justify-center  ">
        <div class="container mx-auto px-8 py-6 bg-white shadow-md rounded-lg ">
            <h1 class="text-3xl font-semibold text-purple-700 text-center mb-6 uppercase">Payment Status</h1>
            <table class="w-full border-collapse">
                <thead class=" border-purple-700">
                    <tr class="border-2 border-purple-600 text-black">
                        <th class="p-3 border">Appointment ID</th>
                        <th class="p-3 border">Appointment Type</th>
                        <th class="p-3 border">Date</th>
                        <th class="p-3 border">Time</th>
                        <th class="p-3 border">Doctor</th>
                        <th class="p-3 border">Appointment Price</th>
                        <th class="p-3 border">Prescription Fee</th>
                        <th class="p-3 border">Payment Status</th>
                        <th class="p-3 border">Total Amount</th>
                        <th class="p-3 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $paidClass = $row['payment_status'] === 'paid' ? 'bg-gray-100 text-gray-500' : '';
                            $disabled = $row['payment_status'] === 'paid' ? 'disabled' : '';
                            echo "<tr class='{$paidClass}'>
                                    <td class='p-3 border'>{$row['Ap_ID']}</td>
                                    <td class='p-3 border'>{$row['appointmentType']}</td>
                                    <td class='p-3 border'>{$row['date']}</td>
                                    <td class='p-3 border'>{$row['time']}</td>
                                    <td class='p-3 border'>{$row['doctor']}</td>
                                    <td class='p-3 border'>\${$row['price']}</td>
                                    <td class='p-3 border'>\${$row['prescription_fee']}</td>
                                    <td class='p-3 border'>{$row['payment_status']}</td>
                                    <td class='p-3 border'>\${$row['total_amount']}</td>
                                    <td class='p-3 border'>
                                        <form method='POST' action='payment-status.php'>
                                            <input type='hidden' name='appointment_id' value='{$row['Ap_ID']}'>
                                            <select name='status' class='form-select p-2 rounded border' {$disabled}>
                                                <option value='paid' " . ($row['payment_status'] === 'paid' ? 'selected' : '') . ">Paid</option>
                                                <option value='unpaid' " . ($row['payment_status'] === 'unpaid' ? 'selected' : '') . ">Unpaid</option>
                                            </select>
                                            <button type='submit' class='btn-update bg-purple-700 text-white px-4 py-2 rounded mt-2 hover:bg-purple-800' {$disabled}>Update</button>
                                        </form>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='p-3 text-center border'>No appointments found</td></tr>";
                    }
                    $con->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
