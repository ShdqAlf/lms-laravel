@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Mata Pelajaran {{ $course->course }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Modul, materi, dan LKPD dari mata pelajaran {{ $course->course }}</li>
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

        @if(session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
        @endif

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body" style="background-color: #E0FFFF;">
                            @if($silabus)
                            <p>{!! nl2br(e($silabus->deskripsi_silabus)) !!}</p>
                            @else
                            <p>Belum ada Silabus.</p>
                            @endif
                            <!-- Modul Section -->
                            <div class="border border-gray-300 mb-3 rounded-lg shadow-sm">
                                <button type="button" class="w-full px-4 py-3 text-left text-gray-700 border-0 rounded-top"
                                    style="background-color: #007bff; color: white;"
                                    onclick="toggleAccordion(1)">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Modul {{ $course->course }}</span>
                                        <i class="bi bi-chevron-down" id="icon-1"></i>
                                    </div>
                                </button>

                                <div id="content-1" class="p-4 bg-white border-top d-none">
                                    @if($modul)
                                    <a href="{{ route('showModul', $course->id) }}" class="d-flex align-items-center p-3 border border-gray-200 rounded-lg text-decoration-none text-dark hover-bg-light" style="color: {{ Auth::user()->materi_opened < 1 ? '#888' : '#007bff' }}; pointer-events: {{ Auth::user()->materi_opened < 1 ? 'none' : 'auto' }};">
                                        <i class="bi bi-file-earmark-text-fill text-primary me-3" style="font-size: 1.8rem;"></i>
                                        <div>

                                            <p class="m-0 fw-bold">Materi Modul</p>
                                            <small class="text-muted">File</small>
                                        </div>
                                    </a>
                                    @else
                                    <p>Belum ada Modul yang tersedia.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Pembelajaran Interaktif Section -->
                            <div class="border border-gray-300 mb-3 rounded-lg shadow-sm">
                                <button type="button" class="w-full px-4 py-3 text-left text-gray-700 border-0 rounded-top"
                                    style="background-color: #007bff; color: white;"
                                    onclick="toggleAccordion(3)">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Pembelajaran Interaktif {{ $course->course }}</span>
                                        <i class="bi bi-chevron-down" id="icon-3"></i>
                                    </div>
                                </button>
                                <div id="content-3" class="p-4 bg-white border-top d-none">
                                    @if($ppt)
                                    <a href="{{ route('showPpt', $course->id) }}" target="_blank" class="d-flex align-items-center p-3 border border-gray-200 rounded-lg text-decoration-none text-dark hover-bg-light" style="color: {{ Auth::user()->materi_opened < 2 ? '#888' : '#007bff' }}; pointer-events: {{ Auth::user()->materi_opened < 2 ? 'none' : 'auto' }};">
                                        <i class="bi bi-file-earmark-play-fill text-danger me-3" style="font-size: 1.8rem;"></i>
                                        <div>
                                            <p class="m-0 fw-bold">{{ $ppt->judul_ppt }}</p>
                                            <small class="text-muted">Klik untuk melihat Pembelajaran Interaktif</small>
                                        </div>
                                    </a>
                                    @else
                                    <p>Belum ada Pembelajaran yang tersedia.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- LKPD Section -->
                            <div class="border border-gray-300 mb-3 rounded-lg shadow-sm">
                                <button type="button" class="w-full px-4 py-3 text-left text-gray-700 border-0 rounded-top"
                                    style="background-color: #007bff; color: white;"
                                    onclick="toggleAccordion(2)">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">LKPD {{ $course->course }} (Individu)</span>
                                        <i class="bi bi-chevron-down" id="icon-2"></i>
                                    </div>
                                </button>
                                <div id="content-2" class="p-4 bg-white border-top d-none">
                                    @if($lkpd)
                                    <a href="{{ route('showLkpd', $course->id) }}" class="d-flex align-items-center p-3 border border-gray-200 rounded-lg text-decoration-none text-dark hover-bg-light" style="color: {{ Auth::user()->materi_opened < 3 ? '#888' : '#007bff' }}; pointer-events: {{ Auth::user()->materi_opened < 3 ? 'none' : 'auto' }};">
                                        <i class="bi bi-file-earmark-text-fill text-warning me-3" style="font-size: 1.8rem;"></i>
                                        <div>
                                            <p class="m-0 fw-bold">Materi LKPD</p>
                                            <small class="text-muted">Materi LKPD</small>
                                        </div>
                                    </a>
                                    <a href="{{ route('pengumpulanLkpd', $course->id) }}" class="d-flex align-items-center p-3 border border-gray-200 rounded-lg text-decoration-none text-dark hover-bg-light" style="color: {{ Auth::user()->materi_opened < 4 ? '#888' : '#007bff' }}; pointer-events: {{ Auth::user()->materi_opened < 4 ? 'none' : 'auto' }};">
                                        <i class="bi bi-file-earmark-text-fill text-success me-3" style="font-size: 1.8rem;"></i>
                                        <div>
                                            <p class="m-0 fw-bold">Pengumpulan LKPD</p>
                                            <small class="text-muted">Pengumpulan LKPD berupa file word</small>
                                        </div>
                                    </a>
                                    @else
                                    <p>Belum ada LKPD yang tersedia.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- LKPD Section -->
                            <div class="border border-gray-300 mb-3 rounded-lg shadow-sm">
                                <button type="button" class="w-full px-4 py-3 text-left text-gray-700 border-0 rounded-top"
                                    style="background-color: #007bff; color: white;"
                                    onclick="toggleAccordion(4)">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">LKPD {{ $course->course }} (Kelompok)</span>
                                        <i class="bi bi-chevron-down" id="icon-4"></i>
                                    </div>
                                </button>
                                <div id="content-4" class="p-4 bg-white border-top d-none">
                                    @if($lkpd_kelompok)
                                    <!-- Keterangan Kelompok -->
                                    <div class="mb-3 p-3 border rounded bg-light">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="m-0 fw-bold">
                                                    Kamu adalah {{ $kelompokNama }}
                                                    @if($isKetua)
                                                    , kamu adalah ketua kelompok.
                                                    @endif
                                                </p>
                                                @if(count($anggotaFormatted) > 0)
                                                <small class="text-muted">Anggota lainnya: {{ implode(', ', $anggotaFormatted) }}</small>
                                                @else
                                                <small class="text-muted">Tidak ada anggota lain dalam kelompok ini.</small>
                                                @endif
                                            </div>

                                            @if($isKetua)
                                            <!-- Jika sudah ada pembagian tugas, tombol berubah menjadi "Rubah Pembagian Tugas" -->
                                            <button type="button" class="btn {{ count($pembagianFormatted) > 0 ? 'btn-warning' : 'btn-primary' }} btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#pembagianTugasModal">
                                                {{ count($pembagianFormatted) > 0 ? 'Rubah Pembagian Tugas' : 'Pembagian Tugas' }}
                                            </button>
                                            @endif
                                        </div>

                                        <!-- Tampilkan daftar pembagian tugas -->
                                        @if(count($pembagianFormatted) > 0)
                                        <div class="mt-3 p-2 border rounded bg-light">
                                            <p class="fw-bold">Pembagian Tugas:</p>
                                            <ul class="m-0 p-0" style="list-style: none;">
                                                @foreach($soalLkpdKelompok as $index => $soal)
                                                <li>Nomor {{ $index + 1 }}: {{ $pembagianFormatted[$soal->id] ?? 'Belum Dibagi' }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                    </div>


                                    <a href="{{ route('lkpdkelompokquestions', $course->id) }}" class="d-flex align-items-center p-3 border border-gray-200 rounded-lg text-decoration-none text-dark hover-bg-light" style="color: {{ Auth::user()->materi_opened < 5 ? '#888' : '#007bff' }}; pointer-events: {{ Auth::user()->materi_opened < 5 ? 'none' : 'auto' }};">
                                        <i class="bi bi-file-earmark-text-fill text-success me-3" style="font-size: 1.8rem;"></i>
                                        <div>
                                            <p class="m-0 fw-bold">Kerjakan LKPD Kelompok</p>
                                            <small class="text-muted">
                                                Kamu {{ $hasSubmitted ? 'Sudah' : 'Belum' }} Mengerjakan Lkpd Kelompok.
                                                {{ $hasSubmitted ? 'Nilai Kelompokmu: ' : '' }}
                                            </small>
                                        </div>
                                    </a>
                                    @else
                                    <p>Belum ada LKPD yang tersedia.</p>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Pembagian Tugas -->
        <div class="modal fade" id="pembagianTugasModal" tabindex="-1" aria-labelledby="pembagianTugasModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pembagianTugasModalLabel">Pembagian Tugas LKPD</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formPembagianTugas" action="{{ route('storePembagianTugas') }}" method="POST">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">

                            @foreach($soalLkpdKelompok as $index => $soal)
                            <div class="mb-3">
                                <label class="form-label">Soal nomor {{ $index + 1 }}</label>
                                <select class="form-select" name="pembagian[{{ $soal->id }}]" required>
                                    <option value="">Pilih anggota</option>
                                    @foreach($anggotaKelompok as $anggota)
                                    <option value="{{ $anggota->id }}">{{ $anggota->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endforeach

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Pembagian</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    function toggleAccordion(id) {
        const content = document.getElementById(`content-${id}`);
        const icon = document.getElementById(`icon-${id}`);
        if (content.classList.contains('d-none')) {
            content.classList.remove('d-none');
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
        } else {
            content.classList.add('d-none');
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
        }
    }
</script>
@include('layout/foot')
</div>