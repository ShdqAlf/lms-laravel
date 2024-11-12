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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Status Pengisian</th>
                                        <th>Nilai</th>
                                        <th>File Pengumpulan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->nama }}</td>
                                        <td>{{ $student->status_pengisian }}</td>
                                        <td>{{ $student->nilai }}</td>
                                        <td>
                                            @if($student->status_pengisian == 'Sudah Mengisi')
                                            <a href="{{ asset('storage/' . $student->file_jawaban) }}" target="_blank">{{ $student->nama_file }}</a>
                                            @else
                                            {{ $student->nama_file }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($student->status_pengisian == 'Sudah Mengisi')
                                            @if($student->nilai == 'Belum Dinilai')
                                            <!-- Button Beri Nilai -->
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#beriNilai{{ $student->id }}">Beri Nilai</button>
                                            @else
                                            <!-- Button Rubah Nilai -->
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#rubahNilai{{ $student->id }}">Rubah Nilai</button>
                                            @endif
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- Modal Beri Nilai untuk setiap siswa -->
                                    <div class="modal fade" id="beriNilai{{ $student->id }}" tabindex="-1" aria-labelledby="beriNilaiLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('simpanNilaiLkpd') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="beriNilaiLabel">Beri nilai LKPD untuk {{ $student->nama }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="user_id" value="{{ $student->id }}">
                                                        <input type="hidden" name="course_id" value="{{ $course_id }}">
                                                        <div class="form-group">
                                                            <label for="score">Masukkan Nilai: </label>
                                                            <input type="text" name="score" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Rubah Nilai -->
                                    <div class="modal fade" id="rubahNilai{{ $student->id }}" tabindex="-1" aria-labelledby="rubahNilaiLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('simpanNilaiLkpd') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rubahNilaiLabel">Rubah nilai LKPD untuk {{ $student->nama }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="user_id" value="{{ $student->id }}">
                                                        <input type="hidden" name="course_id" value="{{ $course_id }}">
                                                        <div class="form-group">
                                                            <label for="score">Masukkan Nilai: </label>
                                                            <input type="text" name="score" class="form-control" required value="{{ $student->nilai }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Update Nilai</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@include('layout/foot')
</div>