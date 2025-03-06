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
                            <h5>Jawaban Postest Siswa</h5>
                            <form action="{{ route('storeScorePostest', $user_id) }}" method="POST">
                                @csrf
                                @foreach($jawabanPostests as $index => $jawaban)
                                <div class="mb-4">
                                    <h5>{{ $index + 1 }}. {{ $jawaban->postest->soal_postest }}</h5>
                                    <textarea name="jawaban" rows="4" class="form-control" readonly>{{ $jawaban->jawaban }}</textarea>
                                    <input type="hidden" name="postest_id[]" value="{{ $jawaban->postest->id }}">
                                </div>
                                @endforeach

                                <!-- Form to Input Grade and Save Button -->
                                <div class="d-flex justify-content-end align-items-center mt-4">
                                    <label for="nilai" class="form-label me-2 mb-0">Masukkan Nilai:</label>
                                    <input type="number" name="nilai" id="nilai" class="form-control col-md-2 me-2" placeholder="Nilai" style="width: 80px;">
                                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
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