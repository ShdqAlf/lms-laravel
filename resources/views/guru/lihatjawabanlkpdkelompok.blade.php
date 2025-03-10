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
                            <h4>Jawaban LKPD Kelompok</h4>
                            @foreach($jawaban as $index => $jawaban)
                            <div class="mb-4">
                                <h5>{{ $index + 1 }}. {{ $jawaban->lkpdKelompok->soal_lkpd }}</h5>
                                <textarea name="jawaban" rows="4" class="form-control" readonly>{{ $jawaban->jawaban }}</textarea>
                                <img src="{{ asset('storage/' . $jawaban->gambar_jawaban) }}" alt="Jawaban Gambar">
                                <input type="hidden" name="lkpd_kelompok_id[]" value="{{ $jawaban->lkpdKelompok->id }}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@include('layout/foot')
</div>