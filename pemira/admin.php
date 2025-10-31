<?php
include 'config.php';

// Ambil total mahasiswa
$total_mhs = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mahasiswa"));

// Ambil total yang sudah memilih
$total_voted = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mahasiswa WHERE has_voted=1"));

// Ambil data hasil voting per kandidat
$hasil = mysqli_query($conn, "
    SELECT k.nama_ketua, k.nama_wakil, COUNT(s.kandidat_id) AS total_suara
    FROM kandidat k
    LEFT JOIN suara s ON k.id = s.kandidat_id
    GROUP BY k.id
");

// Simpan data ke array untuk Chart.js
$nama_calon = [];
$jumlah_suara = [];

while ($row = mysqli_fetch_assoc($hasil)) {
    $nama_calon[] = $row['nama_ketua'] . " & " . $row['nama_wakil'];
    $jumlah_suara[] = $row['total_suara'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil E-Voting BEM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background: #f8f9fa; }
        .card { border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="text-center mb-4">
        <a href="kelola_kandidat.php" class="btn btn-success">Kelola Kandidat</a>
        <a href="reset_voting.php" class="btn btn-danger" onclick="return confirm('Yakin ingin reset semua hasil voting?')">Reset Voting</a>

        <h3>HASIL SEMENTARA PEMIRA BEM<br>UNIVERSITAS HANG TUAH PEKANBARU</h3>
        <hr>
    </div>

    <div class="row text-center mb-4">
        <div class="col-md-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Total Mahasiswa</h5>
                    <h2><?= $total_mhs; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>Sudah Memilih</h5>
                    <h2><?= $total_voted; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <canvas id="chartHasil"></canvas>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">📊 Rekapitulasi Suara</h5>
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Calon</th>
                        <th>Total Suara</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    mysqli_data_seek($hasil, 0);
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($hasil)) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['nama_ketua']} & {$row['nama_wakil']}</td>
                                <td>{$row['total_suara']}</td>
                              </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('chartHasil');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($nama_calon); ?>,
        datasets: [{
            label: 'Jumlah Suara',
            data: <?= json_encode($jumlah_suara); ?>,
            borderWidth: 1,
            backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8']
        }]
    },
    options: {
        scales: { y: { beginAtZero: true } },
        plugins: { legend: { display: false } }
    }
});
</script>

</body>
</html>
