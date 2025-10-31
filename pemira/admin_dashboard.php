<?php
include 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Pemira BEM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Admin Pemira BEM</a>
    <div class="d-flex">
      <a href="logout_admin.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <h4>Selamat datang, <b><?= $_SESSION['admin']; ?></b></h4>
    <hr>

    <div class="list-group">
        <a href="admin_kandidat.php" class="list-group-item list-group-item-action">🧑‍🎓 Kelola Kandidat</a>
        <a href="hasil_voting.php" class="list-group-item list-group-item-action">📊 Lihat Hasil Voting</a>
        <a href="reset_voting.php" class="list-group-item list-group-item-action text-danger">🔁 Reset Voting</a>
    </div>
</div>

</body>
</html>
