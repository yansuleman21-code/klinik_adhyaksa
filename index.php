<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Pratama Adhyaksa - Kejaksaan Negeri Kabupaten Gorontalo</title>
    <link rel="icon" type="image/png" href="images/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- Header -->
    <header>
        <nav>
            <div class="logo">
                <img src="images/logo.png" alt="Logo Klinik Adhyaksa"> KLINIK PRATAMA ADHYAKSA
            </div>
            <ul class="nav-links">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#services">Layanan</a></li>
                <li><a href="#flow">Alur</a></li>
                <li><a href="#contact">Kontak</a></li>
                <li><a href="login.php" class="btn-login">LOGIN</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>KLINIK PRATAMA ADHYAKSA<br>KEJAKSAAN NEGERI KABUPATEN GORONTALO</h1>
            <p>"Layanan medis profesional & terpercaya untuk keluarga Anda."</p>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="about-image">
            <img src="images/official.png" alt="Kepala Klinik">
        </div>
        <div class="about-text">
            <h2>Tentang Kami</h2>
            <p>
                Klinik Pratama Adhyaksa adalah penyedia layanan kesehatan modern yang berdiri sejak tahun 2021 dan telah
                terakreditasi "Paripurna".
                <br><br>
                Kami hadir untuk memberikan pelayanan medis yang aman, cepat, dan terintegrasi dengan teknologi terkini.
                Dengan tim profesional dan fasilitas lengkap, kami berkomitmen menjadi mitra kesehatan terbaik Anda dan
                keluarga.
            </p>

            <div class="about-extra">
                <h3>Kenapa Pilih Klinik Pratama Adhyaksa?</h3>
                <ul class="about-list">
                    <li>Dokter & Tenaga Medis Profesional</li>
                    <li>Fasilitas Poli Umum & Gigi</li>
                    <li>Terakreditasi "PARIPURNA"</li>
                    <li>Fasilitas KIA/KB</li>
                    <li>Telah Terdaftar dan Bekerja Sama dengan BPJS</li>
                </ul>

                <!-- <p class="address">
                    📍 <strong>Alamat:</strong> Jl. Samaun Pulubuhu, Desa Pone, Kec. Limboto Barat, Kabupaten Gorontalo
                </p> -->

                <h3>Daftar Tenaga Kesehatan</h3>
                <div class="doctor-list">
                    <div class="doctor-item">
                        <strong>dr. Annisa S. Puspa</strong><br>
                        <span>Dokter Umum</span>
                    </div>
                    <div class="doctor-item">
                        <strong>dr. Muhamad Arief</strong><br>
                        <span>Dokter Umum</span>
                    </div>
                    <div class="doctor-item">
                        <strong>drg. Devy N. Tilolango</strong><br>
                        <span>Dokter Gigi</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="vision-mission">
        <h2>Visi & Misi</h2>
        <div class="card-container">
            <div class="card">
                <h3>Visi</h3>
                <p>Menjadi pusat layanan kesehatan pilihan utama yang mengedepankan kualitas dan kepedulian.</p>
            </div>
            <div class="card">
                <h3>Misi</h3>
                <ul class="mission-list">
                    <li>Memberikan pelayanan medis berkualitas tinggi</li>
                    <li>Mengutamakan kenyamanan dan keselamatan pasien</li>
                    <li>Mendorong inovasi teknologi kesehatan berkelanjutan</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <h2>Layanan Unggulan</h2>
        <div class="services-grid">
            <div class="service-item">
                <span class="service-icon">🚑</span> UGD Rawat Jalan
            </div>
            <div class="service-item">
                <span class="service-icon">🖥️</span> USG dan USG Abdomen
            </div>
            <div class="service-item">
                <span class="service-icon">💊</span> Prolanis
            </div>
            <div class="service-item">
                <span class="service-icon">👶</span> Posyandu
            </div>
            <div class="service-item">
                <span class="service-icon">👵</span> Posbindu
            </div>
            <div class="service-item">
                <span class="service-icon">💉</span> Pelayanan Imunisasi
            </div>
            <div class="service-item">
                <span class="service-icon">🔬</span> Skrining HIV dan TBC
            </div>
            <div class="service-item">
                <span class="service-icon">🧪</span> Pelayanan Iva Test
            </div>
        </div>

    </section>

    <!-- Alur Pelayanan Section -->
    <section id="flow" class="vision-mission">
        <h2>Alur Pelayanan</h2>
        <div class="flow-wrapper">
            <div class="flow-chart">
                <!-- Step 1 -->
                <div class="flow-node">
                    PASIEN DATANG
                </div>
                <div class="flow-arrow"><i class="fas fa-arrow-right"></i></div>

                <!-- Step 2 -->
                <div class="flow-node">
                    INFORMASI &<br>PENDAFTARAN
                </div>
                <div class="flow-arrow"><i class="fas fa-arrow-right"></i></div>

                <!-- Branching Steps -->
                <div class="flow-group">
                    <div class="flow-node" style="margin-bottom: 10px;">
                        KONSULTASI:
                        <ul>
                            <li>Gizi</li>
                            <li>Kesehatan Lingkungan</li>
                        </ul>
                    </div>
                    <div class="flow-node">
                        PEMERIKSAAN:
                        <ul>
                            <li>Umum</li>
                            <li>Gigi</li>
                            <li>Kesehatan Ibu & Anak</li>
                            <li>Laboratorium</li>
                        </ul>
                    </div>
                </div>

                <div class="flow-arrow"><i class="fas fa-arrow-right"></i></div>

                <!-- Step 4 -->
                <div class="flow-node">
                    DIAGNOSA
                </div>
                <div class="flow-arrow"><i class="fas fa-arrow-right"></i></div>

                <!-- Step 5 -->
                <div class="flow-node">
                    TINDAKAN
                </div>
                <div class="flow-arrow"><i class="fas fa-arrow-right"></i></div>

                <!-- Branching Output -->
                <!-- Branching Output -->
                <div class="flow-group">
                    <div class="flow-node" style="margin-bottom: 20px;">
                        RUJUKAN
                    </div>

                    <!-- Bottom Branch Container -->
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <div class="flow-node">
                            PENGAMBILAN OBAT<br>& BAYAR
                        </div>
                        <div class="flow-arrow" style="transform: rotate(90deg); width: 30px; height: 40px; margin: 0;">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <div class="flow-node">
                            PASIEN PULANG
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="reviews" style="background-color: #fff; padding: 4rem 10%;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <h2
                style="text-align:center; color: var(--primary-green); margin-bottom: 30px; font-size: 2rem; border-bottom: 3px solid var(--secondary-green); display: inline-block; padding-bottom: 5px;">
                Ulasan Pasien</h2>

            <!-- Review Grid -->
            <div class="review-grid">
                <?php
                include 'sim_adhyaksa/koneksi.php';
                $query = mysqli_query($conn, "SELECT * FROM ulasan ORDER BY tanggal DESC LIMIT 6");
                while ($row = mysqli_fetch_array($query)) {
                    $initial = strtoupper(substr($row['nama'], 0, 1));
                    $bg_colors = ['#8d6e63', '#5d4037', '#795548', '#a1887f', '#3e2723', '#1565c0', '#c62828', '#2e7d32'];
                    $random_bg = $bg_colors[array_rand($bg_colors)];

                    $time_ago = '';
                    $timestamp = strtotime($row['tanggal']);
                    $diff = time() - $timestamp;

                    if ($diff < 60)
                        $time_ago = 'Baru saja';
                    elseif ($diff < 3600)
                        $time_ago = floor($diff / 60) . ' menit yang lalu';
                    elseif ($diff < 86400)
                        $time_ago = floor($diff / 3600) . ' jam yang lalu';
                    elseif ($diff < 604800)
                        $time_ago = floor($diff / 86400) . ' hari yang lalu';
                    elseif ($diff < 2592000)
                        $time_ago = floor($diff / 604800) . ' minggu yang lalu';
                    else
                        $time_ago = floor($diff / 2592000) . ' bulan yang lalu';
                    ?>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="avatar" style="background-color: <?php echo $random_bg; ?>;">
                                <?php echo $initial; ?>
                            </div>
                            <div class="user-info">
                                <span class="username"><?php echo htmlspecialchars($row['nama']); ?></span>
                                <div class="meta-info">1 ulasan &bull; 0 foto</div>
                            </div>
                        </div>
                        <div class="review-meta">
                            <div class="stars">
                                <?php for ($i = 0; $i < $row['rating']; $i++)
                                    echo '<i class="fas fa-star" style="color: #fbc02d;"></i>'; ?>
                                <?php for ($i = $row['rating']; $i < 5; $i++)
                                    echo '<i class="far fa-star" style="color: #ddd;"></i>'; ?>
                            </div>
                            <span class="time-ago"><?php echo $time_ago; ?></span>
                            <span class="badge-new">BARU</span>
                        </div>
                        <div class="review-content">
                            <?php echo htmlspecialchars($row['komentar']); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Review Form Toggle -->
            <div style="text-align: center; margin-top: 40px;">
                <button onclick="document.getElementById('reviewForm').style.display='block'; this.style.display='none'"
                    class="btn-login" style="cursor: pointer; padding: 12px 25px; font-size:1rem;">Tulis Ulasan</button>
            </div>

            <!-- Review Form -->
            <div id="reviewForm" class="review-form-card"
                style="display:none; margin-top: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
                <h3 style="margin-bottom: 20px; color: var(--primary-green);">Berikan Ulasan Anda</h3>
                <form action="process_review.php" method="POST">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <input type="text" name="nama" placeholder="Nama Anda" required
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display:block; margin-bottom: 5px;">Rating:</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" required /><label for="star5"
                                title="Sempurna">★</label>
                            <input type="radio" id="star4" name="rating" value="4" /><label for="star4"
                                title="Sangat Baik">★</label>
                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3"
                                title="Baik">★</label>
                            <input type="radio" id="star2" name="rating" value="2" /><label for="star2"
                                title="Cukup">★</label>
                            <input type="radio" id="star1" name="rating" value="1" /><label for="star1"
                                title="Buruk">★</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <textarea name="komentar" rows="4" placeholder="Bagikan pengalaman Anda..." required
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-family: inherit;"></textarea>
                    </div>
                    <button type="submit" class="btn-login" style="border:none; cursor:pointer;">Kirim</button>
                    <button type="button"
                        onclick="document.getElementById('reviewForm').style.display='none'; document.querySelector('.reviews button').style.display='inline-block'"
                        class="btn-login"
                        style="background:#ccc; color:#333 !important; border:none; cursor:pointer;">Batal</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Hubungi Kami</h3>
                <p><img src="images/kejari.png" alt="Logo Klinik Adhyaksa">Kejaksaan Negeri Kabupaten Gorontalo</p>
                <p>📞 +6285397051248</p>
                <p>📧 kejari.kabupatengorontalo@kejaksaan.go.id</p>
            </div>
            <div class="footer-section">
                <h3>Komitmen Kami</h3>
                <div class="quote-box">
                    "Kami melayani dengan pendekatan holistik dan dukungan teknologi modern."
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2026 Klinik Pratama Adhyaksa. Kejaksaan Negeri Kabupaten Gorontalo.
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Text to speech function
            function speakWelcome() {
                if ('speechSynthesis' in window) {
                    const text = "Selamat datang di website klinik pratama adhyaksa kejaksaan negeri kabupaten gorontalo, kami siap melayani anda";
                    const utterance = new SpeechSynthesisUtterance(text);
                    utterance.lang = 'id-ID';

                    utterance.rate = 1.2; // Sedikit lebih cepat agar terdengar bersemangat
                    utterance.pitch = 1.5; // Nada sedikit lebih tinggi
                    utterance.volume = 1.5; // Volume maksimal

                    // Optional: Try to set a better voice if available
                    const voices = window.speechSynthesis.getVoices();
                    const indoVoice = voices.find(voice => voice.lang.includes('id'));
                    if (indoVoice) utterance.voice = indoVoice;

                    window.speechSynthesis.speak(utterance);
                }
            }

            // Attempt to speak immediately (might be blocked by browser)
            speakWelcome();

            // Allow triggering by a click anywhere if blocked
            document.body.addEventListener('click', function () {
                if (!window.speechSynthesis.speaking) {
                    speakWelcome();
                }
            }, { once: true });
        });
    </script>
</body>

</html>