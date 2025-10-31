<?php
include 'config.php';

if (isset($_POST['login'])) {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($role == 'mahasiswa') {
        $query = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$username' AND password='$password'");
        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            $_SESSION['mahasiswa_id'] = $data['id'];
            $_SESSION['nama'] = $data['nama'];
            header("Location: vote.php");
            exit();
        } else {
            $error = "NIM atau Password salah!";
        }
    } elseif ($role == 'admin') {
        $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
        if (mysqli_num_rows($query) > 0) {
            $_SESSION['admin'] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Username atau Password salah!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - PEMIRA BEM UHT Pekanbaru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- 🔹 responsif -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0061ff, #60efff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Poppins", sans-serif;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            padding: 40px 35px;
            width: 100%;
            max-width: 420px;
            animation: fadeInUp 0.8s ease;
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-card h3 {
            font-weight: 700;
            color: #0061ff;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0061ff, #60efff);
            border: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 97, 255, 0.4);
        }

        .footer-text {
            font-size: 0.85rem;
            color: #777;
            margin-top: 10px;
        }

        /* 🔹 Responsif tambahan */
        @media (max-width: 768px) {
            .login-card {
                padding: 30px 25px;
                max-width: 100%;
            }
            .login-card h3 {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>

<div class="login-card text-center">
    <img src="logo.jpeg" width="80" class="mb-3" alt="Logo UHT" style="border-radius: 50%; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
    <h3>PEMIRA BEM UHT Pekanbaru</h3>
    <p class="text-muted mb-4">Sistem E-Voting Mahasiswa</p>

    <?php if (isset($error)) { ?>
        <div class="alert alert-danger py-2"><?= $error; ?></div>
    <?php } ?>

    <form method="POST">
        <div class="form-floating mb-3">
            <select name="role" class="form-select" id="role" required>
                <option value="mahasiswa">Mahasiswa (Pemilih)</option>
                <option value="admin">Admin (Panitia)</option>
            </select>
            <label for="role">Login Sebagai</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan NIM / Username" required>
            <label for="username">NIM / Username</label>
        </div>

        <div class="form-floating mb-4">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>

        <button type="submit" name="login" class="btn btn-primary w-100 py-2">Masuk</button>
    </form>

    <p class="footer-text mt-3">© <?= date('Y'); ?> BEM Universitas Hang Tuah Pekanbaru</p>
</div>

</body>
</html>
