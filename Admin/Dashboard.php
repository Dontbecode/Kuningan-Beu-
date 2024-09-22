<?php
include "Components/header.php";

// Cek apakah sesi sudah ada atau belum
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
$conn = include "../koneksi.php";

// Query untuk mengambil data pesanan dan paket camping
$query = "SELECT pc.*, pk.paket_camping 
          FROM pemesanan_camping pc
          LEFT JOIN paket_camping pk ON pc.paket_camping_id = pk.id
          ORDER BY pc.created_at DESC";
$result = $conn->query($query);

// Periksa apakah query berhasil
if ($result === false) {
    echo "Query error: " . $conn->error;
    exit;
}
?>

<div class="container-fluid">
    <div class="row">
        <?php include "Components/nav.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard Data Pemesanan</h1>
                <?php include "Components/alert.php" ?>
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="nav-item user-greeting alert alert-custom d-flex align-items-center">
                        <h1 class="mb-0">Hai, <?= htmlspecialchars($_SESSION['nama']); ?></h1>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="table">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No Pemesanan</th>
                                            <th rowspan="2">Nama</th>
                                            <th rowspan="2">No HP</th>
                                            <th rowspan="2">Paket Camping</th>
                                            <th rowspan="2">Tanggal</th>
                                            <th rowspan="2">Durasi</th>
                                            <th rowspan="2">Jumlah Peserta</th>
                                            <th rowspan="2">Diskon</th>
                                            <th rowspan="2">Jenis Tenda</th>
                                            <th rowspan="2">Jenis Makanan</th>
                                            <th rowspan="2">Harga Paket</th>
                                            <th rowspan="2">Total Tagihan</th>
                                            <th rowspan="2">Status</th>
                                            <th colspan="3">Aksi</th>
                                        </tr>
                                        <tr>
                                            <td>Proses</td>
                                            <td>Edit</td>
                                            <td>Hapus</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            foreach ($result as $row) {
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['no_pemesanan'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($row['nama'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($row['no_hp'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($row['paket_camping'] ?? 'Tidak tersedia') ?></td>
                                                <td><?= htmlspecialchars($row['tanggal'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($row['durasi'] ?? '') ?> hari</td>
                                                <td><?= htmlspecialchars($row['jml_peserta'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($row['diskon'] ?? '') ?>%</td>
                                                <td><?= htmlspecialchars($row['jenis_tenda'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($row['jenis_makanan'] ?? '') ?></td>
                                                <td>Rp <?= number_format($row['harga_paket'] ?? 0, 0, ',', '.') ?></td>
                                                <td>Rp <?= number_format($row['total_tagihan'] ?? 0, 0, ',', '.') ?></td>
                                                <td><?= htmlspecialchars($row['status'] ?? '') ?></td>
                                                <td>
                                                    <form action="Controllers/updatestatus.php" method="post" class="d-inline">
                                                        <?php
                                                            // Tentukan status tombol aksi
                                                            $status = "";
                                                            switch ($row['status']) {
                                                                case "Belum Diproses":
                                                                    $status = "Proses";
                                                                    break;
                                                                case "Proses":
                                                                    $status = "Selesai";
                                                                    break;
                                                                default:
                                                                    $status = "";
                                                                    break;
                                                            }
                                                        ?>
                                                        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                                        <input type="hidden" name="status" value="<?= htmlspecialchars($status) ?>">
                                                        <?php if ($row['status'] != "Selesai") { ?>
                                                            <button class="btn btn-primary btn-sm" onclick="return confirm('Yakin akan <?= htmlspecialchars($status) ?> data ini?')">
                                                                <?= htmlspecialchars($status) ?>
                                                            </button>
                                                        <?php } else { ?>
                                                            <span class="btn btn-sm btn-success">
                                                                <i class="bi bi-check2-square"></i> Selesai
                                                            </span>
                                                        <?php } ?>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="editpesanan.php?id=<?=base64_encode($row['id'])?>" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                                                </td>
                                                <td>
                                                    <form action="Controllers/hapuspesanan.php" method="post" class="d-inline">
                                                        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                                        <input type="hidden" name="table" value="pemesanan_camping">
                                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        } else {
                                        ?>
                                            <tr>
                                                <td colspan="14" class="text-center">Tidak ada data pesanan</td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include "Components/footer.php"; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/jquery-3.7.1.min.js"></script>
<script src="../asset/js/datatables.min.js"></script>
<script>
$(document).ready(function() {
    $("#table").DataTable({
        columnDefs: [{
            orderable: false,
            targets: [13] // Menandakan kolom aksi yang tidak dapat diurutkan
        }],
        order: [[11, 'desc']] // Urutkan berdasarkan kolom 11 (Total Tagihan)
    });
});
</script>
</body>
</html>
