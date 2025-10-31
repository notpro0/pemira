<?php
include 'config.php';

// cek login admin
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// tambah kandidat
if (isset($_POST['tambah'])) {
    $nama_ketua = $_POST['nama_ketua'];
    $nama_wakil = $_POST['nama_wakil'];
    $visi = $_POST['visi'];
    $misi = $_POST['misi'];
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    move_uploaded_file($tmp, "uploads/" . $foto);
    mysqli_query($conn, "INSERT INTO kandidat (nama_ketua, nama_wakil, visi, misi, foto) VALUES ('$nama_ketua', '$nama_wakil', '$visi', '$misi', '$foto')");

    header("Location: admin_kandidat.php");
    exit();
}

// hapus kandidat
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM kandidat WHERE id='$id'");
    header("Location: admin_kandidat.php");
    exit();
}

// ambil data kandidat
$kandidat = mysqli_query($conn, "SELECT * FROM kandidat");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kandidat - Admin Pemira BEM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3 class="mb-3">Kelola Kandidat</h3>
    <a href="admin_dashboard.php" class="btn btn-secondary mb-3">⬅ Kembali</a>

    <!-- Form Tambah Kandidat -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Tambah Kandidat Baru</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label>Nama Ketua</label>
                        <input type="text" name="nama_ketua" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Nama Wakil</label>
                        <input type="text" name="nama_wakil" class="form-control" required>
                    </div>
                </div>
                <div class="mb-2">
                    <label>Visi</label>
                    <textarea name="visi" class="form-control" required></textarea>
                </div>
                <div class="mb-2">
                    <label>Misi</label>
                    <textarea name="misi" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Foto Kandidat</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" name="tambah" class="btn btn-success">Tambah Kandidat</button>
            </form>
        </div>
    </div>

    <!-- Daftar Kandidat -->
    <div class="card">
        <div class="card-header bg-secondary text-white">Daftar Kandidat</div>
        <div class="card-body">
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($kandidat)) { ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="uploads/<?= $row['foto']; ?>" class="card-img-top" height="200" style="object-fit:cover;">
                            <div class="card-body">
                                <h5><?= $row['nama_ketua']; ?> & <?= $row['nama_wakil']; ?></h5>
                                <p><b>Visi:</b> <?= $row['visi']; ?></p>
                                <p><b>Misi:</b> <?= $row['misi']; ?></p>
                                <a href="?hapus=<?= $row['id']; ?>" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin hapus kandidat ini?')">Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>
