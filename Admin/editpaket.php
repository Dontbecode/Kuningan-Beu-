<?php
include "Components/header.php";

// Cek apakah sesi sudah ada atau belum
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$conn = include "../koneksi.php";

// Get the package ID from the URL
$paket_camping_id = base64_decode($_GET['id']);

// Prepare and execute the query to fetch paket camping data
$stmt = $conn->prepare("SELECT * FROM paket_camping WHERE id=?");
$stmt->bind_param("i", $paket_camping_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();
?>

<div class="container-fluid">
    <div class="row">
        <?= include "Components/nav.php" ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Paket Camping</h1>
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="nav-item user-greeting alert alert-custom d-flex align-items-center">
                        <h1 class="mb-0">Hai, <?= htmlspecialchars($_SESSION['nama'] ?? 'Guest', ENT_QUOTES, 'UTF-8'); ?></h1>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <?php include "Components/alert.php" ?>

                    <form action="Controllers/updatepaket.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="paket_camping_id" value="<?= htmlspecialchars($data['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <label for="obyek_wisata_id" class="form-label">Obyek Wisata</label>
                                        <select name="obyek_wisata_id" id="obyek_wisata_id" class="form-select" required>
                                            <option value="">--Pilih Objek Wisata--</option>
                                            <?php
                                            $query = "SELECT id, nama FROM objek_wisata";
                                            $result = mysqli_query($conn, $query);
                                            while ($objek_wisata = mysqli_fetch_assoc($result)) {
                                                $selected = ($objek_wisata['id'] == ($data['obyek_wisata_id'] ?? '')) ? 'selected' : '';
                                                echo "<option value=\"" . htmlspecialchars($objek_wisata['id'], ENT_QUOTES, 'UTF-8') . "\" $selected>" . htmlspecialchars($objek_wisata['nama'], ENT_QUOTES, 'UTF-8') . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="paket_camping" class="form-label">Nama Paket Camping</label>
                                        <input type="text" id="paket_camping" class="form-control" name="paket_camping" value="<?= htmlspecialchars($data['paket_camping'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="harga_paket" class="form-label">Harga Paket</label>
                                        <input type="number" id="harga_paket" name="harga_paket" min="0" class="form-control" value="<?= htmlspecialchars($data['harga_paket'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="area_camping" class="form-label">Area Camping</label>
                                        <input type="text" id="area_camping" name="area_camping" class="form-control" value="<?= htmlspecialchars($data['area_camping'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="kapasitas" class="form-label">Kapasitas</label>
                                        <input type="number" id="kapasitas" name="kapasitas" min="0" class="form-control" value="<?= htmlspecialchars($data['kapasitas'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="bonus_peralatan" class="form-label">Bonus Peralatan</label>
                                        <input type="text" id="bonus_peralatan" name="bonus_peralatan" class="form-control" value="<?= htmlspecialchars($data['bonus_peralatan'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="diskon" class="form-label">Diskon</label>
                                        <div class="input-group">
                                            <input type="number" id="diskon" name="diskon" min="0" max="100" class="form-control" value="<?= htmlspecialchars($data['diskon'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label for="gambar" class="form-label">Gambar</label>
                                        <input type="file" id="gambar" name="gambar" class="form-control">
                                        <?php if (!empty($data['gambar'])): ?>
                                            <img src="../IMG/<?= htmlspecialchars($data['gambar'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($data['paket_camping'], ENT_QUOTES, 'UTF-8'); ?>" class="img-thumbnail mt-2" width="100" height="100" onerror="this.onerror=null; this.src='../IMG/default.jpg';" style="object-fit: cover;">
                                        <?php endif; ?>
                                    </div>
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
</body>
</html>
