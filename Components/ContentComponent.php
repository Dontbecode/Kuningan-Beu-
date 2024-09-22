

<div class="container my-5">
        <div class="row">
            <div class="col-md-2"><hr class="my-4 w-1000 d-md-block d-none" style="height: 5px;"></div>
            <div class="col-md-8">
               <h2 class="text-center mb-4">Objek Wisata Di Kuningan</h2>
            </div>
            <div class="col-md-2"><hr class="my-4 w-1000 d-md-block d-none" style="height: 5px;"></div>
        </div>
        <div id="largeCarousel" class="carousel slide large-carousel my-5" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $conn = include "koneksi.php";
                $query = "SELECT * FROM gallery";
                $result = mysqli_query($conn, $query);
                $i = 0;
                while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $i++;
                ?>
                <div class="carousel-item <?= $i == 1 ? 'active' : '' ?>">
                    <img src="IMG/<?= $data['gambar'] ?>" class="d-block w-100" alt="<?= $data['deskripsi'] ?>" style="height: 500px;">
                </div>
                <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#largeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#largeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="row">
            <div class="col-md-2"><hr class="my-4 w-1000 d-md-block d-none" style="height: 5px;"></div>
            <div class="col-md-8">
               <h2 class="text-center mb-4">Gallery & Dokumentasi Tempat Camping di Palutungan</h2>
            </div>
            <div class="col-md-2"><hr class="my-4 w-1000 d-md-block d-none" style="height: 5px;"></div>
        </div>

        <div class="container">
        <div class="row">
            <div class="col-md-2"><hr class="my-4 w-1000 d-md-block d-none" style="height: 5px;"></div>
            <div class="col-md-8">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Cari Obyek Wisata" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Cari</button>
                </form>
            </div>
            <div class="col-md-2"><hr class="my-4 w-1000 d-md-block d-none" style="height: 5px;"></div>
        </div>
        </div>
    

        <div class="row justify-content-center mt-4">
            <?php
                $conn = include "koneksi.php";
                $query = "SELECT * FROM gallery";
                $result = mysqli_query($conn, $query);
                while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            ?>
            <div class="col-md-4 col-6 mb-3">
                <section id="image">
                    <img src="IMG/<?= $data['gambar'] ?>" class="img-fluid rounded" alt="<?= $data['deskripsi'] ?>" style="width: 100%; height: 200px; object-fit: cover;">
                </section>
            </div>
            <?php } ?>
        </div>

        <div class="row justify-content-center">
            <?php
                $conn = include "koneksi.php";
                $query = "SELECT * FROM video";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    echo "<p>Error executing query: " . mysqli_error($conn) . "</p>";
                    exit();
                }

                while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    // Extract video ID from URL
                    preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+?v=))([a-zA-Z0-9_-]{11})/', $data['url'], $matches);
                    $videoId = $matches[1] ?? '';

                    // Create embed URL
                    $embedUrl = "https://www.youtube.com/embed/{$videoId}";
            ?>
            <div class="col-md-4 col-6 mb-3">
                <iframe width="100%" height="200" src="<?= htmlspecialchars($embedUrl) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <?php } ?>
        </div>


        <div class="row">
            <div class="col-md-2"><hr class="my-4 w-1000 d-md-block d-none" style="height: 5px;"></div>
            <div class="col-md-8">
               <h2 class="text-center mb-4">Jenis Paket Camping di Palutungan</h2>
            </div>
            <div class="col-md-2"><hr class="my-4 w-1000 d-md-block d-none" style="height: 5px;"></div>
        </div>

        <div class="row">
            <?php
                $conn = include "koneksi.php";
                $query = "SELECT *, (SELECT nama FROM objek_wisata WHERE id=paket_camping.obyek_wisata_id) AS objek_wisata FROM paket_camping";
                $result = mysqli_query($conn, $query);
                while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            ?>
            <div class="col-md-4">
                <div class="card">
                <img src="IMG/<?= $data['gambar'] ?>" class="img-fluid rounded" style="width: 100%; height: 200px; object-fit: cover;" onerror="this.onerror=null; this.src='IMG/default.jpg';">
                    <div class="card-body">
                        <h5 class="card-title"><?= $data['paket_camping'] ?></h5>
                        <p class="card-text">Obyek Wisata: <?= $data['objek_wisata'] ?></p>
                        <p class="card-text">Harga Paket: Rp <?= number_format($data['harga_paket'], 0, ',', '.') ?></p>
                        <p class="card-text">Area Camping: <?= $data['area_camping'] ?></p>
                        <p class="card-text">Kapasitas: <?= $data['kapasitas'] ?> orang</p>
                        <p class="card-text">Bonus Peralatan: <?= $data['bonus_peralatan'] ?></p>
                        <p class="card-text">Diskon: <?= $data['diskon'] ?>%</p>
                        <a href="PemesananCamp.php" class="btn btn-primary">Pesan Sekarang !</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
          
        </div>

        <div class="row">
        <section id="tentang-kami" class="py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                    <div class="row">
                        <div class="col-md-2"><hr class="my-4 w-1000 d-md-block d-none" style="height: 5px;"></div>
                        <div class="col-md-8">
                             <h2 class="text-center mb-4">Tentang Kami</h2>
                        </div>
                        <div class="col-md-2"><hr class="my-4 w-1000 d-md-block d-none" style="height: 5px;"></div>
                    </div>
                        <p class="lead mb-4">
                            Kami adalah perusahaan yang berdedikasi untuk memberikan solusi terbaik bagi pelanggan kami. Dengan pengalaman bertahun-tahun di industri ini, kami telah membangun reputasi sebagai penyedia layanan yang handal dan terpercaya.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                       
                        <h4>Visi Kami</h4>
                        <p>Menjadi tujuan utama bagi mereka yang mencari pengalaman perkemahan yang unik dan berkesan.</p>
                    </div>
                    <div class="col-md-4 text-center mb-4">
                       
                        <h4>Misi Kami</h4>
                        <p>Menawarkan pengalaman perkemahan yang luar biasa dengan fasilitas dan pelayanan yang prima.</p>
                    </div>
                    <div class="col-md-4 text-center mb-4">
                     
                        <h4>Nilai Kami</h4>
                        <p>Komitmen, kejujuran, dan kesadaran lingkungan adalah nilai-nilai yang kami pegang teguh.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="kontak" class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                    <div class="row">
                        <div class="col-md-2"><hr class="my-4 w-1000 d-md-block d-none" style="height: 5px;"></div>
                        <div class="col-md-8">
                             <h2 class="text-center mb-4">Hubungi Kami</h2>
                        </div>
                        <div class="col-md-2"><hr class="my-4 w-1000 d-md-block d-none" style="height: 5px;"></div>
                    </div>
                        <p class="mb-4">Jika Anda memiliki pertanyaan atau membutuhkan informasi lebih lanjut, jangan ragu untuk menghubungi kami melalui formulir di bawah ini.</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form>
                            <div class="form-group mb-3">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" placeholder="Masukkan Nama Anda">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Masukkan Email Anda">
                            </div>
                            <div class="form-group mb-3">
                                <label for="message">Pesan</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="Tulis pesan Anda di sini"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        </div>
    </div>