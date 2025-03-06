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
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                @foreach($kelompok as $group)
                                <h6>{{ $group->nama_kelompok }}</h6>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Status Pengisian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($group->users as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->nama }}</td>
                                            <td>
                                                @php
                                                $status = $user->jawabanLkpdKelompok->isNotEmpty() ? 'Sudah Mengisi' : 'Belum Mengisi';
                                                @endphp
                                                {{ $status }}
                                            </td>
                                            <td>
                                                @if($status == 'Sudah Mengisi')
                                                <a href="{{ route('lihatJawabanLkpdKelompok', ['user_id' => $user->id, 'course_id' => $course_id]) }}" class="btn btn-primary btn-sm">
                                                    Lihat Jawaban
                                                </a>
                                                @else
                                                -
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex align-items-center gap-3 mt-2">
                                    @php
                                    // Ambil salah satu nilai anggota kelompok jika sudah dinilai
                                    $nilaiKelompok = $group->users->first()->nilaiLkpdKelompok->score ?? null;
                                    @endphp

                                    @if($nilaiKelompok !== null)
                                    <p class="fw-bold mb-0">Nilai: {{ $nilaiKelompok }}</p>
                                    @endif

                                    <!-- Tombol Beri/Rubah Nilai -->
                                    <button type="button" class="btn {{ $nilaiKelompok !== null ? 'btn-warning' : 'btn-primary' }} btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#beriNilaiModal{{ $group->id }}">
                                        {{ $nilaiKelompok !== null ? 'Rubah Nilai' : 'Beri Nilai' }}
                                    </button>
                                </div>

                                <!-- Modal Beri/Rubah Nilai -->
                                <div class="modal fade" id="beriNilaiModal{{ $group->id }}" tabindex="-1" aria-labelledby="beriNilaiModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Beri Nilai - {{ $group->nama_kelompok }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('simpanNilaiLkpdKelompok') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="kelompok_id" value="{{ $group->id }}">
                                                    <input type="hidden" name="course_id" value="{{ $course_id }}">

                                                    <div class="mb-3">
                                                        <label for="score" class="form-label">Masukkan Nilai:</label>
                                                        <input type="number" name="score" class="form-control" required min="0" max="100" value="{{ $nilaiKelompok ?? '' }}">
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">Simpan Nilai</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@include('layout/foot')
</div>