<?php

session_start();
if (!isset($_SESSION['adminloginid'])) {
    header("location:index.php");
    exit;
}
?>
<?php
include('db/db-conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_applier_id = mysqli_real_escape_string($conn, $_POST['job_applier_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update query
    $sql = "UPDATE job_appliers SET status = '$status' WHERE job_applier_id = '$job_applier_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Status updated successfully!'); window.location.href='view-job-applier.php';</script>";
    } else {
        echo "<script>alert('Error updating status: " . mysqli_error($conn) . "'); window.location.href='view-job-applier.php';</script>";
    }
}
