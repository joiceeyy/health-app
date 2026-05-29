<?php
include 'config/koneksi.php';

// Ambil input dari form
$nama = $_POST['nama'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password']; // Karena di DB admin123 (teks biasa), jangan pakai MD5

// PENTING: Urutan kolom di sini harus SAMA PERSIS dengan urutan di HeidiSQL
// Urutan HeidiSQL kamu: id, nama, username, email, password, role
$query = mysqli_query($conn, "INSERT INTO users (nama, username, email, password, role) VALUES ('$nama', '$username', '$email', '$password', 'user')");

if($query) {
    echo "<script>alert('Berhasil daftar!'); window.location='login.php';</script>";
} else {
    echo "Gagal daftar: " . mysqli_error($conn);
}
?>