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
                            <h5>Jawaban Pretest Siswa</h5>
                            <form action="{{ route('storeScorePretest', $user_id) }}" method="POST">
                                @csrf
                                <!-- Display Multiple Choice Answers -->
                                <h5>Jawaban Pilihan Ganda</h5>
                                @foreach($soalPretestPgs as $index => $soalPretest)
                                <div class="mb-4">
                                    <h5>{{ $index + 1 }}. {{ $soalPretest->soal_pretest }}</h5>
                                    @endforeach
                                    @foreach($jawabanPretestPgs as $index => $jawabanPg)
                                    <p>Jawaban: {{ $jawabanPg->jawaban }}</p>
                                </div>
                                @endforeach


                                <!-- Display Essay Answers -->
                                <h5>Jawaban Uraian</h5>
                                @foreach($jawabanPretests as $index => $jawaban)
                                <div class="mb-4">
                                    <h5>{{ $index + 1 }}. {{ $jawaban->pretest->soal_pretest }}</h5>
                                    <textarea name="jawaban" rows="4" class="form-control" readonly>{{ $jawaban->jawaban }}</textarea>
                                    <img src="{{ asset('storage/' . $jawaban->gambar_jawaban) }}" alt="Jawaban Gambar">
                                    <input type="hidden" name="pretest_id[]" value="{{ $jawaban->pretest->id }}">
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