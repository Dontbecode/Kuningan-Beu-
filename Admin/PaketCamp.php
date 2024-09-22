<?php
include "Components/header.php";

// Cek apakah sesi sudah ada atau belum
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
?>
<link rel="stylesheet" href="../assets/css/datatables.min.css">
<div class="container-fluid">
    <div class="row">

        <?= include "Components/nav.php" ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Paket Camping</h1>
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="nav-item user-greeting alert alert-custom d-flex align-items-center">
                        <h1 class="mb-0">Hai, <?= htmlspecialchars($_SESSION['nama']); ?></h1>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card">
                <div class="card-body">
                   
                    <a href="tambahpaket.php" class="btn btn-primary">Tambah Paket Camping</a>
                    <div class="table-responsive">
                        <table class="table table-striped" id="table">
                            <thead>
                                <tr>
                                    <th>Obyek Wisata</th>
                                    <th>Paket Camping</th>
                                    <th>Harga Paket</th>
                                    <th>Area Camping</th>
                                    <th>Kapasitas</th>
                                    <th>Bonus Peralatan</th>
                                    <th>Diskon</th>
                                    <th>Gambar</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $conn = include "../koneksi.php";
                                $query = "SELECT *, (SELECT nama FROM objek_wisata WHERE id=paket_camping.obyek_wisata_id) AS objek_wisata FROM paket_camping";
                                $result = mysqli_query($conn, $query);
                                while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?= $data['objek_wisata'] ?></td>
                                    <td><?= $data['paket_camping'] ?></td>
                                    <td><?= $data['harga_paket'] ?></td>
                                    <td><?= $data['area_camping'] ?></td>
                                    <td><?= $data['kapasitas'] ?></td>
                                    <td><?= $data['bonus_peralatan'] ?></td>
                                    <td><?= $data['diskon'] ?>%</td>
                                    <td><img src="../IMG/<?= $data['gambar'] ?>" alt="<?= $data['paket_camping'] ?>" class="img-thumbnail" width="100" height="100" onerror="this.onerror=null; this.src='../IMG/default.jpg';" style="object-fit: cover;"></td>
                                    <td>
                                        <div class="col-auto">
                                            <form action="Controllers/hapus.php" method="post">
                                                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                                <input type="hidden" name="table" value="paket_camping">
                                                <a href="editpaket.php?id=<?= $data['id'] ?>" class="btn btn-success btn-sm">Edit</a>
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include "Components/footer.php"; ?>
<script src="../assets/js/jquery-3.7.1.min.js"></script>
<script src="../assets/js/datatables.min.js"></script>
<script>
    $("#table").dataTable()
</script>

</body>

</html>