@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Kelola Pretest</h1> <!-- Menampilkan nama user -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Kelola Pretest Siswa</li>
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
                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addpretestModal">
                                    Tambah Soal Pretest
                                </button>
                            </div>

                            <!-- Tabel Soal Pilihan Ganda -->
                            <h5>Soal Pilihan Ganda</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>Opsi A</th>
                                        <th>Opsi B</th>
                                        <th>Opsi C</th>
                                        <th>Opsi D</th>
                                        <th>Jawaban Benar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pretestPilihanGanda as $index => $pretest)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{!! nl2br(e($pretest->soal_pretest)) !!}</td>
                                        <td>{!! nl2br(e($pretest->opsi_a)) !!}</td>
                                        <td>{!! nl2br(e($pretest->opsi_b)) !!}</td>
                                        <td>{!! nl2br(e($pretest->opsi_c)) !!}</td>
                                        <td>{!! nl2br(e($pretest->opsi_d)) !!}</td>
                                        <td>{{ $pretest->is_correct }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-warning btn-sm edit-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editPilihanGandaModal"
                                                data-id="{{ $pretest->id }}"
                                                course-id="{{$pretest->course_id}}"
                                                data-soal="{!! nl2br(e($pretest->soal_pretest )) !!}"
                                                data-opsi_a="{!! nl2br(e($pretest->opsi_a)) !!}"
                                                data-opsi_b="{!! nl2br(e($pretest->opsi_b)) !!}"
                                                data-opsi_c="{!! nl2br(e($pretest->opsi_c)) !!}"
                                                data-opsi_d="{!! nl2br(e($pretest->opsi_d)) !!}"
                                                data-is_correct="{{ $pretest->is_correct }}">
                                                Edit
                                            </button>

                                            <form action="{{ route('deletepretest', ['id' => $pretest->id, 'type' => 'pilihanGanda']) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus soal pretest ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Tabel Soal Uraian -->
                            <h5>Soal Uraian</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pretestUraian as $index => $pretest)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{!! nl2br(e($pretest->soal_pretest)) !!}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-warning btn-sm edit-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editUraianModal"
                                                data-id="{{ $pretest->id }}"
                                                course-id="{{$pretest->course_id}}"
                                                data-soal="{!! nl2br(e($pretest->soal_pretest )) !!}">
                                                Edit
                                            </button>

                                            <form action="{{ route('deletepretest', ['id' => $pretest->id, 'type' => 'uraian']) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus soal pretest ini?')">Hapus</button>
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
    <!-- Modal Tambah Pretest -->
    <div class="modal fade" id="addpretestModal" tabindex="-1" aria-labelledby="addpretestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('storepretest') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ Auth::user()->course->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addpretestModalLabel">Tambah Soal Pretest</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <select name="jenisSoal" class="form-select anggota-select" aria-label="Pilih Jenis Soal" id="jenisSoalSelect">
                                <option selected>Pilih Jenis Soal</option>
                                <option value="pilihanGanda">Pilihan Ganda</option>
                                <option value="uraian">Uraian</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="pretest" class="form-label">Masukkan Soal Pretest</label>
                            <textarea class="form-control" id="pretest" name="pretest" rows="3" required></textarea>
                        </div>

                        <div id="pilihanGandaSection" style="display: none;">
                            <label for="pretest" class="form-label">Pilih Opsi yang benar</label>
                            <div class="d-flex">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="is_correct" value="A" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">A</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="is_correct" value="B" id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">B</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="is_correct" value="C" id="flexRadioDefault3">
                                    <label class="form-check-label" for="flexRadioDefault3">C</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="is_correct" value="D" id="flexRadioDefault4">
                                    <label class="form-check-label" for="flexRadioDefault4">D</label>
                                </div>
                            </div>

                            <!-- Opsi A, B, C, D -->
                            <div class="form-group mb-2">
                                <input type="text" name="opsi_a" class="form-control" id="opsi_a" placeholder="Masukkan Opsi A">
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" name="opsi_b" class="form-control" id="opsi_b" placeholder="Masukkan Opsi B">
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" name="opsi_c" class="form-control" id="opsi_c" placeholder="Masukkan Opsi C">
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" name="opsi_d" class="form-control" id="opsi_d" placeholder="Masukkan Opsi D">
                            </div>
                        </div>

                        <div id="uraianSection" style="display: none;">
                            <!-- Tidak perlu opsi, hanya soal uraian -->
                            <p>Soal uraian akan disimpan hanya dengan soal pretest.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah Soal Pretest</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Soal Pilihan Ganda -->
    <div class="modal fade" id="editPilihanGandaModal" tabindex="-1" aria-labelledby="editPilihanGandaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('updatepretest') }}" method="POST" id="editPilihanGandaForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-pilihan-ganda-id">
                    <input type="hidden" name="course_id" id="edit-pilihan-ganda-course-id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPilihanGandaModalLabel">Edit Soal Pilihan Ganda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="edit-pilihan-ganda" class="form-label">Soal Pilihan Ganda</label>
                            <textarea class="form-control" id="edit-pilihan-ganda" name="pretest" rows="4" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit-opsi_a" class="form-label">Opsi A</label>
                            <input type="text" class="form-control" id="edit-opsi_a" name="opsi_a" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit-opsi_b" class="form-label">Opsi B</label>
                            <input type="text" class="form-control" id="edit-opsi_b" name="opsi_b" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit-opsi_c" class="form-label">Opsi C</label>
                            <input type="text" class="form-control" id="edit-opsi_c" name="opsi_c" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit-opsi_d" class="form-label">Opsi D</label>
                            <input type="text" class="form-control" id="edit-opsi_d" name="opsi_d" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Jawaban Benar</label>
                            <select class="form-select" name="is_correct" required>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Soal Uraian -->
    <div class="modal fade" id="editUraianModal" tabindex="-1" aria-labelledby="editUraianModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('updatepretest') }}" method="POST" id="editUraianForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-uraian-id">
                    <input type="hidden" name="course_id" id="edit-uraian-course-id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUraianModalLabel">Edit Soal Uraian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="edit-uraian" class="form-label">Soal Uraian</label>
                            <textarea class="form-control" id="edit-uraian" name="pretest" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    // Edit Pilihan Ganda
    const editPilihanGandaModal = document.getElementById('editPilihanGandaModal');
    editPilihanGandaModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const id = button.getAttribute('data-id');
        const courseId = button.getAttribute('course-id');
        const soal = button.getAttribute('data-soal');
        const opsiA = button.getAttribute('data-opsi_a');
        const opsiB = button.getAttribute('data-opsi_b');
        const opsiC = button.getAttribute('data-opsi_c');
        const opsiD = button.getAttribute('data-opsi_d');
        const isCorrect = button.getAttribute('data-is_correct');

        document.getElementById('edit-pilihan-ganda-id').value = id;
        document.getElementById('edit-pilihan-ganda-course-id').value = courseId;
        document.getElementById('edit-pilihan-ganda').value = soal;
        document.getElementById('edit-opsi_a').value = opsiA;
        document.getElementById('edit-opsi_b').value = opsiB;
        document.getElementById('edit-opsi_c').value = opsiC;
        document.getElementById('edit-opsi_d').value = opsiD;
        document.querySelector(`select[name="is_correct"] option[value="${isCorrect}"]`).selected = true;
    });

    // Edit Uraian
    const editUraianModal = document.getElementById('editUraianModal');
    editUraianModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const id = button.getAttribute('data-id');
        const courseId = button.getAttribute('course-id');
        const soal = button.getAttribute('data-soal');

        document.getElementById('edit-uraian-id').value = id;
        document.getElementById('edit-uraian-course-id').value = courseId;
        document.getElementById('edit-uraian').value = soal;
    });

    document.addEventListener('DOMContentLoaded', function() {
        const jenisSoalSelect = document.getElementById('jenisSoalSelect');
        const pilihanGandaSection = document.getElementById('pilihanGandaSection');
        const uraianSection = document.getElementById('uraianSection');

        jenisSoalSelect.addEventListener('change', function() {
            if (this.value === 'pilihanGanda') {
                pilihanGandaSection.style.display = 'block';
                uraianSection.style.display = 'none';
            } else if (this.value === 'uraian') {
                pilihanGandaSection.style.display = 'none';
                uraianSection.style.display = 'block';
            }
        });
    });
</script>


@include('layout/foot')
</div>