<?php
include 'config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$q = mysqli_query($conn, "
    SELECT k.*, COUNT(s.id) AS total_suara
    FROM kandidat k
    LEFT JOIN suara s ON s.kandidat_id = k.id
    GROUP BY k.id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Voting - Admin Pemira BEM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3>📊 Hasil Voting Pemira BEM</h3>
    <a href="admin_dashboard.php" class="btn btn-secondary mb-3">⬅ Kembali</a>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Pasangan Calon</th>
                <th>Foto</th>
                <th>Total Suara</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($row = mysqli_fetch_assoc($q)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_ketua']; ?> & <?= $row['nama_wakil']; ?></td>
                <td><img src="uploads/<?= $row['foto']; ?>" width="80"></td>
                <td><b><?= $row['total_suara']; ?></b></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
