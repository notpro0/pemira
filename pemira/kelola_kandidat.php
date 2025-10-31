<?php
include 'config.php';

// Proses tambah kandidat
if (isset($_POST['tambah'])) {
    $nama_ketua = $_POST['nama_ketua'];
    $nama_wakil = $_POST['nama_wakil'];
    $visi = $_POST['visi'];
    $misi = $_POST['misi'];

    // upload foto
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $path = "uploads/" . basename($foto);

    if (move_uploaded_file($tmp, $path)) {
        $query = "INSERT INTO kandidat (nama_ketua, nama_wakil, foto, visi, misi)
                  VALUES ('$nama_ketua', '$nama_wakil', '$foto', '$visi', '$misi')";
        mysqli_query($conn, $query);
        $msg = "Kandidat berhasil ditambahkan!";
    } else {
        $msg = "Gagal upload foto!";
    }
}

// Proses hapus kandidat
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kandidat WHERE id='$id'"));
    if (file_exists("uploads/" . $data['foto'])) {
        unlink("uploads/" . $data['foto']);
    }
    mysqli_query($conn, "DELETE FROM kandidat WHERE id='$id'");
    header("Location: kelola_kandidat.php");
    exit();
}

$kandidat = mysqli_query($conn, "SELECT * FROM kandidat");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kandidat BEM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f4f6f9; }
        .card { border-radius: 15px; }
        img { border-radius: 10px; width: 150px; height: 150px; object-fit: cover; }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="text-center mb-4">
        <h3>Kelola Kandidat PEMIRA BEM</h3>
        <a href="admin.php" class="btn btn-secondary mt-2">← Kembali ke Hasil</a>
    </div>

    <?php if (isset($msg)) { ?>
        <div class="alert alert-info"><?= $msg; ?></div>
    <?php } ?>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Tambah Kandidat Baru</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Nama Ketua</label>
                        <input type="text" name="nama_ketua" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Nama Wakil</label>
                        <input type="text" name="nama_wakil" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Visi</label>
                    <textarea name="visi" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Misi</label>
                    <textarea name="misi" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Foto Kandidat</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" name="tambah" class="btn btn-success w-100">Tambah Kandidat</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white">Daftar Kandidat</div>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Ketua & Wakil</th>
                        <th>Visi</th>
                        <th>Misi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($kandidat)) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><img src="uploads/<?= $row['foto']; ?>"></td>
                            <td><?= $row['nama_ketua']; ?> & <?= $row['nama_wakil']; ?></td>
                            <td><?= $row['visi']; ?></td>
                            <td><?= $row['misi']; ?></td>
                            <td>
                                <a href="?hapus=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus kandidat ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
