<?php
include "Components/header.php";

// Cek apakah sesi sudah ada atau belum
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
?>

<div class="container-fluid">
    <div class="row">

        <?= include "Components/nav.php" ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tambah Paket Wisata</h1>
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="nav-item user-greeting alert alert-custom d-flex align-items-center">
                        <h1 class="mb-0">Hai, <?= htmlspecialchars($_SESSION['nama']); ?></h1>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card mb-2">
                <div class="card-body">

                    <?php include "Components/alert.php" ?>

                    <form action="Controllers/simpanpaket.php" method="post" enctype="multipart/form-data">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <label for="" class="form-label">Obyek Wisata</label>
                                        <select name="obyek_wisata_id" id="" class="form-select" required>
                                            <option value="">--Pilih Objek Wisata--</option>
                                            <?php
                                            $conn = include "../koneksi.php";
                                            $query = "SELECT id,nama FROM objek_wisata";
                                            $result = mysqli_query($conn, $query);
                                            while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            ?>
                                                <option value="<?= $data['id'] ?>"><?= $data['nama'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="" class="form-label">Nama Paket Camping</label>
                                        <input type="text" class="form-control" name="paket_camping" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="" class="form-label">Harga Paket</label>
                                        <input type="number" name="harga_paket" min=0 class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="" class="form-label">Area Camping</label>
                                        <input type="text" name="area_camping" min=0 class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="" class="form-label">Kapasitas</label>
                                        <input type="number" name="kapasitas" min=0 class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="" class="form-label">Bonus Peralatan</label>
                                        <input type="text" name="bonus_peralatan" min=0 class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="" class="form-label">Diskon</label>
                                        <div class="input-group">
                                            <input type="number" name="diskon" min=0 max=100 class="form-control" required>
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label for="" class="form-label">Gambar</label>
                                        <input type="file" name="gambar" class="form-control" required>
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