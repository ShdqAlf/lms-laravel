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
                                <input type="text" name="course_id" value="{{ $course->id }}">
                                <div class="mb-3">
                                    <label for="pdf_pengumpulanLkpd" class="form-label">Tambahkan file Pengumpulan LKPD</label>
                                    <input class="form-control" type="file" id="pdf_pengumpulanLkpd" name="pdf_pengumpulanLkpd">
                                    <p>Status Pengumpulan: {{ $hasSubmitted ? 'Sudah' : 'Belum' }} Mengumpulkan <a href="" target="_blank">{{ $hasSubmitted ? '. Klik untuk melihat file' : '' }}</a></p>
                                </div>
                                <div class="d-flex justify-content-end align-items-center mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@include('layout/foot')
</div>