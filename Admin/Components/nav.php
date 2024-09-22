<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo (str_contains($_SERVER['REQUEST_URI'], "index.php") || str_contains($_SERVER['REQUEST_URI'], "editPemesanan.php")) ? "active" : "" ?> "" aria-current="page" href="Dashboard.php" onclick="setActive(this)">
                    <i class="bi bi-house-fill"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (str_contains($_SERVER['REQUEST_URI'], "ObjekWisata.php")) ? "active" : "" ?> " href="ObjekWisata.php" onclick="setActive(this)">
                    <i class="bi bi-backpack-fill"></i>
                    Objek Wisata
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (str_contains($_SERVER['REQUEST_URI'], "FasilitasCamp.php")) ? "active" : "" ?> "  href="FasilitasCamp.php" onclick="setActive(this)">
                    <i class="bi bi-building-fill"></i>
                    Fasilitas Camping
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (str_contains($_SERVER['REQUEST_URI'], "PaketCamp.php")) ? "active" : "" ?> " " href="PaketCamp.php" onclick="setActive(this)">
                    <i class="bi bi-box-fill"></i>
                    Paket Camping
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (str_contains($_SERVER['REQUEST_URI'], "Gallery.php")) ? "active" : "" ?> " " href="Gallery.php" onclick="setActive(this)">
                    <i class="bi bi-images"></i>
                    Galeri
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (str_contains($_SERVER['REQUEST_URI'], "Video.php")) ? "active" : "" ?> " " href="Video.php" onclick="setActive(this)">
                    <i class="bi bi-camera-video-fill"></i>
                    Video
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
    function setActive(element) {
        var links = document.querySelectorAll('.nav-link');
        links.forEach(function(link) {
            link.classList.remove('active');
        });
        element.classList.add('active');
    }
</script>