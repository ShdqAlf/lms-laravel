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
                            <h5 class="card-title">Materi Modul</h5>
                            @if($modul)
                            <p>{{ $modul->deskripsi_modul }}</p>
                            <iframe
                                src="https://docs.google.com/gview?url={{ asset($modul->pdf_modul) }}&embedded=true"
                                width="100%"
                                height="600px"
                                frameborder="0">
                            </iframe>

                            <!-- Tambahkan div untuk menampilkan countdown timer -->
                            <div id="countdown" class="text-center mt-3" style="font-size: 1.2em; font-weight: bold;">
                                Menuju Pembelajaran Interaktif: <span id="timer">02:00</span>
                            </div>

                            <!-- Tambahkan button "Buka Pembelajaran Interaktif" -->
                            <div class="text-end mt-3">
                                <button id="interactiveButton" class="btn btn-primary" disabled>
                                    Buka Pembelajaran Interaktif
                                </button>
                            </div>
                            @else
                            <p>Belum ada modul yang tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Tambahkan script untuk handle countdown dan button -->
    <script>
        // Waktu countdown dalam detik (2 menit = 120 detik)
        let timeLeft = 120;

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
                document.getElementById('interactiveButton').disabled = false;
                document.getElementById('countdown').style.display = 'none';
            }
        }

        // Fungsi untuk mengarahkan ke halaman PPT
        document.getElementById('interactiveButton').addEventListener('click', function() {
            window.location.href = "{{ route('showPpt', ['id' => $course->id]) }}";
        });

        // Mulai countdown saat halaman dimuat
        window.onload = updateTimer;
    </script>
    @include('layout/foot')
</div>