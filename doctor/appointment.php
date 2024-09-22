<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Total Appointment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Make sure Bootstrap is included for styling -->
</head>
<body>

<?php
    include("../include/header.php");
    include("../include/connection.php");
?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left:-30px;">
                <?php include("sidenav.php"); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center my-2">Total Appointments</h5>

                <?php
                    // Fetch pending appointments
                    $query = "SELECT * FROM appointment WHERE status = 'Pending'";
                    $res = mysqli_query($connect, $query);

                    if(!$res) {
                        die('Error executing query: ' . mysqli_error($connect));  // Basic error handling for debugging
                    }

                    // Initialize the output
                    $output = "
                        <table class='table table-bordered'>
                        <tr>
                            <th>ID</th>
                            <th>Firstname</th>
                            <th>Surname</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Appointment Date</th>
                            <th>Symptoms</th>
                            <th>Date Booked</th>
                            <th>Action</th>
                        </tr>";

                    // Check if there are appointments
                    if(mysqli_num_rows($res) < 1) {
                        $output .= "
                            <tr>
                                <td class='text-center' colspan='9'>No Appointment Yet.</td>
                            </tr>";
                    } else {
                        // Loop through each appointment and add it to the table
                        while($row = mysqli_fetch_array($res)) {
                            $output .= "
                                <tr>
                                    <td>".$row['id']."</td>
                                    <td>".$row['firstname']."</td>
                                    <td>".$row['surname']."</td>
                                    <td>".$row['gender']."</td>
                                    <td>".$row['phone']."</td>
                                    <td>".$row['appointment_date']."</td>
                                    <td>".$row['symptoms']."</td>
                                    <td>".$row['date_booked']."</td>
                                    <td>
                                        <a href='discharge.php?id=".$row['id']."'>
                                            <button class='btn btn-info'>Check</button>
                                        </a>
                                    </td>
                                </tr>";
                        }
                    }

                    // Close the table
                    $output .= "</table>";

                    // Echo the generated table
                    echo $output;
                ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>
