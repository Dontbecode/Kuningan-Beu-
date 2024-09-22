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
                <h1 class="h2">Video</h1>
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="nav-item user-greeting alert alert-custom d-flex align-items-center">
                        <h1 class="mb-0">Hai, <?= htmlspecialchars($_SESSION['nama']); ?></h1>
                    </div>
                <?php endif; ?>

            </div>
            <div class="card">
                <div class="card-body">
                   
                    <a href="tambahvideo.php" class="btn btn-primary">Tambah Video</a>
                    <div class="table-responsive">
                        <table class="table table-striped" id="table">
                            <thead>
                         
                                <tr>
                                    <th>Url</th>
                             
                                   
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $conn = include "../koneksi.php";
                                $query = "SELECT * FROM video";
                                $reuslt = mysqli_query($conn, $query);
                                while ($data = mysqli_fetch_array($reuslt, MYSQLI_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?= $data['url'] ?></td>
                                 
                                  
                                    <td>
                                        <div class="col-auto">
                                            <form action="Controllers/hapus.php" method="post">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']); ?>">
                                                <input type="hidden" name="table" value="video">
                                                <a href="editvideo.php?id=<?=base64_encode($data['id'])?>" class="btn btn-success btn-sm">Edit</a>
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
<script src="../assets/js/jquery-3.7.1.min.js.js"></script>
<script src="../assets/js/datatables.min.js"></script>
<script>
    $("#table").dataTable()
</script>

</body>

</html>