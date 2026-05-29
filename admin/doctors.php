<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:../login.php?pesan=belum_login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Doctors - Health App</title>
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
        .card-custom {
            border: none;
            border-radius: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.02);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: white;
        }
        .card-custom:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(166, 138, 120, 0.15);
        }
        .doctor-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            background-color: var(--light-bg);
            margin-bottom: 15px;
        }
        .btn-brown {
            background-color: var(--primary-brown);
            color: white;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 500;
            border: none;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
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
                    <a class="nav-link text-warning fw-bold" href="game.php">🎯 Daily Lucky Tip</a>
                    <a class="nav-link text-info fw-bold" href="game_mata.php">👁️ Eye Trainer</a>
                    <a class="nav-link text-danger fw-bold" href="game_jantung.php">❤️ Heart Rate Test</a>
                </div>
            </div>
            <div class="mb-4">
                <hr class="text-white-50">
                <a class="nav-link text-danger fw-bold" href="../logout.php">Logout</a>
            </div>
        </div>

        <div class="col-md-9 col-lg-10 main-content">
            <h2 class="fw-bold mb-1">Hello <?php echo htmlspecialchars($_SESSION['nama']); ?>,</h2>
            <p class="text-muted mb-4">Your Professional Doctors</p>

            <div class="mb-4">
                <a href="tambah_dokter.php" class="btn btn-brown">+ Tambah Dokter</a>
            </div>

            <div class="row g-4">
                <?php
                include '../config/koneksi.php';
                /** @var mysqli $conn */
                
                $ambil_dokter = mysqli_query($conn, "SELECT * FROM doctors");
                
                if ($ambil_dokter):
                    while ($row = mysqli_fetch_assoc($ambil_dokter)):
                ?>
                    <div class="col-md-4">
                        <div class="card card-custom p-4 text-center">
                            <div class="d-flex justify-content-center">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($row['nama_dokter']); ?>&background=A68A78&color=fff" class="doctor-img" alt="Doctor">
                            </div>
                            <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($row['nama_dokter']); ?></h5>
                            <p class="text-muted small mb-2"><?php echo htmlspecialchars($row['spesialis']); ?></p>
                            
                            <div class="d-flex align-items-center justify-content-center gap-1 mb-3">
                                <span style="color: #FFC107; font-size: 16px;">★</span>
                                <span class="fw-bold small" style="color: #4A4A4A;"><?php echo isset($row['rating']) ? htmlspecialchars($row['rating']) : '4.5'; ?></span>
                                <span class="text-muted" style="font-size: 11px;">(<?php echo isset($row['total_pasien']) ? htmlspecialchars($row['total_pasien']) : '100'; ?>+ pasien)</span>
                            </div>
                            
                            <hr class="my-2" style="border-color: #F8F1ED;">
                            <div class="d-flex justify-content-center gap-3">
                                <a href="edit_dokter.php?id=<?php echo $row['id']; ?>" class="text-warning small fw-bold text-decoration-none">Edit</a>
                                <span class="text-muted small">|</span>
                                <a href="hapus_dokter.php?id=<?php echo $row['id']; ?>" class="text-danger small fw-bold text-decoration-none" onclick="return confirm('Yakin mau menghapus dokter ini?')">Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php 
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>