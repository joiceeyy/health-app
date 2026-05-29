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
    <title>Eye Focus Trainer - Health App</title>
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
        .game-card {
            background: white;
            border-radius: 30px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.02);
            max-width: 600px;
            margin: auto;
        }
        .game-area {
            position: relative;
            width: 100%;
            height: 300px;
            background-color: #FAF5F2;
            border: 3px dashed var(--primary-brown);
            border-radius: 20px;
            overflow: hidden;
            margin: 20px 0;
        }
        .eye-target {
            position: absolute;
            width: 45px;
            height: 45px;
            background-color: var(--primary-brown);
            border: 4px solid white;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            box-shadow: 0 4px 10px rgba(166, 138, 120, 0.4);
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .btn-start {
            background-color: var(--primary-brown);
            color: white;
            font-weight: 600;
            padding: 10px 30px;
            border-radius: 12px;
            border: none;
            transition: all 0.3s;
        }
        .btn-start:hover {
            background-color: var(--dark-brown);
            color: white;
        }
        .score-board {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark-brown);
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
                    <a class="nav-link text-warning fw-bold" href="game.php">🎯 Daily Lucky Tip</a>
                    <a class="nav-link active text-info fw-bold" href="game_mata.php">👁️ Eye Trainer</a>
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
            <p class="text-muted mb-4">Latih ketajaman dan otot matamu agar tidak kaku!</p>

            <div class="game-card text-center">
                <h4 class="fw-bold text-dark mb-1">👁️ Eye Focus Trainer 👁️</h4>
                <p class="text-muted small mb-3">Ikuti dan klik bola target cokelat secepat mungkin untuk melatih gerak otot mata.</p>

                <div class="d-flex justify-content-around score-board bg-light p-2 rounded-3">
                    <div>⏱️ Waktu: <span id="timeLeft">20</span>s</div>
                    <div>⭐ Skor: <span id="score">0</span></div>
                </div>

                <div class="game-area" id="gameArea">
                    <div class="eye-target" id="eyeTarget" onclick="hitTarget()">👁️</div>
                </div>

                <button class="btn btn-start" id="startBtn" onclick="startGame()">MULAI LATIHAN MATA</button>
                <div class="mt-3 text-muted small" id="gameInfo">
                    *Game berlangsung selama 20 detik.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let score = 0;
    let timeLeft = 20;
    let gameInterval;
    let moveInterval;
    let isPlaying = false;

    const gameArea = document.getElementById('gameArea');
    const target = document.getElementById('eyeTarget');
    const scoreDisplay = document.getElementById('score');
    const timeDisplay = document.getElementById('timeLeft');
    const startBtn = document.getElementById('startBtn');
    const gameInfo = document.getElementById('gameInfo');

    function startGame() {
        if (isPlaying) return;
        score = 0;
        timeLeft = 20;
        isPlaying = true;
        scoreDisplay.innerText = score;
        timeDisplay.innerText = timeLeft;
        startBtn.disabled = true;
        target.style.display = 'flex';
        moveTarget();

        moveInterval = setInterval(moveTarget, 1000);
        gameInterval = setInterval(() => {
            timeLeft--;
            timeDisplay.innerText = timeLeft;
            if (timeLeft <= 0) endGame();
        }, 1000);
    }

    function moveTarget() {
        if (!isPlaying) return;
        const maxX = gameArea.clientWidth - target.clientWidth;
        const maxY = gameArea.clientHeight - target.clientHeight;
        target.style.left = Math.floor(Math.random() * maxX) + 'px';
        target.style.top = Math.floor(Math.random() * maxY) + 'px';
    }

    function hitTarget() {
        if (!isPlaying) return;
        score += 10;
        scoreDisplay.innerText = score;
        moveTarget();
        clearInterval(moveInterval);
        moveInterval = setInterval(moveTarget, 1000);
    }

    function endGame() {
        isPlaying = false;
        clearInterval(gameInterval);
        clearInterval(moveInterval);
        target.style.display = 'none';
        startBtn.disabled = false;
        startBtn.innerText = "MAIN LAGI";
        alert(`Latihan Selesai!\nSkor Akhir: ${score}`);
    }
</script>

</body>
</html>