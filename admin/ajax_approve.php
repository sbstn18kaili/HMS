<?php
include("../include/connection.php");

$id = intval($_POST['id']); // Ensure that the ID is an integer

$query = $connect->prepare("UPDATE doctors SET status = ? WHERE id = ?");
$status = 'Approved';
$query->bind_param("si", $status, $id);

if ($query->execute()) {
    echo "Doctor's status updated successfully";
} else {
    echo "Error updating status: " . $query->error;
}

$query->close();
$connect->close();
?>
