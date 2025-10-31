<?php
include 'config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// hapus semua suara
mysqli_query($conn, "DELETE FROM suara");
// reset status mahasiswa
mysqli_query($conn, "UPDATE mahasiswa SET has_voted=0");

echo "<script>alert('Voting berhasil direset! Semua mahasiswa dapat memilih kembali.'); window.location='admin_dashboard.php';</script>";
?>
