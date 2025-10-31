<?php
include 'config.php';

// pastikan sudah login
if (!isset($_SESSION['mahasiswa_id'])) {
    header("Location: login.php");
    exit();
}

$mahasiswa_id = $_SESSION['mahasiswa_id'];
$mhs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id='$mahasiswa_id'"));

if ($mhs['has_voted'] == 1) {
    echo "<script>alert('Kamu sudah memilih! Terima kasih.'); window.location='logout.php';</script>";
    exit();
}

$kandidat = mysqli_query($conn, "SELECT * FROM kandidat");

if (isset($_POST['pilih'])) {
    $kandidat_id = $_POST['kandidat_id'];
    mysqli_query($conn, "INSERT INTO suara (mahasiswa_id, kandidat_id) VALUES ('$mahasiswa_id', '$kandidat_id')");
    mysqli_query($conn, "UPDATE mahasiswa SET has_voted=1 WHERE id='$mahasiswa_id'");
    echo "<script>alert('Pilihan kamu berhasil disimpan. Terima kasih sudah memilih!'); window.location='logout.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>E-Voting PEMIRA BEM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f2f6fc;
        }
        .card {
            border: none;
            border-radius: 15px;
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .foto-calon {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #007bff;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="text-center mb-4">
        <h3>PEMIRA BEM UNIVERSITAS HANG TUAH PEKANBARU</h3>
        <p>Selamat datang, <b><?= $_SESSION['nama']; ?></b></p>
        <hr>
    </div>

    <div class="row justify-content-center">
        <?php while ($row = mysqli_fetch_assoc($kandidat)) { ?>
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-lg p-3">
                    <img src="<?= $row['foto']; ?>" alt="Foto <?= $row['nama_ketua']; ?>" class="foto-calon mx-auto">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['nama_ketua']; ?> & <?= $row['nama_wakil']; ?></h5>
                        <p><strong>Visi:</strong> <?= $row['visi']; ?></p>
                        <p><strong>Misi:</strong> <?= $row['misi']; ?></p>
                        <form method="POST">
                            <input type="hidden" name="kandidat_id" value="<?= $row['id']; ?>">
                            <button type="submit" name="pilih" class="btn btn-success w-100">Pilih Calon Ini</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="text-center mt-4">
        <a href="logout.php" class="btn btn-danger">Keluar</a>
    </div>
</div>

</body>
</html>
