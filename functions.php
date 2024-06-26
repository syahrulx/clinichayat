<?php
function check_login($con) {
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
        $id = $_SESSION['user_id'];
        $role = $_SESSION['user_role'];
        
        // Determine the correct table and ID field based on user role
        switch ($role) {
            case 'admin':
                $query = "SELECT * FROM admin WHERE AdminID = '$id' LIMIT 1";
                break;
            case 'patient':
                $query = "SELECT * FROM patient WHERE PatientID = '$id' LIMIT 1";
                break;
            case 'staff':
                $query = "SELECT * FROM staff WHERE StaffID = '$id' LIMIT 1";
                break;
            case 'doctor':
                $query = "SELECT * FROM doctor WHERE DoctorID = '$id' LIMIT 1";
                break;
            default:
                // Redirect to login if role is invalid
                header("Location: ../login/login.php");
                die;
        }

        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    // Redirect to login if session is invalid
    header("Location: ../login/login.php");
    die;
}

// Other functions unchanged...


function generateEditButton($id, $type) {
    return "<a href=\"edit_$type.php?id=$id\" class=\"btn btn-warning\">Edit</a>";
}

function generateDeleteButton($id, $type) {
    return "<a href=\"delete_$type.php?id=$id\" class=\"btn btn-danger\">Delete</a>";
}

function generateViewButton($id, $type) {
    return "<a href=\"view_$type.php?id=$id\" class=\"btn btn-info\">View</a>";
}

function generateActionButtons($id, $type) {
    $editButton = generateEditButton($id, $type);
    $deleteButton = generateDeleteButton($id, $type);
    $viewButton = generateViewButton($id, $type);
    
    return "$viewButton $editButton $deleteButton";
}


   
?>
