<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['login'])) {
  // Di dalam file login.php, cari bagian query ini dan ubah:
$email = $_POST['email'];
$password = $_POST['password'];

// Kita cari berdasarkan EMAIL karena itu kolom unik yang benar
$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['status'] = "login";
        $_SESSION['nama'] = $data['nama'];
        
        // Arahkan ke folder admin/index.php sesuai struktur foldermu
        header("location:admin/index.php"); 
        exit;
    } else {
        echo "<script>alert('Email atau Password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Health App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #F8F1ED; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); width: 100%; max-width: 400px; }
        .btn-login { background-color: #A68A78; color: white; border-radius: 10px; width: 100%; }
    </style>
</head>
<body>
<div class="login-card">
    <h3 class="text-center fw-bold mb-4" style="color: #A68A78;">Login</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="admin@gmail.com" required>
        </div>
        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
        </div>
        <button type="submit" name="login" class="btn btn-login p-2">Sign In</button>
    </form>
</div>
</body>
</html>