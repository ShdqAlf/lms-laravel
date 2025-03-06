@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Mata Pelajaran {{ $course->course }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Modul, materi, dan LKPD dari mata pelajaran {{ $course->course }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="container mt-5">
                                <h3>{{ $lkpd->deskripsi_lkpd }}</h3>
                                <iframe
                                    src="https://docs.google.com/gview?url={{ asset($lkpd->pdf_lkpd) }}&embedded=true"
                                    width="100%"
                                    height="600px"
                                    frameborder="0">
                                </iframe>

                                <!-- Tambahkan countdown timer dan button -->
                                <div class="text-center mt-4">
                                    <div id="countdown" style="font-size: 1.2em; font-weight: bold;">
                                        Menuju Pengumpulan LKPD: <span id="timer">02:00</span>
                                    </div>
                                    <button id="submitButton" class="btn btn-primary mt-3" disabled>
                                        Lanjut ke Pengumpulan LKPD
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('layout/foot')
</div>

<!-- Script untuk handle countdown dan button -->
<script>
    // Waktu countdown dalam detik (2 menit = 120 detik)
    let timeLeft = 60;

    // Fungsi untuk mengupdate timer
    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        document.getElementById('timer').textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

        if (timeLeft > 0) {
            timeLeft--;
            setTimeout(updateTimer, 1000); // Update setiap 1 detik
        } else {
            // Jika timer habis, aktifkan button dan sembunyikan timer
            document.getElementById('submitButton').disabled = false;
            document.getElementById('countdown').style.display = 'none';
        }
    }

    // Fungsi untuk mengarahkan ke halaman pengumpulan LKPD
    document.getElementById('submitButton').addEventListener('click', function() {
        // Redirect ke halaman pengumpulan LKPD dengan ID course yang sesuai
        window.location.href = "{{ route('pengumpulanLkpd', ['id' => $course->id]) }}";
    });

    // Mulai countdown saat halaman dimuat
    window.onload = updateTimer;
</script>