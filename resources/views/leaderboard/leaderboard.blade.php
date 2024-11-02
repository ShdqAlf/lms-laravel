@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Leaderboard Nilai</h1> <!-- Menampilkan nama user -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Rekap Nilai Keseluruhan Siswa</li> <!-- Menampilkan role user -->
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>NIS</th>
                                        <th>Nilai Pretest</th>
                                        <th>Nilai LKPD</th>
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
                                        <td>{{ $student->nilaiPretest }}</td> <!-- Pretest score -->
                                        <th>-</th> <!-- Assuming this is for LKPD, update if necessary -->
                                        <td>{{ $student->nilaiPostest }}</td> <!-- Postest score -->
                                        <th>70</th> <!-- Assuming this is a fixed average or needs to be calculated -->
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