@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Selamat Datang, {{ Auth::user()->nama }}</h1> <!-- Menampilkan nama user -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Kamu adalah {{ Auth::user()->role }} @if (Auth::user()->role === 'guru' && Auth::user()->course) {{ Auth::user()->course->course }} @endif</li> <!-- Menampilkan role user -->
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('storePengumpulanLkpd') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <div class="mb-3">
                                    <label for="pdf_pengumpulanLkpd" class="form-label">Tambahkan file Pengumpulan LKPD</label>
                                    <input class="form-control" type="file" id="pdf_pengumpulanLkpd" name="pdf_pengumpulanLkpd">
                                    <p>Status Pengumpulan: {{ $hasSubmitted ? 'Sudah' : 'Belum' }} Mengumpulkan.
                                        <!-- Tambahkan link download jika sudah mengumpulkan -->
                                        @if($hasSubmitted)
                                        <a href="{{ asset($filePath) }}" target="_blank"> Klik untuk mendownload file</a>
                                        @endif
                                    </p>
                                </div>
                                <div class="d-flex justify-content-end align-items-center mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                </div>
                            </form>

                            <!-- Button untuk membuka modal -->
                            <div class="d-flex justify-content-end align-items-center mt-4">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                                    Lanjut ke Tes LKPD Berkelompok
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah kamu yakin ingin langsung mengerjakan LKPD?</p>
                <p><strong>PERINGATAN!!</strong> Anda akan langsung membuka penugasan LKPD berkelompok, dan waktu mundur tes akan dimulai. Sebaiknya kamu kembali dahulu ke halaman course.</p>
            </div>
            <div class="modal-footer">
                <!-- Tombol Batal -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <!-- Tombol Kembali ke Course -->
                <a href="{{ route('course', ['id' => $course->id]) }}" class="btn btn-primary">Kembali ke Course</a>
                <!-- Tombol Langsung Kerjakan LKPD Kelompok -->
                <a href="{{ route('lkpdkelompokquestions', ['id' => $course->id]) }}" class="btn btn-danger">Langsung Kerjakan LKPD Kelompok</a>
            </div>
        </div>
    </div>
</div>

@include('layout/foot')
</div>