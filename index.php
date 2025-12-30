<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Pratama Adhyaksa - Kejaksaan Negeri Kabupaten Gorontalo</title>
    <link rel="stylesheet" href="css/style.css">
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
            &copy; 2025 Klinik Pratama Adhyaksa. Kejaksaan Negeri Kabupaten Gorontalo.
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