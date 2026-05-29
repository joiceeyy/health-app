<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:../login.php?pesan=belum_login");
    exit;
}

include '../config/koneksi.php';
/** @var mysqli $conn */

// Proses ketika tombol simpan diklik
if (isset($_POST['simpan'])) {
    $nama_dokter = mysqli_real_escape_string($conn, $_POST['nama_dokter']);
    $spesialis   = mysqli_real_escape_string($conn, $_POST['spesialis']);
    $rating      = mysqli_real_escape_string($conn, $_POST['rating']);
    $total_pasien = mysqli_real_escape_string($conn, $_POST['total_pasien']);

    // Query insert data ke tabel doctors beserta kolom barunya
    $query = mysqli_query($conn, "INSERT INTO doctors (nama_dokter, spesialis, rating, total_pasien) VALUES ('$nama_dokter', '$spesialis', '$rating', '$total_pasien')");

    if ($query) {
        header("location:doctors.php?pesan=tambah_sukses");
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan data dokter.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dokter - Health App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-brown: #A68A78;
            --light-bg: #F8F1ED;
        }
        body {
            background-color: var(--light-bg);
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        .sidebar {
            background-color: var(--primary-brown);
            min-height: 100vh;
            color: white;
            padding-top: 30px;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 5px;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .main-content {
            padding: 40px;
        }
        .form-card {
            background: white;
            border-radius: 25px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.02);
        }
        .form-control {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #EFE4DC;
        }
        .form-control:focus {
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 0.25rem rgba(166, 138, 120, 0.25);
        }
        .btn-brown {
            background-color: var(--primary-brown);
            color: white;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 500;
            border: none;
            transition: background 0.3s;
        }
        .btn-brown:hover {
            background-color: #8C7262;
            color: white;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar d-flex flex-column justify-content-between p-3">
            <div>
                <h3 class="fw-bold text-center mb-5">Health App</h3>
                <div class="nav flex-column nav-pills">
                    <a class="nav-link" href="index.php">Explore checkups</a>
                    <a class="nav-link active" href="doctors.php">Your doctors</a>
                </div>
            </div>
            <div class="mb-4">
                <hr class="text-white-50">
                <a class="nav-link text-danger fw-bold" href="../logout.php">Logout</a>
            </div>
        </div>

        <div class="col-md-9 col-lg-10 main-content">
            <div class="mb-4">
                <a href="doctors.php" class="text-secondary text-decoration-none fw-medium">← Kembali ke Daftar Dokter</a>
            </div>

            <h2 class="fw-bold mb-4">Tambah Dokter Baru</h2>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-card">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Nama Dokter</label>
                                <input type="text" name="nama_dokter" class="form-control" placeholder="Contoh: Dr. Alexander" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Spesialis</label>
                                <input type="text" name="spesialis" class="form-control" placeholder="Contoh: Cardiologist" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary">Rating Awal</label>
                                    <input type="number" step="0.1" min="1" max="5" name="rating" class="form-control" placeholder="Contoh: 4.8" value="4.5" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary">Total Pasien</label>
                                    <input type="number" name="total_pasien" class="form-control" placeholder="Contoh: 120" value="100" required>
                                </div>
                            </div>

                            <div class="mt-4 pt-2">
                                <button type="submit" name="simpan" class="btn btn-brown w-100">Simpan Data Dokter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>