<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:../login.php?pesan=belum_login");
    exit;
}

// Kembali panggil koneksi asli kamu yang sudah pasti benar nama databasenya
include '../config/koneksi.php';
/** @var mysqli $conn */

// 1. Ambil data dokter yang mau diedit untuk ditaruh di dalam form input
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $ambildata = mysqli_query($conn, "SELECT * FROM doctors WHERE id = '$id'");
    $data = mysqli_fetch_assoc($ambildata);

    if (mysqli_num_rows($ambildata) < 1) {
        header("location:doctors.php");
        exit;
    }
} else {
    header("location:doctors.php");
    exit;
}

// 2. Proses update data saat tombol "Simpan Perubahan" diklik
if (isset($_POST['update'])) {
    $nama_dokter = $_POST['nama_dokter'];
    $spesialis   = $_POST['spesialis'];

    $query = mysqli_query($conn, "UPDATE doctors SET nama_dokter='$nama_dokter', spesialis='$spesialis' WHERE id='$id'");

    if ($query) {
        header("location:doctors.php");
        exit;
    } else {
        echo "<script>alert('Gagal mengubah data dokter!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dokter - Health App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #F8F1ED;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-card {
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            width: 100%;
            max-width: 450px;
        }
        .btn-brown {
            background-color: #A68A78;
            color: white;
            border-radius: 12px;
            padding: 10px 25px;
            font-weight: 500;
            border: none;
        }
        .btn-brown:hover {
            background-color: #8C7262;
            color: white;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #e2e8f0;
        }
        .form-control:focus {
            border-color: #A68A78;
            box-shadow: 0 0 0 3px rgba(166, 138, 120, 0.2);
        }
    </style>
</head>
<body>

<div class="form-card">
    <h4 class="fw-bold mb-4" style="color: #A68A78;">Edit Data Dokter</h4>
    
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label fw-medium text-secondary">Nama Lengkap Dokter</label>
            <input type="text" name="nama_dokter" class="form-control" value="<?php echo htmlspecialchars($data['nama_dokter']); ?>" required>
        </div>
        <div class="mb-4">
            <label class="form-label fw-medium text-secondary">Spesialisasi</label>
            <input type="text" name="spesialis" class="form-control" value="<?php echo htmlspecialchars($data['spesialis']); ?>" required>
        </div>
        
        <div class="d-flex gap-2">
            <button type="submit" name="update" class="btn btn-brown px-4">Simpan Perubahan</button>
            <a href="doctors.php" class="btn btn-light text-secondary px-4" style="border-radius: 12px; padding: 10px 25px;">Batal</a>
        </div>
    </form>
</div>

</body>
</html>