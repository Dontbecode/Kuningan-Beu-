<?php

include "Components/HeaderComponent.php";
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.replace('login.php');</script>";
    exit();
}
$conn = include "koneksi.php";

// Fetch user data from session
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id']; // Assuming you have user_id stored in session
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
        . $_SESSION['success_message'] .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
        . $_SESSION['error_message'] .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    unset($_SESSION['error_message']);
}
?>
<!-- Alert Pemesanan Berhasil -->
<div class="alert alert-success d-none" role="alert" id="successAlert">
    <strong>Pemesanan berhasil!</strong> Pemesanan Anda telah berhasil dilakukan.
</div>

<section class="py-5">
    <div class="container">
        <div class="card">
            <?php include "../Camp-Palutungan/Components/alert.php"; ?>
            <div class="card-header text-center">
                <h2>Pemesanan Paket Camping</h2>
            </div>
            <div class="card-body">
                <form id="formPemesanan" action="Controllers/simpanpesanan.php" method="post">
                    <div class="row mb-3">
                        <label for="noPemesanan" class="col-sm-4 col-form-label">No Pemesanan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="noPemesanan" name="no_pemesanan" value="<?php echo uniqid(); ?>" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="namaPemesanan" class="col-sm-4 col-form-label">Nama Pemesanan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="namaPemesanan" name="nama" value="<?php echo $_SESSION['nama']; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="noTelepon" class="col-sm-4 col-form-label">No Telepon</label>
                        <div class="col-sm-8">
                            <input type="tel" class="form-control" id="noTelepon" name="no_hp" placeholder="Masukkan No Telepon Anda" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="paketCamping" class="col-sm-4 col-form-label">Paket Camping</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="paketCamping" name="paket_camping_id" required onchange="getPaketDetails(this.value)">
                                <option selected>-- Pilih Paket Camping --</option>
                                <?php
                                $query = "SELECT id, paket_camping FROM paket_camping";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['paket_camping']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tanggalCamping" class="col-sm-4 col-form-label">Tanggal Camping</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="tanggalCamping" name="tanggal" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="durasiCamping" class="col-sm-4 col-form-label">Durasi Camping (Hari)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="durasiCamping" name="durasi" value="1" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="jumlahPeserta" class="col-sm-4 col-form-label">Jumlah Peserta</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="jumlahPeserta" name="jml_peserta" value="1" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="diskon" class="col-sm-4 col-form-label">Diskon (%)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="diskon" name="diskon" value="0" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Pelayanan Tambahan</label>
                        <div class="col-sm-8">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tambahanTenda" name="fasilitas[]" value="penginapan">
                                <label class="form-check-label" for="tambahanTenda">Tenda</label>
                                <select class="form-select mt-2" id="pilihTenda" name="pilihTenda" disabled>
                                    <option selected>-- Pilih Tenda --</option>
                                    <option value="2orang">Tenda 2 Orang</option>
                                    <option value="4orang">Tenda 4 Orang</option>
                                    <option value="6orang">Tenda 6 Orang</option>
                                </select>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="tambahanMakanan" name="fasilitas[]" value="makan">
                                <label class="form-check-label" for="tambahanMakanan">Makanan</label>
                                <select class="form-select mt-2" id="pilihMakanan" name="pilihMakanan" disabled>
                                    <option selected>-- Pilih Paket Makanan --</option>
                                    <option value="makanan">Makanan</option>
                                    <option value="bbq">Makanan + BBQ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="hargaPaket" class="col-sm-4 col-form-label">Harga Paket Camping</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="hargaPaket" name="harga_paket" value="0" readonly >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="totalTagihan" class="col-sm-4 col-form-label">Total Tagihan</label>
                        <div class="col-sm-8">
                        
                            <input type="text" class="form-control" id="totalTagihan" name="total_tagihan" value="0"  readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="status" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" id="status" name="status" value="Belum di proses">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="float-start"><a href="LihatPesanan.php" class="btn btn-primary">Lihat Pesanan</a></div>
                        <div>
                            <button type="button" class="btn btn-danger">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Modal Rincian Pemesanan -->
<div class="modal fade" id="rincianModal" tabindex="-1" aria-labelledby="rincianModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rincianModalLabel">Rincian Pemesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Rincian pemesanan akan dimasukkan di sini melalui JavaScript -->
                <ul class="list-group">
                    <li class="list-group-item"><strong>No Pemesanan:</strong> <span id="rincianNoPemesanan"></span></li>
                    <li class="list-group-item"><strong>Nama Pemesanan:</strong> <span id="rincianNamaPemesanan"></span></li>
                    <li class="list-group-item"><strong>No Telepon:</strong> <span id="rincianNoTelepon"></span></li>
                    <li class="list-group-item"><strong>Paket Camping:</strong> <span id="rincianPaketCamping"></span></li>
                    <li class="list-group-item"><strong>Tanggal Camping:</strong> <span id="rincianTanggalCamping"></span></li>
                    <li class="list-group-item"><strong>Durasi Camping:</strong> <span id="rincianDurasiCamping"></span> hari</li>
                    <li class="list-group-item"><strong>Jumlah Peserta:</strong> <span id="rincianJumlahPeserta"></span> orang</li>
                    <li class="list-group-item"><strong>Diskon:</strong> <span id="rincianDiskon"></span>%</li>
                    <li class="list-group-item"><strong>Tambahan Tenda:</strong> <span id="rincianTambahanTenda"></span></li>
                    <li class="list-group-item"><strong>Tambahan Makanan:</strong> <span id="rincianTambahanMakanan"></span></li>
                    <li class="list-group-item"><strong>Total Tagihan:</strong> <span id="rincianTotalTagihan"></span></li>
                    <li class="list-group-item"><strong>Status:</strong> <span id="rincianStatus"></span></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" id="konfirmasiPesananBtn">Konfirmasi Pemesanan</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Pastikan jQuery dimuat -->

<script>
    $(document).ready(function() {
        $("#paketCamping").change(function() {
            let id = $(this).val();
            $.ajax({
                url: "Controllers/paketCamping.php",
                type: "post",
                dataType: "json",
                data: {
                    paket_id: id  // Pastikan parameter sesuai dengan yang diharapkan server
                },
                success: function(data) {
                    let hargaPaket = parseFloat(data.harga_paket) || 0; // Pastikan hargaPaket adalah float
                    let diskon = parseFloat(data.diskon) || 0; // Pastikan diskon adalah float
                    $("#diskon").val(diskon);
                    $("#hargaPaket").val("Rp. " + hargaPaket.toLocaleString('id-ID'));
                    
                    // Update totalTagihan dengan memperhitungkan diskon
                    let totalTagihan = hargaPaket - (hargaPaket * (diskon / 100));
                    $("#totalTagihan").val("Rp. " + totalTagihan.toLocaleString('id-ID'));
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>


<script>
document.querySelector('#tambahanTenda').addEventListener('change', function() {
    document.getElementById('pilihTenda').disabled = !this.checked;
});

document.querySelector('#tambahanMakanan').addEventListener('change', function() {
    document.getElementById('pilihMakanan').disabled = !this.checked;
});

document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting immediately

    // Get data from form inputs
    const noPemesanan = document.getElementById('noPemesanan').value;
    const namaPemesanan = document.getElementById('namaPemesanan').value;
    const noTelepon = document.getElementById('noTelepon').value;
    const paketCamping = document.getElementById('paketCamping').options[document.getElementById('paketCamping').selectedIndex].text;
    const tanggalCamping = document.getElementById('tanggalCamping').value;
    const durasiCamping = document.getElementById('durasiCamping').value;
    const jumlahPeserta = document.getElementById('jumlahPeserta').value;
    const diskon = document.getElementById('diskon').value;
    const tambahanTenda = document.getElementById('tambahanTenda').checked ? document.getElementById('pilihTenda').options[document.getElementById('pilihTenda').selectedIndex].text : "Tidak ada";
    const tambahanMakanan = document.getElementById('tambahanMakanan').checked ? document.getElementById('pilihMakanan').options[document.getElementById('pilihMakanan').selectedIndex].text : "Tidak ada";
    const totalTagihan = document.getElementById('totalTagihan').value;
    const status = document.getElementById('status').value;

    // Set data into modal
    document.getElementById('rincianNoPemesanan').textContent = noPemesanan;
    document.getElementById('rincianNamaPemesanan').textContent = namaPemesanan;
    document.getElementById('rincianNoTelepon').textContent = noTelepon;
    document.getElementById('rincianPaketCamping').textContent = paketCamping;
    document.getElementById('rincianTanggalCamping').textContent = tanggalCamping;
    document.getElementById('rincianDurasiCamping').textContent = durasiCamping;
    document.getElementById('rincianJumlahPeserta').textContent = jumlahPeserta;
    document.getElementById('rincianDiskon').textContent = diskon;
    document.getElementById('rincianTambahanTenda').textContent = tambahanTenda;
    document.getElementById('rincianTambahanMakanan').textContent = tambahanMakanan;
    document.getElementById('rincianTotalTagihan').textContent = totalTagihan;
    document.getElementById('rincianStatus').textContent = status;

    // Show the modal
    var rincianModal = new bootstrap.Modal(document.getElementById('rincianModal'));
    rincianModal.show();

    // Handle the confirm button in the modal
    document.getElementById('konfirmasiPesananBtn').addEventListener('click', function() {
        document.getElementById('formPemesanan').submit();
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Event listener for Paket Camping selection
    document.getElementById('paketCamping').addEventListener('change', function() {
        let id = this.value;
        if (id) {
            fetch('Controllers/paketCamping.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ obyek_wisata_id: id })
            })
            .then(response => response.json())
            .then(data => {
                // Update input fields with data from the server
                document.getElementById('diskon').value = data.diskon || 0;
                document.getElementById('hargaPaket').value = "Rp. " + parseFloat(data.harga_paket).toLocaleString('id-ID');
                
                // Recalculate total price
                calculateTotalPrice();
            })
            .catch(error => console.error('Error fetching paket details:', error));
        }
    });

    // Function to calculate total price
    function calculateTotalPrice() {
        let totalHarga = 0;
        const hargaTenda = {
            "2orang": 200000,
            "4orang": 350000,
            "6orang": 500000
        };

        const hargaMakanan = {
            "makanan": 100000,
            "bbq": 150000
        };

        const durasiCamping = parseInt(document.getElementById('durasiCamping').value) || 1;
        const jumlahPeserta = parseInt(document.getElementById('jumlahPeserta').value) || 1;
        const diskon = parseInt(document.getElementById('diskon').value) || 0;

        // Calculate Tenda price
        const pilihTenda = document.getElementById('pilihTenda').value;
        if (document.getElementById('tambahanTenda').checked && pilihTenda) {
            totalHarga += hargaTenda[pilihTenda];
        }

        // Calculate Makanan price
        const pilihMakanan = document.getElementById('pilihMakanan').value;
        if (document.getElementById('tambahanMakanan').checked && pilihMakanan) {
            totalHarga += hargaMakanan[pilihMakanan] * jumlahPeserta;
        }

        // Calculate Paket price
        const hargaPaket = parseFloat(document.getElementById('hargaPaket').value.replace('Rp. ', '').replace('.', '')) || 0;
        totalHarga += hargaPaket * durasiCamping * jumlahPeserta;

        // Apply discount
        const totalTagihan = totalHarga - (totalHarga * (diskon / 100));

        // Update total tagihan
        document.getElementById('totalTagihan').value = "Rp. " + totalTagihan.toLocaleString('id-ID');
    }

    // Event listeners for Tenda and Makanan options
    document.getElementById('tambahanTenda').addEventListener('change', function() {
        document.getElementById('pilihTenda').disabled = !this.checked;
        calculateTotalPrice();
    });

    document.getElementById('pilihTenda').addEventListener('change', calculateTotalPrice);

    document.getElementById('tambahanMakanan').addEventListener('change', function() {
        document.getElementById('pilihMakanan').disabled = !this.checked;
        calculateTotalPrice();
    });

    document.getElementById('pilihMakanan').addEventListener('change', calculateTotalPrice);

    document.getElementById('durasiCamping').addEventListener('change', calculateTotalPrice);
    document.getElementById('jumlahPeserta').addEventListener('change', calculateTotalPrice);
});

</script>

<?php include "Components/FooterComponent.php"; ?>
