<?php

session_start();
if (!isset($_SESSION['adminloginid'])) {
    header("location:index.php");
    exit;
}
?>
<?php
include('db/db-conn.php');

if (isset($_POST['registration_id']) && isset($_POST['status'])) {
    $registration_id = $_POST['registration_id'];
    $status = $_POST['status'];

    $update_sql = "UPDATE warranty_registrations SET status='$status' WHERE registration_id='$registration_id'";
    $update_result = mysqli_query($conn, $update_sql);

    if ($update_result) {
        echo "<script>alert('Warranty registration status updated successfully'); window.location.href='view-registered-warranty.php';</script>";
    } else {
        echo "<script>alert('Failed to update status'); window.location.href='view-registered-warranty.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request'); window.location.href='view-registered-warranty.php';</script>";
}
