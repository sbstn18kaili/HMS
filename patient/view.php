<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Invoice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Include Bootstrap -->
</head>
<body>
    <?php
        include("../include/header.php");
        include("../include/connection.php");
    ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php include("sidenav.php"); ?>
                </div>
                <div class="col-md-10">
                    <h5 class="text-center my-2">View Invoice</h5>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <?php
                                    if(isset($_GET['id'])) {
                                        // Sanitize input to prevent SQL injection
                                        $id = mysqli_real_escape_string($connect, $_GET['id']);

                                        // Fetch the income details based on the invoice ID
                                        $query = "SELECT * FROM income WHERE id='$id'";
                                        $res = mysqli_query($connect, $query);

                                        // Error handling if query fails
                                        if (!$res) {
                                            die("Error fetching data: " . mysqli_error($connect));
                                        }

                                        // Check if any row is returned
                                        if (mysqli_num_rows($res) == 1) {
                                            $row = mysqli_fetch_array($res);
                                        } else {
                                            echo "<p class='text-center alert alert-warning'>No invoice found for this ID.</p>";
                                            exit();
                                        }
                                    } else {
                                        echo "<p class='text-center alert alert-warning'>No invoice ID provided.</p>";
                                        exit();
                                    }
                                ?>

                                <table class="table table-bordered">
                                    <tr>
                                        <th colspan="2" class="text-center">Invoice Details</th>
                                    </tr>
                                    <tr>
                                        <td>Doctor</td>
                                        <td><?php echo htmlspecialchars($row['doctor']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Patient</td>
                                        <td><?php echo htmlspecialchars($row['patient']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Date Discharge</td>
                                        <td><?php echo htmlspecialchars($row['date_discharge']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Amount Paid</td>
                                        <td><?php echo htmlspecialchars($row['amount_paid']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
