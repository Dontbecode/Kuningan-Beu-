<?php
include "Components/header.php";

// Cek apakah sesi sudah ada atau belum
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$conn = include "../koneksi.php";

// Validasi ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID tidak valid.";
    exit();
}

// Get the package ID from the URL
$wisata_id = intval($_GET['id']); // Pastikan ID adalah integer

// Prepare and execute the query to fetch objek wisata data
$stmt = $conn->prepare("SELECT * FROM objek_wisata WHERE id = ?");
$stmt->bind_param("i", $wisata_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    echo "Objek wisata tidak ditemukan.";
    exit();
}
?>
<link rel="stylesheet" href="../assets/css/datatables.min.css">
<div class="container-fluid">
    <div class="row">

        <?= include "Components/nav.php" ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Objek Wisata</h1>
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="nav-item user-greeting alert alert-custom d-flex align-items-center">
                        <h1 class="mb-0">Hai, <?= htmlspecialchars($_SESSION['nama']); ?></h1>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card">
                <div class="card-body">
                <?php include "Components/alert.php" ?>
                    <form action="Controllers/updateobjekwisata.php" method="post" enctype="multipart/form-data">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Obyek Wisata</label>
                                        <input type="text" class="form-control" name="nama" id="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required><?= htmlspecialchars($data['alamat']) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="img" class="form-label">Gambar</label>
                                        <input type="file" name="img" id="img" class="form-control">
                                        <?php if (!empty($data['gambar'])): ?>
                                            <img src="../IMG/<?= htmlspecialchars($data['gambar']) ?>" alt="Current Image" width="100" height="100" class="mt-2">
                                        <?php endif; ?>
                                    </div>
                                    <input type="hidden" name="wisata_id" value="<?= htmlspecialchars($wisata_id) ?>">
                                    <div class="float-end">
                                        <button class="btn btn-danger" type="reset">Reset</button>
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include "Components/footer.php"; ?>
<script src="../assets/js/jquery-3.7.1.min.js"></script>
<script src="../assets/js/datatables.min.js"></script>
</body>
</html>
