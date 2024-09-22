<?php

include "Components/HeaderComponent.php";
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.replace('login.php');</script>";
    exit();
}
$conn = include "koneksi.php";
?>
    <div class="container my-5">
        <div class="row">
            <?php
                $query = "SELECT * FROM objek_wisata";
                $result = mysqli_query($conn, $query);
                while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="IMG/<?= $data['gambar'] ?>" class="card-img-top" alt="<?= $data['nama'] ?>" onerror="this.onerror=null; this.src='IMG/default.jpg';">
                    <div class="card-body">
                        <h5 class="card-title"><?= $data['nama'] ?></h5>
                        <p class="card-text"><?= $data['deskripsi'] ?></p>
                        <a href="#" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
<?php
include "Components/FooterComponent.php";
?>