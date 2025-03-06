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
                            @foreach($kelompok as $key => $group)
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
                                            // Cek apakah siswa sudah mengisi
                                            $status = $user->jawabanLkpdKelompok->isNotEmpty() ? 'Sudah Mengisi' : 'Belum Mengisi';
                                            @endphp
                                            {{ $status }}
                                        </td>
                                        <td>
                                            @if($user->jawabanLkpdKelompok->isNotEmpty() ? 'Sudah Mengisi' : 'Belum Mengisi' == 'Sudah Mengisi')
                                            <!-- Tombol Lihat Jawaban jika sudah mengisi -->
                                            <a href="" class="btn btn-primary btn-sm">Lihat Jawaban</a>
                                            @else
                                            <!-- Tanda "-" jika belum mengisi -->
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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