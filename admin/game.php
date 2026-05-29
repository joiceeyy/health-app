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
    <title>Daily Lucky Tip - Health App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-brown: #A68A78;
            --light-bg: #F8F1ED;
            --dark-brown: #8C7262;
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
        .game-container {
            background: white;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.02);
            text-align: center;
            max-width: 500px;
            margin: auto;
        }
        .wheel-box {
            position: relative;
            width: 260px;
            height: 260px;
            margin: 30px auto;
        }
        .wheel-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 5px solid var(--primary-brown);
            transition: transform 3s cubic-bezier(0.1, 0.8, 0.1, 1);
            background: conic-gradient(
                #A68A78 0deg 60deg, #CDBBA7 60deg 120deg,
                #FAF5F2 120deg 180deg, #8C7262 180deg 240deg,
                #A68A78 240deg 300deg, #CDBBA7 300deg 360deg
            );
        }
        .wheel-pointer {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-top: 25px solid #FFC107;
            z-index: 10;
        }
        .btn-spin {
            background-color: var(--primary-brown);
            color: white;
            font-weight: 600;
            padding: 12px 35px;
            border-radius: 15px;
            border: none;
            transition: background 0.3s;
        }
        .btn-spin:hover {
            background-color: var(--dark-brown);
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
                    <a class="nav-link" href="doctors.php">Your doctors</a>
                    <a class="nav-link active text-warning fw-bold" href="game.php">🎯 Daily Lucky Tip</a>
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
            <p class="text-muted mb-4">Dapatkan tips kesehatan acak hari ini!</p>

            <div class="game-container">
                <h4 class="fw-bold text-dark">🎯 Daily Lucky Tip 🎯</h4>
                <p class="text-muted small">Putar rodanya untuk mendapatkan tips kesehatan seru hari ini!</p>
                
                <div class="wheel-box">
                    <div class="wheel-pointer"></div>
                    <div class="wheel-img" id="wheel"></div>
                </div>

                <button class="btn btn-spin mb-4" id="spinBtn" onclick="spinWheel()">PUTAR RODA</button>
                <h5 class="fw-bold text-success mt-2" id="resultTip"></h5>
            </div>
        </div>
    </div>
</div>

<script>
    const tips = [
        "Minum air putih 8 gelas hari ini! 💧",
        "Jangan lupa luangkan waktu jalan kaki 15 menit. 🚶‍♂️",
        "Istirahatkan mata tiap 20 menit menatap layar komputer! 👁️",
        "Kurangi konsumsi gula berlebih hari ini ya! 🍎",
        "Tidur tepat waktu malam ini minimal 7-8 jam. 😴",
        "Lakukan peregangan otot ringan sekarang juga! 🧘‍♂️"
    ];

    let isSpinning = false;

    function spinWheel() {
        if (isSpinning) return;
        isSpinning = true;
        
        document.getElementById('resultTip').innerText = "";
        const wheel = document.getElementById('wheel');
        const randomDeg = Math.floor(Math.random() * 360) + 1440;
        
        wheel.style.transform = `rotate(${randomDeg}deg)`;
        
        setTimeout(() => {
            isSpinning = false;
            const randomIndex = Math.floor(Math.random() * tips.length);
            document.getElementById('resultTip').innerText = tips[randomIndex];
        }, 3000);
    }
</script>

</body>
</html>