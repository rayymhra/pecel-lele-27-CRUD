<?php

include "db.php";
include "function.php";

$menu = mysqli_query($conn, "SELECT * FROM menu");
$pesanan = mysqli_query($conn, "SELECT * FROM pesanan");
$testimoni = mysqli_query($conn, "SELECT * FROM testimoni");
$kontak = mysqli_query($conn, "SELECT * FROM kontak");



?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pecel Lele 27</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="assets/style.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary mx-5 rounded-pill mt-4 fixed-top shadow">
      <div class="container">
        <a class="navbar-brand" href="#"
          ><img src="assets/img/logo.png" alt=""
        /></a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#home"
                >Home</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#menu"
                >Menu</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#pesanan"
                >Pesanan</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#tentang"
                >Tentang</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#testimoni"
                >Testimoni</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#kontak"
                >Kontak</a
              >
            </li>
          </ul>
        </div>
        <a href="https://wa.me/6281299340490" target="_blank" class="btn btn-warning"
          ><i class="bi bi-whatsapp"></i> Whatsapp</a
        >
      </div>
    </nav>

    <div class="hero-section" id="home">
      <div class="container">
        <div
          class="hero-items d-flex justify-content-center align-items-center flex-column"
        >
          <h1 class="text-white">Masakan Rumah Lezat & Tradisional</h1>
          <p class="text-white">
            Cocok untuk makan sehari-hari & pesanan acara spesial
          </p>
        </div>
      </div>
    </div>

    <div class="menu-section my-5" id="menu">
      <div class="container">
        <h3 class="section-title">Menu Utama</h3>
        <p class="section-description">
          Menu andalan yang tersedia setiap hari
        </p>
        <div class="row mt-4">
          <?php foreach ($menu as $m):  ?>
          <div class="col-4">
            <div class="card">
              <div class="card-body">
                <img src="uploads/<?= $m["gambar"] ?>" alt="" class="w-100 rounded" />
                <h5><?= $m["nama"] ?></h5>
              </div>
            </div>
          </div>
          <?php endforeach ?>
          
        </div>
      </div>
    </div>

    <div class="pesanan-section my-5" id="pesanan">
      <div class="container">
        <h3 class="section-title">Terima Pesanan</h3>
        <p class="section-description">
          Custom menu untuk ulang tahun, selametan, syukuran, dsb.
        </p>

        <div class="row">
          <?php foreach ($pesanan as $p):  ?>
          <div class="col-4 pesanan-item">
            <div class="pesanan-item-card">
              <img src="uploads/<?= $p["gambar"] ?>" alt="" class="w-100" />
              <h5><?= $p["nama"] ?></h5>
            </div>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>

    <div class="tentang-section my-5" id="tentang">
      <div class="container">
        <h3 class="section-title">Tentang Kami</h3>
        <div class="row tentang">
          <div class="col-5">
            <img src="assets/img/mama.jpg" alt="" class="w-100 rounded" />
          </div>
          <div class="col-7">
            <p class="mt-5">
              Mama Rayya memulai usaha masakan rumahan ini sejak 2015. Berawal
              dari dapur sederhana di Perumahan Puri Harmoni 9, ia memasak untuk
              sekitar perumahan.
            </p>
            <p>
              Dengan bahan segar, resep tradisional, dan cinta dalam setiap
              masakan, usaha ini berkembang hingga kini menerima pesanan untuk
              acara besar seperti ulang tahun, selametan, dan tumpengan.
            </p>
            <p>
              Kami percaya bahwa makanan yang enak bukan hanya soal rasa, tapi
              juga tentang niat baik di baliknya. Itulah yang membuat setiap
              pesanan istimewa.
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="testimoni-section" id="testimoni">
      <div class="container">
        <h3 class="section-title">Testimoni</h3>
        <!-- <div
          id="carouselExampleAutoplaying"
          class="carousel slide m-4"
          data-bs-ride="carousel"
        >
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img
                src="assets/img/1001049651.png"
                class="d-block w-100"
                alt="..."
              />
            </div>
            <div class="carousel-item">
              <img
                src="assets/img/1001049652.png"
                class="d-block w-100"
                alt="..."
              />
            </div>
            <div class="carousel-item">
              <img
                src="assets/img/1001049658.jpg"
                class="d-block w-100"
                alt="..."
              />
            </div>
          </div>
          <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="prev"
          >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="next"
          >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div> -->

        <div class="row g-4 mt-4 testimonials">
          <?php foreach ($testimoni as $t):  ?>
          <div class="col-md-4">
            <div class="p-3 shadow rounded bg-white card">
              <p>"<?= $t["isi"] ?>"</p>
              <small class="text-muted">— <?= $t["nama"] ?></small>
            </div>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>

    <div class="kontak-section my-5" id="kontak">
      <div class="container">
        <h3 class="section-title">Hubungi Kami</h3>
        <div class="row mt-4">
          <div class="col-md-6 mb-4">
            
            <!-- <iframe 
              src="https://www.google.com/maps/embed?pb=https://g.co/kgs/dwdpRZe" 
              width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe> -->
            <div style="position: relative;"><div style="position: relative; padding-bottom: 75%; height: 0; overflow: hidden;"><iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;" loading="lazy" allowfullscreen src="https://maps.google.com/maps?q=Puri+Harmoni+9+Ext%2C+Blk.+A10+No.27%2C+Cikahuripan%2C+Kec.+Klapanunggal%2C+Kabupaten+Bogor%2C+Jawa+Barat+16710&output=embed"></iframe></div><a href="https://mapembeds.com" rel="noopener" target="_blank" style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;">mapembeds.com</a></div>
          </div>
          <?php foreach ($kontak as $k):  ?>
          <div class="col-md-6">
            <h5>Kontak</h5>
            <p><strong>WhatsApp:</strong></p>
            <a href="https://wa.me/6281299340490" target="_blank" class="btn btn-warning"> <i class="bi bi-whatsapp"></i>
               Chat via WhatsApp
            </a> 
            <div class="mt-3">
              <strong class="mt-3">Lokasi</strong>
            </div>
            
            <p><?= $k["lokasi"] ?></p>
            <p class="mt-3"><strong>Jam Buka:</strong><br><?= $k["jam_buka"] ?></p>
            <p><strong>Catatan:</strong><br><?= $k["catatan"] ?></p>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>

    <footer>
      <div class="text-center py-3 mt-5">
        Copyright &copy; 2025 | Made with love by Rayya Mahira
      </div>
    </footer>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
