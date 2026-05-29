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
    <title>Dashboard - Health App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
            cursor: pointer;
        }
        .card-custom:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(166, 138, 120, 0.15);
        }
        .icon-box {
            width: 50px;
            height: 50px;
            background-color: var(--light-bg);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            color: var(--primary-brown);
            font-size: 24px;
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
            <p class="text-muted mb-4">Explore checkups</p>

            <div class="row g-4">
                <?php
                include '../config/koneksi.php';
                /** @var mysqli $conn */
                
                $ambil_checkup = mysqli_query($conn, "SELECT * FROM checkups");
                if ($ambil_checkup):
                    while ($row = mysqli_fetch_assoc($ambil_checkup)):
                ?>
                    <div class="col-md-4">
                        <div class="card card-custom p-4" onclick="location.href='detail_checkup.php?id=<?php echo $row['id']; ?>'">
                            <div class="icon-box">
                                <i class="bi <?php echo htmlspecialchars($row['icon']); ?>"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($row['nama_checkup']); ?></h4>
                            <p class="text-muted small mb-0"><?php echo htmlspecialchars($row['durasi']); ?></p>
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