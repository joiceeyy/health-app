<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:../login.php?pesan=belum_login");
    exit;
}

include '../config/koneksi.php';
/** @var mysqli $conn */

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil data checkup spesifik berdasarkan ID
    $query = mysqli_query($conn, "SELECT * FROM checkups WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query);
    
    // Jika data tidak ada di database, kembalikan ke index.php
    if (mysqli_num_rows($query) < 1) {
        header("location:index.php");
        exit;
    }
} else {
    header("location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Checkup - Health App</title>
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
        .detail-card {
            background: white;
            border-radius: 30px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        }
        .checkup-img {
            width: 100%;
            max-height: 280px; /* Membatasi tinggi gambar agar tidak terlalu besar */
            object-fit: contain; /* Gambar proporsional dan tidak terpotong */
            background-color: #fdfbfb; /* Background halus di belakang gambar */
            border-radius: 20px;
            margin-bottom: 25px;
        }
        .badge-duration {
            background-color: #EFE4DC;
            color: var(--primary-brown);
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 15px;
        }
        .btn-back {
            background-color: var(--primary-brown);
            color: white;
            border-radius: 12px;
            padding: 10px 25px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        .btn-back:hover {
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
                    <a class="nav-link active" href="index.php">Explore checkups</a>
                    <a class="nav-link" href="doctors.php">Your doctors</a>
                </div>
            </div>
            <div class="mb-4">
                <hr class="text-white-50">
                <a class="nav-link text-danger fw-bold" href="../logout.php">Logout</a>
            </div>
        </div>

        <div class="col-md-9 col-lg-10 main-content">
            <div class="mb-4">
                <a href="index.php" class="text-secondary text-decoration-none fw-medium">← Kembali ke Dashboard</a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="detail-card">
                        <?php if(!empty($data['gambar'])): ?>
                            <img src="<?php echo $data['gambar']; ?>" class="checkup-img" alt="<?php echo htmlspecialchars($data['nama_checkup']); ?>">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=600" class="checkup-img" alt="Default Image">
                        <?php endif; ?>

                        <div>
                            <span class="badge-duration">⏱️ <?php echo htmlspecialchars($data['durasi']); ?></span>
                        </div>
                        
                        <h2 class="fw-bold mb-3"><?php echo htmlspecialchars($data['nama_checkup']); ?></h2>
                        <p class="text-secondary" style="line-height: 1.8; font-size: 15px;">
                            <?php 
                            echo !empty($data['deskripsi']) ? htmlspecialchars($data['deskripsi']) : 'Informasi detail pemeriksaan medis belum diisi lengkap di database.'; 
                            ?>
                        </p>
                        
                        <div class="mt-4 pt-3 border-top">
                            <a href="index.php" class="btn btn-back">Selesai Membaca</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>