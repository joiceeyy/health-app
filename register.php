<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #F8F1ED; font-family: 'Poppins', sans-serif; }
        .card-auth { max-width: 400px; margin: 80px auto; padding: 30px; background: white; border-radius: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
<div class="card-auth">
    <h3 class="fw-bold text-center mb-4">Daftar Akun</h3>
    <form action="proses_register.php" method="POST">
        <div class="mb-3"><input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required></div>
        <div class="mb-3"><input type="text" name="username" class="form-control" placeholder="Username" required></div>
        <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
        <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
        <p class="mt-3 text-center small">Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </form>
</div>
</body>
</html> 