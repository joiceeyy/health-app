<?php 
include 'config/koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Checkup - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-brown: #A68A78;
            --light-bg: #F8F1ED;
        }
        body {
            background-color: var(--light-bg);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card-mockup {
            width: 350px;
            background: var(--primary-brown);
            border-radius: 40px;
            padding: 40px 20px;
            text-align: center;
            color: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .img-hero {
            width: 200px;
            margin-bottom: 20px;
        }
        .white-section {
            background: white;
            border-radius: 30px;
            padding: 30px 20px;
            color: #333;
            margin-top: 20px;
        }
        .btn-get-started {
            background-color: var(--primary-brown);
            color: white;
            border-radius: 25px;
            padding: 10px 30px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 15px;
            transition: 0.3s;
        }
        .btn-get-started:hover {
            background-color: #8e7363;
            color: white;
        }
    </style>
</head>
<body>

    <div class="card-mockup">
        <img src="assets/images/medical_kit.png" class="img-hero" alt="Medical Kit">
        
        <div class="white-section">
            <h4 class="fw-bold">Are you ready for a health checkup?</h4>
            <p class="text-muted small">Improving your life by checking all your cells</p>
            <a href="login.php" class="btn-get-started">Get Started</a>
        </div>
    </div>

</body>
</html>