<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:../login.php?pesan=belum_login");
    exit;
}

// Kembalikan ke include koneksi asli kamu
include '../config/koneksi.php';
/** @var mysqli $conn */

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = mysqli_query($conn, "DELETE FROM doctors WHERE id = '$id'");

    if ($query) {
        header("location:doctors.php");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='doctors.php';</script>";
    }
} else {
    header("location:doctors.php");
    exit;
}
?>