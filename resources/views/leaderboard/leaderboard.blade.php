@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>@if (Auth::user()->role == 'guru') Rekap Nilai @elseif (Auth::user()->role == 'siswa') Leaderboard @endif</h1> <!-- Menampilkan nama user -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">@if (Auth::user()->role == 'guru') Rekap Nilai Keseluruhan Siswa @elseif (Auth::user()->role == 'siswa') Leaderboard Nilai Siswa @endif</li> <!-- Menampilkan role user -->
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body" style="background-color: #E0FFFF;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>NIS</th>
                                        <th>Nilai Pretest</th>
                                        @foreach ($courses as $course)
                                        <th>Nilai {{ $course->course }}</th>
                                        @endforeach
                                        <th>Nilai Postest</th>
                                        <th>Rata-Rata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->nama }}</td>
                                        <td>{{ $student->nomor_id }}</td>
                                        <td>{{ $student->nilaiPretest }}</td>
                                        @foreach ($courses as $course)
                                        <td>{{ $student->nilaiLkpdArray[$course->id] ?? '-' }}</td>
                                        @endforeach
                                        <td>{{ $student->nilaiPostest }}</td>
                                        <td>{{ round($student->averageScore, 2) }}</td>
                                    </tr>
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