@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <nav>
            <h1>LKPD Kelompok</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Jawab tiap postest dibawah ini dengan jawaban berupa uraian</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Countdown Timer -->
                            <div class="mb-4" id="countdown-timer">
                                <h4>Waktu Tersisa: <span id="timer"></span></h4>
                            </div>

                            <form action="{{ route('storeAnswersLkpdKelompok') }}" method="POST">
                                @csrf
                                <input type="text" name="user_id" class="hidden" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                @foreach($lkpdkelompok as $index => $question)
                                <div class="mb-4">
                                    <h5>{{ $index + 1 }}. {!! nl2br(e($question->soal_lkpd)) !!}</h5>
                                    <textarea name="jawaban[{{ $question->id }}]" class="form-control" placeholder="Masukkan jawaban Anda"></textarea>
                                </div>
                                @endforeach
                                <!-- Button to trigger modal -->
                                <button type="button" onclick="showSavepostestModal()" class="btn btn-primary">Simpan Jawaban</button>

                                <!-- Modal -->
                                <div class="modal fade" id="savepostestModal" tabindex="-1" aria-labelledby="savepostestModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="savepostestModalLabel">Konfirmasi Pengumpulan postest</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin mengumpulkan LKPD Kelompok? Setelah dikumpulkan, LKPD Kelompok tidak dapat dikerjakan lagi.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Kumpulkan Jawaban</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Script to Show Modal -->
                            <script>
                                // Mengambil ID kursus yang tersimpan di sessionStorage
                                let currentCourseId = sessionStorage.getItem('currentCourseId');
                                let newCourseId = '{{ $course->id }}'; // Mendapatkan ID kursus yang aktif saat ini

                                // Cek jika kursus berbeda dari yang ada di session storage
                                if (currentCourseId !== newCourseId) {
                                    // Jika kursus berbeda, reset countdown dan simpan ID kursus baru
                                    sessionStorage.removeItem('countdownDate');
                                    sessionStorage.setItem('currentCourseId', newCourseId);
                                }

                                // Cek apakah countdownDate sudah ada di sessionStorage
                                let countdownDate = sessionStorage.getItem('countdownDate');

                                // Jika belum ada, set countdown (misalnya 1 jam dari sekarang)
                                if (!countdownDate) {
                                    countdownDate = new Date().getTime() + 3600000; // 1 jam (3600000 ms)
                                    sessionStorage.setItem('countdownDate', countdownDate); // Simpan countdown di sessionStorage
                                } else {
                                    countdownDate = parseInt(countdownDate);
                                }

                                // Fungsi untuk memperbarui timer setiap detik
                                var x = setInterval(function() {
                                    var now = new Date().getTime();
                                    var distance = countdownDate - now;

                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                    document.getElementById("timer").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

                                    // Jika countdown selesai
                                    if (distance < 0) {
                                        clearInterval(x);
                                        document.getElementById("timer").innerHTML = "Waktu Habis";
                                    }
                                }, 1000);

                                // Fungsi untuk menampilkan modal konfirmasi
                                function showSavepostestModal() {
                                    var savepostestModal = new bootstrap.Modal(document.getElementById('savepostestModal'));
                                    savepostestModal.show();
                                }
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@include('layout/foot')
</div>