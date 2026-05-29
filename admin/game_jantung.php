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
    <title>Heart Rate Test - Health App</title>
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
        
        /* LAYOUT MONITOR JANTUNG */
        .game-card {
            background: #111;
            border-radius: 30px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            max-width: 550px;
            margin: auto;
            color: #00FF66;
        }
        
        /* ANIMASI GRAFIK EKG JANTUNG */
        .ecg-monitor {
            width: 100%;
            height: 120px;
            background-color: #050505;
            border: 2px solid #222;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
            margin: 15px 0;
        }
        .ecg-line {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent 0%, #00FF66 50%, transparent 100%);
            background-size: 50px 100%;
            mask-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,50 L35,50 L40,20 L45,80 L50,40 L55,55 L60,50 L100,50" stroke="black" stroke-width="3" fill="none"/></svg>');
            mask-size: 100% 100%;
            -webkit-mask-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,50 L35,50 L40,20 L45,80 L50,40 L55,55 L60,50 L100,50" stroke="black" stroke-width="3" fill="none"/></svg>');
            -webkit-mask-size: 100% 100%;
            animation: moveLine 1.5s linear infinite;
        }
        
        @keyframes moveLine {
            0% { background-position: -200px 0; }
            100% { background-position: 400px 0; }
        }
        
        /* TOMBOL TAP DETAK JANTUNG */
        .btn-heart-tap {
            width: 110px;
            height: 110px;
            background-color: #FF2E63;
            color: white;
            border-radius: 50%;
            border: 5px solid #fff;
            font-weight: bold;
            font-size: 14px;
            box-shadow: 0 0 20px rgba(255, 46, 99, 0.5);
            transition: transform 0.1s ease;
            cursor: pointer;
            outline: none;
        }
        .btn-heart-tap:active {
            transform: scale(0.9);
            box-shadow: 0 0 35px rgba(255, 46, 99, 0.9);
        }
        .btn-start-test {
            background-color: var(--primary-brown);
            color: white;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            padding: 10px;
        }
        .btn-start-test:hover {
            background-color: var(--dark-brown);
            color: white;
        }

        /* CUSTOM DESIGN MODAL HASIL TES */
        .modal-content-dark {
            background-color: #1a1a1a;
            color: white;
            border: 2px solid #333;
            border-radius: 20px;
        }
        .modal-header-dark {
            border-bottom: 1px solid #333;
        }
        .modal-footer-dark {
            border-top: 1px solid #333;
        }
        .result-box {
            background-color: #111;
            border-radius: 12px;
            padding: 15px;
            border: 1px dashed #444;
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
                    <a class="nav-link text-info fw-bold" href="game_mata.php">👁️ Eye Trainer</a>
                    <a class="nav-link active text-danger fw-bold" href="game_jantung.php">❤️ Heart Rate Test</a>
                </div>
            </div>
            <div class="mb-4">
                <hr class="text-white-50">
                <a class="nav-link text-danger fw-bold" href="../logout.php">Logout</a>
            </div>
        </div>

        <div class="col-md-9 col-lg-10 main-content">
            <h2 class="fw-bold mb-1">Hello <?php echo htmlspecialchars($_SESSION['nama']); ?>,</h2>
            <p class="text-muted mb-4">Uji kestabilan detak jantung dan tingkat stres kamu!</p>

            <div class="game-card text-center">
                <h4 class="fw-bold mb-1" style="color: #fff;">❤️ Heart Rate Simulator</h4>
                <p class="text-secondary small mb-3">Klik tombol hati di bawah berulang kali seirama dengan detak nadimu selama 10 detik!</p>

                <div class="ecg-monitor">
                    <div class="ecg-line" id="pulseLine" style="animation-play-state: paused;"></div>
                </div>

                <div class="row bg-dark mx-1 py-2 rounded-3 text-white fw-bold mb-4" style="border: 1px solid #333;">
                    <div class="col-6" style="border-right: 1px solid #333;">⏱️ Sisa Waktu: <span id="timer" class="text-warning">10</span>s</div>
                    <div class="col-6">💓 Beats: <span id="beatCount" class="text-info">0</span></div>
                </div>

                <div class="my-4">
                    <button class="btn-heart-tap" id="tapBtn" onclick="registerBeat()" disabled>TAP<br>BEAT</button>
                </div>

                <button class="btn btn-start-test w-100" id="startBtn" onclick="startHeartTest()">MULAI TES DETAK JANTUNG</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="resultModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-dark p-2">
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title fw-bold text-danger">📊 Hasil Analisis Detak Jantung</h5>
            </div>
            <div class="modal-body">
                <div class="result-box mb-3 text-center">
                    <div class="text-secondary small">TOTAL KETUKAN</div>
                    <h3 class="fw-bold text-info" id="resTotalBeat">0 kali</h3>
                    <hr class="my-2" style="border-color: #333;">
                    <div class="text-secondary small">PREDIKSI RITME</div>
                    <h2 class="fw-bold text-warning" id="resBPM">0 BPM</h2>
                </div>
                
                <h5 class="fw-bold mb-2">Status: <span id="resStatus">Normal</span></h5>
                <p class="text-secondary small mb-0" id="resSaran">Saran kesehatan akan muncul disini.</p>
            </div>
            <div class="modal-footer modal-footer-dark">
                <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 600;">OK, Paham!</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let beatCount = 0;
    let timeLeft = 10;
    let testInterval;
    let isTesting = false;

    const startBtn = document.getElementById('startBtn');
    const tapBtn = document.getElementById('tapBtn');
    const beatDisplay = document.getElementById('beatCount');
    const timerDisplay = document.getElementById('timer');
    const pulseLine = document.getElementById('pulseLine');
    
    // Inisialisasi Modal Bootstrap 5
    const resultModal = new bootstrap.Modal(document.getElementById('resultModal'));

    function startHeartTest() {
        if (isTesting) return;

        beatCount = 0;
        timeLeft = 10;
        isTesting = true;

        beatDisplay.innerText = beatCount;
        timerDisplay.innerText = timeLeft;

        tapBtn.disabled = false;
        startBtn.disabled = true;
        startBtn.innerText = "Uji Coba Sedang Berlangsung...";
        pulseLine.style.animationPlayState = "running";

        testInterval = setInterval(() => {
            timeLeft--;
            timerDisplay.innerText = timeLeft;

            if (timeLeft <= 0) {
                endHeartTest();
            }
        }, 1000);
    }

    function registerBeat() {
        if (!isTesting) return;
        beatCount++;
        beatDisplay.innerText = beatCount;

        pulseLine.style.opacity = "0.4";
        setTimeout(() => pulseLine.style.opacity = "1", 50);
    }

    function endHeartTest() {
        isTesting = false;
        clearInterval(testInterval);

        tapBtn.disabled = true;
        startBtn.disabled = false;
        startBtn.innerText = "TES ULANG JANTUNG";
        pulseLine.style.animationPlayState = "paused";

        let estimatedBPM = beatCount * 6;
        let status = "";
        let saran = "";

        if (estimatedBPM >= 60 && estimatedBPM <= 100) {
            status = "<span class='text-success'>NORMAL (Rileks) ✨</span>";
            saran = "Hebat Jo! Detak jantungmu sangat stabil, tandanya kamu lagi tenang dan gak stres.";
        } else if (estimatedBPM > 100 && estimatedBPM <= 130) {
            status = "<span class='text-warning'>SEDIKIT CEMAS / STRES 🔥</span>";
            saran = "Detak jantungmu agak cepat, Jo. Tarik napas dalam-dalam, mungkin kamu kebanyakan minum kopi atau pusing mikirin eror code.";
        } else if (estimatedBPM > 130) {
            status = "<span class='text-danger'>STRES TINGGI / PANIK 🔴</span>";
            saran = "Waduh tinggi banget! Buruan matiin teks editor laptopmu, ambil segelas air putih, dan rebahan dulu 10 menit ya!";
        } else {
            status = "<span class='text-secondary'>TERLALU LAMBAT 💤</span>";
            saran = "Ketukan kamu terlalu lambat, Jo. Pastikan kamu menepuk tombolnya sesuai detak nadi asli tanganmu ya.";
        }

        // Tembakkan hasil kalkulasi ke dalam element Modal HTML
        document.getElementById('resTotalBeat').innerText = beatCount + " kali";
        document.getElementById('resBPM').innerText = estimatedBPM + " BPM";
        document.getElementById('resStatus').innerHTML = status;
        document.getElementById('resSaran').innerText = saran;

        // Tampilkan Modal secara pop-up halus tanpa membawa teks localhost
        resultModal.show();
    }
</script>

</body>
</html>