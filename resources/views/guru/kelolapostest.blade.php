@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Kelola Postest</h1> <!-- Menampilkan nama user -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Kelola Postest Siswa</li>
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
                            <!-- Tombol Tambah Akun -->
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addpostestModal">
                                    Tambah Soal postest
                                </button>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($postest as $index => $postest)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $postest->soal_postest }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">
                                                Edit
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('deletepostest', $postest->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus soal postest ini?')">Hapus</button>
                                            </form>
                                        </td>
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
    <!-- Modal Tambah postest -->
    <div class="modal fade" id="addpostestModal" tabindex="-1" aria-labelledby="addpostestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('storepostest') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ Auth::user()->course->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addpostestModalLabel">Tambah Soal postest</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="postest" class="form-label">Masukkan Soal postest</label>
                            <textarea class="form-control" id="postest" name="postest" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah Soal postest</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@include('layout/foot')
</div>