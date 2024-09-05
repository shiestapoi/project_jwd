<?php
// Include file koneksi database
include 'middleware/mysql.php';

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dan lakukan sanitasi
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Query untuk membuat tabel jika belum ada
    $sql = "CREATE TABLE IF NOT EXISTS contactme (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        subject VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    // Eksekusi query pembuatan tabel
    if ($conn->query($sql) === TRUE) {
        // Persiapkan statement untuk insert data
        $stmt = $conn->prepare("INSERT INTO contactme (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        
        // Eksekusi statement
        if ($stmt->execute()) {
            // Redirect jika berhasil
            header("Location: /?success=true");
        } else {
            // Redirect jika gagal
            header("Location: /?success=false");
        }
        $stmt->close();
    } else {
        // Tampilkan pesan error jika gagal membuat tabel
        echo "<script>alert('Gagal membuat tabel. Silakan coba lagi.');</script>";
    }

    // Tutup koneksi database
    $conn->close();
}

// Cek status pengiriman pesan
if (isset($_GET['success'])) {
    if ($_GET['success'] == 'true') {
        echo "<script>alert('Pesan Anda Telah Terkirim');</script>";
    } else {
        echo "<script>alert('Pesan Anda Gagal Terkirim');</script>";
    }
}

// Include file header
include 'components/header.php';
?>

<!-- Section Home -->
<div class="position-relative" id="home">
    <img src="assets/images/home.png" class="img-fluid" alt="Home Image">
    <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
        <h5 style="font-size: 20px; font-weight: 600;">Selamat Datang di Kuta Bali</h5>
        <h1 class="display-4" style="font-size: 65px; font-weight: bold;">The tourist destination</h1>
        <h1 class="display-4" style="font-size: 65px; font-weight: bold;">from Kuta Bali</h1>
        <p style="font-size: 20px; font-weight: 600;">Bring smile on your vacation</p>
    </div>
</div>

<!-- Section Introduce -->
<div class="container mt-5" id="introduce">
    <div class="row">
        <!-- Kolom kiri -->
        <div class="col-md-6 d-flex flex-column justify-content-between">
            <div>
                <h2 class="display-5" style="color: #ffff; font-weight: 600; font-size: 45px;">Cerita di Balik Kuta Bali
                </h2>
                <p style="color: rgba(255, 255, 255, 0.68); font-weight: 500; font-size: 18px;">Kuta, terletak di Bali,
                    Indonesia, adalah salah satu tujuan wisata paling terkenal di dunia. Pada awalnya, Kuta adalah
                    sebuah desa nelayan yang tenang. Namun, pada tahun 1970-an, Kuta mulai dikenal oleh para wisatawan
                    internasional sebagai surga bagi para peselancar. Seiring berjalannya waktu, Kuta berkembang pesat
                    dengan berbagai fasilitas modern, hotel, restoran, dan tempat hiburan malam. Meskipun telah
                    mengalami banyak perubahan, Kuta tetap mempertahankan pesona alaminya dengan pantai berpasir putih
                    dan ombak yang menantang.</p>
            </div>
            <img src="assets/images/gallery1.png" class="img-fluid mt-4 rounded-3" alt="Cerita di Balik Kutawave">
        </div>
        <!-- Kolom kanan -->
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
            <img src="assets/images/gallery2.png" class="img-fluid rounded-3"
                alt="Kami Menemukan Permata Tersembunyi dari Kuta">
            <div class="mt-4">
                <h2 class="display-5 fw-bold" style="color: #ffff; font-weight: 600; font-size: 45px;">Kami Menemukan
                    Permata Tersembunyi dari Kuta</h2>
                <p style="color: rgba(255, 255, 255, 0.68); font-weight: 500; font-size: 18px;">Temukan keindahan
                    tersembunyi
                    di Kuta Bali. Kami menyediakan pilihan terbaik dari kuliner lokal yang lezat,
                    akomodasi yang nyaman, dan suasana Bali yang autentik yang akan membuat Anda merasakan esensi sejati
                    pulau ini.</p>
            </div>
        </div>
    </div>

    <!-- Section Video Preview -->
    <div class="row mt-5">
        <div class="col-12">
            <h1 class="display-4 text-center" style="color: #ffff; font-size: 45px; font-weight: 600;">Video Preview
            </h1>
            <p style="color: rgba(255, 255, 255, 0.68); font-weight: 500; font-size: 18px;">Nikmati video singkat
                tentang keindahan Pantai Kuta dan aktivitas seru yang bisa Anda lakukan di sana. Dalam video ini, Anda
                akan melihat pemandangan matahari terbenam yang menakjubkan, ombak yang sempurna untuk berselancar, dan
                berbagai kegiatan pantai yang menyenangkan. Jangan lewatkan kesempatan untuk merasakan keindahan dan
                kegembiraan yang ditawarkan oleh Pantai Kuta melalui video ini.</p>
            <div class="d-flex flex-column align-items-center">
                <!-- Video 1 -->
                <iframe width="640" height="360" src="https://www.youtube.com/embed/k9BbEAfVg38?si=mDIabLcK2WcXs0aa"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen class="mb-4"></iframe>
                <!-- Video 2 -->
                <iframe width="640" height="360" src="https://www.youtube.com/embed/iAYmXWO3SJ0?si=Ei0FYfEPeiKLswYb"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- Section Destinasi Spiritual -->
    <div class="row mt-5">
        <div class="col-12">
            <h1 class="display-4 text-center" style="color: #ffff; font-size: 45px; font-weight: 600;">Destinasi
                Spiritual</h1>
            <p style="color: rgba(255, 255, 255, 0.68); font-weight: 500; font-size: 18px;">Bali, terutama di dalam dan
                sekitar Kuta, menawarkan banyak destinasi spiritual Hindu yang dapat diakses oleh publik. Situs-situs
                suci ini memberikan kesempatan unik bagi pengunjung untuk meresapi kekayaan budaya dan warisan spiritual
                pulau ini. Jelajahi kuil-kuil kuno, ikuti upacara tradisional, dan rasakan keindahan tenang dari lanskap
                spiritual Bali, sambil menemukan hubungan mendalam pulau ini dengan tradisi Hindu-nya.</p>
        </div>
    </div>
    <!-- Galeri Destinasi Spiritual -->
    <div class="row">
        <div class="col-md-4">
            <img src="assets/images/gallery4.png" class="img-fluid mt-4 rounded-3" alt="Spiritual Destination Image 1">
        </div>
        <div class="col-md-4">
            <img src="assets/images/gallery5.png" class="img-fluid mt-4 rounded-3" alt="Spiritual Destination Image 2">
        </div>
        <div class="col-md-4">
            <img src="assets/images/gallery6.png" class="img-fluid mt-4 rounded-3" alt="Spiritual Destination Image 3">
        </div>
    </div>

    <!-- Section Kuta for Bali -->
    <div class="row mt-5">
        <div class="col-12">
            <h1 class="display-4 text-center" style="color: #ffff; font-size: 45px; font-weight: 600;">Kuta for Bali
            </h1>
            <p class="text-center" style="color: rgba(255, 255, 255, 0.68); font-weight: 500; font-size: 18px;">Temukan
                Cerita Tersembunyi
                di Balik Setiap Destinasi.</p>
        </div>
    </div>
    <!-- Galeri Kuta for Bali -->
    <div class="row">
        <div class="col-md-4">
            <img src="assets/images/gallery7.png" class="img-fluid mt-4 rounded-3" alt="Kuta for Bali Image 1">
        </div>
        <div class="col-md-4">
            <img src="assets/images/gallery8.png" class="img-fluid mt-4 rounded-3" alt="Kuta for Bali Image 2">
        </div>
        <div class="col-md-4">
            <img src="assets/images/gallery9.png" class="img-fluid mt-4 rounded-3" alt="Kuta for Bali Image 3">
        </div>
        <div class="col-md-4">
            <img src="assets/images/gallery10.png" class="img-fluid mt-4 rounded-3" alt="Kuta for Bali Image 4">
        </div>
        <div class="col-md-4">
            <img src="assets/images/gallery11.png" class="img-fluid mt-4 rounded-3" alt="Kuta for Bali Image 5">
        </div>
        <div class="col-md-4">
            <img src="assets/images/gallery12.png" class="img-fluid mt-4 rounded-3" alt="Kuta for Bali Image 6">
        </div>
    </div>
</div>

<!-- Section Fasilitas -->
<div class="mt-5 mb-5 bg-white" id="facilities">
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 mt-3">
                <h1 class="display-4 text-center" style="color: #1E1E1E; font-size: 45px; font-weight: 600;">
                    Fasilitas
                </h1>
                <p class="text-center" style="color: rgba(30, 30, 30, 0.68); font-weight: 500; font-size: 18px;">
                    Nikmati berbagai fasilitas yang kami sediakan untuk kenyamanan Anda.
                </p>
            </div>
        </div>
        <!-- Baris pertama fasilitas -->
        <div class="row justify-content-center text-center mt-4">
            <!-- Wi-Fi -->
            <div class="col-md-1 mx-3">
                <div class="icon-box text-center ">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#00AEEF" class="bi bi-wifi"
                            viewBox="0 0 16 16">
                            <path
                                d="M15.384 6.115a.485.485 0 0 0-.047-.736A12.44 12.44 0 0 0 8 3C5.259 3 2.723 3.882.663 5.379a.485.485 0 0 0-.048.736.52.52 0 0 0 .668.05A11.45 11.45 0 0 1 8 4c2.507 0 4.827.802 6.716 2.164.205.148.49.13.668-.049" />
                            <path
                                d="M13.229 8.271a.482.482 0 0 0-.063-.745A9.46 9.46 0 0 0 8 6c-1.905 0-3.68.56-5.166 1.526a.48.48 0 0 0-.063.745.525.525 0 0 0 .652.065A8.46 8.46 0 0 1 8 7a8.46 8.46 0 0 1 4.576 1.336c.206.132.48.108.653-.065m-2.183 2.183c.226-.226.185-.605-.1-.75A6.5 6.5 0 0 0 8 9c-1.06 0-2.062.254-2.946.704-.285.145-.326.524-.1.75l.015.015c.16.16.407.19.611.09A5.5 5.5 0 0 1 8 10c.868 0 1.69.201 2.42.56.203.1.45.07.61-.091zM9.06 12.44c.196-.196.198-.52-.04-.66A2 2 0 0 0 8 11.5a2 2 0 0 0-1.02.28c-.238.14-.236.464-.04.66l.706.706a.5.5 0 0 0 .707 0l.707-.707z" />
                        </svg>
                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">
                        Wi-Fi</p>
                </div>
            </div>

            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"
                            width="32" height="32" fill="#00AEEF">
                            <path
                                d="M23.729,22.314a1,1,0,0,1-1.458,1.371l-5.483-5.839c-1.036.033-5.807.175-4.312-2.08a.985.985,0,0,1,.981-.254,8.055,8.055,0,0,0,3.458.29,1.259,1.259,0,0,1,1.09.4ZM15,14a4.99,4.99,0,0,0,3.536-1.462l5.171-5.172A1,1,0,1,0,22.293,5.95l-5.171,5.172a3,3,0,0,1-3.406.576l6.991-6.991a1,1,0,1,0-1.414-1.414L12.3,10.284a3,3,0,0,1,.576-3.406L18.05,1.707A1,1,0,0,0,16.636.293L11.464,5.464a5.01,5.01,0,0,0-.635,6.293L.293,22.293a1,1,0,0,0,1.414,1.414L12.243,13.171A5,5,0,0,0,15,14ZM5.452,12.965c.829.781,1.594-.256,2.151-.811a2,2,0,0,0,.539-1.8c-.617-1.722.891-3.732-.357-5.117L3.329.573A1.962,1.962,0,0,0,0,1.952C.237,6.566,1.935,8.92,5.452,12.965Z" />
                        </svg>

                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">Makanan</p>
                </div>
            </div>

            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#00AEEF"
                            fill="currentColor" class="bi bi-tv" viewBox="0 0 16 16">
                            <path
                                d="M2.5 13.5A.5.5 0 0 1 3 13h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5M13.991 3l.024.001a1.5 1.5 0 0 1 .538.143.76.76 0 0 1 .302.254c.067.1.145.277.145.602v5.991l-.001.024a1.5 1.5 0 0 1-.143.538.76.76 0 0 1-.254.302c-.1.067-.277.145-.602.145H2.009l-.024-.001a1.5 1.5 0 0 1-.538-.143.76.76 0 0 1-.302-.254C1.078 10.502 1 10.325 1 10V4.009l.001-.024a1.5 1.5 0 0 1 .143-.538.76.76 0 0 1 .254-.302C1.498 3.078 1.675 3 2 3zM14 2H2C0 2 0 4 0 4v6c0 2 2 2 2 2h12c2 0 2-2 2-2V4c0-2-2-2-2-2" />
                        </svg>
                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">TV</p>
                </div>
            </div>
            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#00AEEF"
                            fill="currentColor" class="bi bi-p-square-fill" viewBox="0 0 16 16">
                            <path d="M8.27 8.074c.893 0 1.419-.545 1.419-1.488s-.526-1.482-1.42-1.482H6.778v2.97z" />
                            <path
                                d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.5 4.002h2.962C10.045 4.002 11 5.104 11 6.586c0 1.494-.967 2.578-2.55 2.578H6.784V12H5.5z" />
                        </svg>
                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">Parkir</p>
                </div>
            </div>
            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#00AEEF"
                            viewBox="0 0 24 24">
                            <path
                                d="m19,0H5c-1.654,0-3,1.346-3,3v21h20V3c0-1.654-1.346-3-3-3Zm-7.5,3c.828,0,1.5.672,1.5,1.5s-.672,1.5-1.5,1.5-1.5-.672-1.5-1.5.672-1.5,1.5-1.5Zm-6.5,1.5c0-.828.672-1.5,1.5-1.5s1.5.672,1.5,1.5-.672,1.5-1.5,1.5-1.5-.672-1.5-1.5Zm7,16.5c-3.309,0-6-2.691-6-6s2.691-6,6-6,6,2.691,6,6-2.691,6-6,6Zm4-6c0,2.206-1.794,4-4,4-1.859,0-3.411-1.28-3.858-3h2.858v-2h-2.858c.447-1.72,1.999-3,3.858-3,2.206,0,4,1.794,4,4Z" />
                        </svg>
                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">Laundry</p>
                </div>
            </div>
            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#00AEEF"
                            viewBox="0 0 24 24">
                            <path
                                d="M22.144,6.423c-.382-.455-.774-.901-1.174-1.336l.245-.247c.583-.589,.58-1.538-.009-2.122-.588-.583-1.538-.578-2.121,.009l-.228,.23c-.431-.402-.87-.794-1.314-1.173-1.3-1.109-3.188-1.033-4.388,.178l-2.603,2.624c-.343,.346-.387,.887-.104,1.283,.047,.065,.977,1.365,2.511,3.035l-4.029,4.063c-1.661-1.55-2.936-2.475-3-2.521-.399-.288-.947-.242-1.294,.106l-2.603,2.623c-1.195,1.206-1.27,3.099-.175,4.402,.382,.455,.774,.901,1.174,1.336l-.245,.247c-.583,.589-.58,1.538,.009,2.122,.292,.29,.674,.435,1.056,.435,.386,0,.772-.148,1.065-.443l.228-.23c.431,.402,.87,.794,1.314,1.173,.615,.524,1.361,.784,2.103,.784,.828,0,1.652-.323,2.286-.961l2.603-2.624c.343-.346,.387-.887,.104-1.283-.047-.065-.977-1.365-2.511-3.035l4.029-4.063c1.661,1.55,2.936,2.475,3,2.521,.176,.127,.381,.189,.584,.189,.259,0,.516-.101,.71-.296l2.603-2.623h0c1.195-1.206,1.27-3.099,.175-4.402Z" />
                        </svg>
                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">Gym</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center text-center mt-4">
            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#00AEEF"
                            viewBox="0 0 24 24">
                            <path
                                d="M17,5.5A2.5,2.5,0,1,1,19.5,8,2.5,2.5,0,0,1,17,5.5Zm5.332,14.99A1.991,1.991,0,0,1,21,21a2.253,2.253,0,0,1-2.058-1.333,1,1,0,0,0-1.884,0,2.255,2.255,0,0,1-4.116,0,1,1,0,0,0-1.884,0,2.255,2.255,0,0,1-4.116,0,1,1,0,0,0-1.884,0A2.253,2.253,0,0,1,3,21a1.991,1.991,0,0,1-1.332-.51A1,1,0,1,0,.332,21.977,3.981,3.981,0,0,0,3,23a4.375,4.375,0,0,0,3-1.225,4.286,4.286,0,0,0,6,0,4.286,4.286,0,0,0,6,0A4.375,4.375,0,0,0,21,23a3.981,3.981,0,0,0,2.668-1.023,1,1,0,1,0-1.336-1.487Zm-22-3.513A3.981,3.981,0,0,0,3,18a4.375,4.375,0,0,0,3-1.225,4.286,4.286,0,0,0,6,0,4.286,4.286,0,0,0,6,0A4.375,4.375,0,0,0,21,18a3.981,3.981,0,0,0,2.668-1.023,1,1,0,1,0-1.336-1.487A1.991,1.991,0,0,1,21,16a2.253,2.253,0,0,1-2.058-1.333,1,1,0,0,0-1.884,0,2.255,2.255,0,0,1-4.116,0,1,1,0,0,0-1.884,0,2.255,2.255,0,0,1-4.116,0,1,1,0,0,0-1.884,0A2.253,2.253,0,0,1,3,16a1.991,1.991,0,0,1-1.332-.51A1,1,0,1,0,.332,16.977Zm2.675-3.031a.465.465,0,0,0,.2-.087,3,3,0,0,1,5.594,0,.359.359,0,0,0,.406,0,3,3,0,0,1,5.594,0,.359.359,0,0,0,.406,0A3,3,0,0,1,18,11.942c.059,0,.118,0,.177.006l-6.162-8.86A4.949,4.949,0,0,0,7.909,1H3a.952.952,0,0,0-1,.942,1,1,0,0,0,1,1H7.909a3,3,0,0,1,2.463,1.287l.746.961L0,13.35A3,3,0,0,1,3.007,13.946Z" />
                        </svg>
                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">
                        Kolam Renang</p>
                </div>
            </div>

            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#00AEEF"
                            viewBox="0 0 24 24">
                            <path
                                d="M23.3,22.571l-4.458,1.384a1,1,0,0,1-.594-1.91l1.244-.386-.918-2.7a4.917,4.917,0,0,1-.581.04,5,5,0,0,1-4.807-3.661l-.127-.375,1-2.965H22.6l.2.607a4.953,4.953,0,0,1-2.333,5.721l.931,2.737,1.3-.4a1,1,0,0,1,.594,1.91ZM14.656,10h7.267l-.966-2.868A3.023,3.023,0,0,0,17.28,5.11l-3.524.982a5.139,5.139,0,0,1,.391.571A4.936,4.936,0,0,1,14.656,10ZM10.572,6.184,6.719,5.11A3.008,3.008,0,0,0,3.052,7.1L2.078,10H12.619l.02-.059a3,3,0,0,0-2.067-3.757ZM1.185,12.657a4.956,4.956,0,0,0,2.364,5.682l-.944,2.728L1.3,20.661A1,1,0,1,0,.7,22.571l4.458,1.384a1,1,0,0,0,.594-1.91L4.516,21.66l.935-2.7A4.982,4.982,0,0,0,6.01,19,5,5,0,0,0,10.8,15.392L11.945,12H1.406ZM15.553,3.9A1,1,0,0,0,16.9,3.447l1-2a1,1,0,1,0-1.79-.894l-1,2A1,1,0,0,0,15.553,3.9ZM7.105,3.447A1,1,0,1,0,8.9,2.553l-1-2a1,1,0,0,0-1.79.894ZM12,0a1,1,0,0,0-1,1V3a1,1,0,0,0,2,0V1A1,1,0,0,0,12,0Z" />
                        </svg>
                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">Bar</p>
                </div>
            </div>

            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#00AEEF"
                            viewBox="0 0 24 24">
                            <path
                                d="m9.5,2.5c0-1.381,1.119-2.5,2.5-2.5s2.5,1.119,2.5,2.5-1.119,2.5-2.5,2.5-2.5-1.119-2.5-2.5Zm8,14c0,1.381,1.119,2.5,2.5,2.5s2.5-1.119,2.5-2.5-1.119-2.5-2.5-2.5-2.5,1.119-2.5,2.5Zm-16,0c0,1.379,1.121,2.5,2.5,2.5s2.5-1.121,2.5-2.5-1.121-2.5-2.5-2.5-2.5,1.121-2.5,2.5Zm20,3.5h-3c-1.378,0-2.5,1.121-2.5,2.5,0-1.379-1.122-2.5-2.5-2.5h-3c-1.378,0-2.5,1.121-2.5,2.5,0-1.379-1.122-2.5-2.5-2.5h-3c-1.378,0-2.5,1.121-2.5,2.5v1.5h24v-1.5c0-1.379-1.122-2.5-2.5-2.5Zm-9.5-6c-1.381,0-2.5,1.119-2.5,2.5s1.119,2.5,2.5,2.5,2.5-1.119,2.5-2.5-1.119-2.5-2.5-2.5Zm-4,.479c.742-1.465,2.246-2.479,4-2.479s3.258,1.014,4,2.479v-5.59l7.151-6.13-1.302-1.518-6.719,5.759h-6.26L2.151,1.241l-1.302,1.518,7.151,6.13v5.59Z" />
                        </svg>
                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">Pemandu Tour</p>
                </div>
            </div>
            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#00AEEF"
                            viewBox="0 0 16 16">
                            <path
                                d="M5 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0m8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-6-1a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2zm1-6c-1.876 0-3.426.109-4.552.226A.5.5 0 0 0 3 4.723v3.554a.5.5 0 0 0 .448.497C4.574 8.891 6.124 9 8 9s3.426-.109 4.552-.226A.5.5 0 0 0 13 8.277V4.723a.5.5 0 0 0-.448-.497A44 44 0 0 0 8 4m0-1c-1.837 0-3.353.107-4.448.22a.5.5 0 1 1-.104-.994A44 44 0 0 1 8 2c1.876 0 3.426.109 4.552.226a.5.5 0 1 1-.104.994A43 43 0 0 0 8 3" />
                            <path
                                d="M15 8a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1V2.64c0-1.188-.845-2.232-2.064-2.372A44 44 0 0 0 8 0C5.9 0 4.208.136 3.064.268 1.845.408 1 1.452 1 2.64V4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v3.5c0 .818.393 1.544 1 2v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V14h6v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2c.607-.456 1-1.182 1-2zM8 1c2.056 0 3.71.134 4.822.261.676.078 1.178.66 1.178 1.379v8.86a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 11.5V2.64c0-.72.502-1.301 1.178-1.379A43 43 0 0 1 8 1" />
                        </svg>
                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">Transportasi</p>
                </div>
            </div>
            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32"
                            fill="#00AEEF">
                            <path
                                d="M24,11.5a3.5,3.5,0,0,0-2.149-3.226,10,10,0,0,0-19.7,0,3.5,3.5,0,0,0,1.119,6.718,10.607,10.607,0,0,0,2.071,2.955,8.908,8.908,0,0,0-2.272,4.928A1,1,0,0,0,4.06,24H19.919a1,1,0,0,0,.992-1.124,8.9,8.9,0,0,0-2.261-4.918,10.622,10.622,0,0,0,2.082-2.966A3.5,3.5,0,0,0,24,11.5Zm-3.752,1.473a.993.993,0,0,0-1.117.651C18.215,16.222,15.13,19,12,19s-6.215-2.78-7.131-5.378a.994.994,0,0,0-1.117-.651A1.606,1.606,0,0,1,3.5,13a1.5,1.5,0,0,1-.27-2.972,1,1,0,0,0,.816-.878A7.966,7.966,0,0,1,8.711,2.71a3.534,3.534,0,1,0,6.578,0,7.966,7.966,0,0,1,4.665,6.44,1,1,0,0,0,.816.878A1.5,1.5,0,0,1,20.5,13,1.606,1.606,0,0,1,20.248,12.973Z" />
                            <circle cx="9.5" cy="11.5" r="1.5" />
                            <circle cx="14.5" cy="11.5" r="1.5" />
                        </svg>
                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">Baby Sitter</p>
                </div>
            </div>
            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32"
                            fill="#00AEEF">
                            <path
                                d="m21.402,18c1.433,0,2.598-1.166,2.598-2.598v-1.402c0-6.279-4.851-11.438-11-11.949v-1.051c0-.552-.448-1-1-1s-1,.448-1,1v1.051C4.851,2.562,0,7.721,0,14v1.402c0,1.433,1.166,2.598,2.598,2.598h8.402v2H1c-.552,0-1,.448-1,1s.448,1,1,1h22c.552,0,1-.448,1-1s-.448-1-1-1h-10v-2h8.402Z" />
                        </svg>
                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">Bantuan Pribadi</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center text-center mt-4">
            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg viewBox="0 0 24 24" width="32" height="32" fill="#00AEEF">
                            <path
                                d="m14.6 21.3c-.3.226-.619.464-.89.7h2.29a1 1 0 0 1 0 2h-4a1 1 0 0 1 -1-1c0-1.5 1.275-2.456 2.4-3.3.75-.562 1.6-1.2 1.6-1.7a1 1 0 0 0 -2 0 1 1 0 0 1 -2 0 3 3 0 0 1 6 0c0 1.5-1.275 2.456-2.4 3.3zm8.4-6.3a1 1 0 0 0 -1 1v3h-1a1 1 0 0 1 -1-1v-2a1 1 0 0 0 -2 0v2a3 3 0 0 0 3 3h1v2a1 1 0 0 0 2 0v-7a1 1 0 0 0 -1-1zm-10-3v-5a1 1 0 0 0 -2 0v4h-3a1 1 0 0 0 0 2h4a1 1 0 0 0 1-1zm10-10a1 1 0 0 0 -1 1v2.374a12 12 0 1 0 -14.364 17.808 1.015 1.015 0 0 0 .364.068 1 1 0 0 0 .364-1.932 10 10 0 1 1 12.272-14.318h-2.636a1 1 0 0 0 0 2h3a3 3 0 0 0 3-3v-3a1 1 0 0 0 -1-1z" />
                        </svg>
                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">
                        Layanan 24 Jam</p>
                </div>
            </div>

            <div class="col-md-1 mx-3">
                <div class="icon-box text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                        style="width: 70px; height: 70px; background-color: #EAF6FF;">
                        <svg viewBox="0 0 24 24" width="32" height="32" fill="#00AEEF">
                            <path
                                d="M15,13.5c0-1.93-1.57-3.5-3.5-3.5H3.5c-1.93,0-3.5,1.57-3.5,3.5,0,1.391,.822,2.585,2,3.149v2.351H1c-.552,0-1,.447-1,1s.448,1,1,1h1v2c0,.553,.448,1,1,1s1-.447,1-1v-2h7v2c0,.553,.448,1,1,1s1-.447,1-1v-2h1c.552,0,1-.447,1-1s-.448-1-1-1h-1v-2.351c1.178-.564,2-1.758,2-3.149Zm-11,5.5v-2h7v2H4ZM23.544,10.161c.487,.959,.58,1.966,.297,2.966-.523,1.849-2.343,3.05-4.32,2.851-.242-.024-.344,.032-.399,.081-.056,.051-.122,.144-.122,.302v6.64c0,.553-.448,1-1,1s-1-.447-1-1V13.5c0-2.562-1.739-4.765-4.23-5.353-.493-.117-.821-.584-.764-1.087,.094-.821,.667-1.604,1.703-2.327,.271-.189,.294-.521,.292-.656-.011-.542,.092-1.084,.306-1.61,.468-1.151,1.454-2.021,2.637-2.33,.706-.185,1.437-.181,2.143,.008,1.171,.313,2.146,1.184,2.61,2.326,.214,.531,.316,1.075,.303,1.62-.003,.161,.03,.459,.294,.645,1.069,.745,1.707,1.966,1.707,3.265,0,.589-.138,1.177-.41,1.749-.104,.218-.096,.306-.096,.307,.003,.016,.032,.069,.05,.105Z" />
                        </svg>

                    </div>
                    <p style="color: #1E1E1E; font-weight: bold; font-size: 18px; margin-top: 15px;">Taman</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mt-5 mb-5" id="contactme">
    <div class="container" style="width: 45% !important;">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center" style="color: #fff; font-size: 32px; font-weight: 600;">
                    Hubungi Kami
                </h2>
                <p class="text-center" style="color: rgba(255, 255, 255, 0.68); font-weight: 500; font-size: 18px;">
                    Jika memiliki pertanyaan lebih lanjut, isi formulir di bawah ini dan kami akan segera menghubungi
                    Anda.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="name" style="font-size: 16px; color: #fff;">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama Anda"
                            required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="email" style="font-size: 16px; color: #fff;">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Masukkan email Anda" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="subject" style="font-size: 16px; color: #fff;">Subjek</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subjek pesan"
                            required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="message" style="font-size: 16px; color: #fff;">Pesan</label>
                        <textarea class="form-control" id="message" name="message" rows="5"
                            placeholder="Tulis pesan Anda di sini..." required></textarea>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary mt-2"
                            style="background-color: #28a745; border-color: #28a745; font-size: 16px;">
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Include file footer
include 'components/footer.php';
?>