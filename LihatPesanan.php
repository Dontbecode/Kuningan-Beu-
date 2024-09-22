<?php
include "Components/HeaderComponent.php";

// Menampilkan pesan sukses jika ada
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
        . $_SESSION['success_message'] .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    unset($_SESSION['success_message']);
}

// Menampilkan pesan error jika ada
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
        . $_SESSION['error_message'] .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    unset($_SESSION['error_message']);
}

$conn = include "koneksi.php";

$query = "SELECT pc.*, pk.paket_camping 
          FROM pemesanan_camping pc
          JOIN paket_camping pk ON pc.paket_camping_id = pk.id
          ORDER BY pc.created_at DESC";
$result = $conn->query($query);

// Periksa apakah query berhasil
if ($result === false) {
    echo "Query error: " . $conn->error;
    exit;
}
?>
<main>
    <section class="container py-3">
        <div class="row">
            <div class="col-lg-3">
                <form action="Controllers/UpdateProfile.php" method="post">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Profile</h5>
                            <div class="row mb-2">
                                <label for="nama" class="col-lg-4">Nama</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?= $_SESSION['nama'] ?>" required disabled>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="no_hp" class="col-lg-4">No Telp/HP</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="no_hp" id="no_hp" maxlength="15" value="<?= $_SESSION['no_hp'] ?>" required disabled>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-4">Username</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" value="<?= $_SESSION['username'] ?>" required disabled>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="password" class="col-lg-4">Password</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="password" id="password" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-end">
                                <button type="button" onclick="edit()" id="editBtn" class="btn btn-danger me-2">Edit</button>
                                <button type="button" onclick="batal()" id="batalBtn" class="btn btn-danger me-2" disabled>Batal</button>
                                <button type="submit" id="simpanBtn" class="btn btn-success" disabled>Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Data Pesanan</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>No Pemesanan</th>
                                        <th>Nama</th>
                                        <th>No HP</th>
                                        <th>Paket Camping</th>
                                        <th>Tanggal</th>
                                        <th>Durasi</th>
                                        <th>Jumlah Peserta</th>
                                        <th>Diskon</th>
                                        <th>Jenis Tenda</th>
                                        <th>Jenis Makanan</th>
                                        <th>Harga Paket</th>
                                        <th>Total Tagihan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                if ($result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                        <td><?= htmlspecialchars($row['no_pemesanan'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($row['nama'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($row['no_hp'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($row['paket_camping'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($row['tanggal'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($row['durasi'] ?? '') ?> hari</td>
                                            <td><?= htmlspecialchars($row['jml_peserta'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($row['diskon'] ?? '') ?>%</td>
                                            <td><?= htmlspecialchars($row['jenis_tenda'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($row['jenis_makanan'] ?? '') ?></td>
                                            <td>Rp <?= number_format($row['harga_paket'] ?? 0, 0, ',', '.') ?></td>
                                            <td>Rp <?= number_format($row['total_tagihan'] ?? 0, 0, ',', '.') ?></td>
                                            <td><?= htmlspecialchars($row['status'] ?? '') ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                        <tr>
                                            <td colspan="13" class="text-center">Tidak ada data pesanan</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
        
    $(document).ready(function() {
        $("#table").dataTable();
    });

    function edit() {
        $("#nama, #no_hp, #password").attr("disabled", false);
        $("#batalBtn, #simpanBtn").attr("disabled", false);
        $("#editBtn").toggle("fast");
    }

    function batal() {
        $("#nama, #no_hp, #password").attr("disabled", true);
        $("#batalBtn, #simpanBtn").attr("disabled", true);
        $("#editBtn").toggle("fast");
        $('form').trigger("reset");
    }

    
    $(document).ready(function() {
        // Periksa apakah DataTable sudah terinisialisasi
        if (!$.fn.DataTable.isDataTable('#table')) {
            $("#table").DataTable({
                "paging": false, // Pagination handled by PHP
                "searching": false, // Searching handled by HTML form
                "ordering": true,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [12] // Adjust the index based on your table columns
                }],
                "order": [[12, 'asc']] // Adjust the index based on your desired default sort column
            });
        }
    });



</script>
<?php
include "Components/FooterComponent.php";
?>
