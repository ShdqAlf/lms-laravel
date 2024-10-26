@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Kelola Materi</h1> <!-- Menampilkan nama user -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Kelola Materi {{ Auth::user()->course->course }}</li> <!-- Menampilkan role user -->
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="w-full">
                                <form method="POST" action="{{ route('storekelolamateri') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ Auth::user()->course->id }}">
                                    <div class="form-group mb-3">
                                        <label for="deskripsi_silabus" class="form-label">Masukkan Deskripsi Silabus</label>
                                        <textarea class="form-control" id="deskripsi_silabus" name="deskripsi_silabus" rows="3" required>{{ old('deskripsi_silabus', $silabus->deskripsi_silabus ?? '') }}</textarea>
                                    </div>
                                    <!-- Modul Section -->
                                    <div class="border border-gray-300 mb-2 rounded-lg">
                                        <button type="button" class="w-full px-4 py-2 text-left text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none"
                                            onclick="toggleAccordion(1)">
                                            <div class="flex justify-between items-center">
                                                <span>Modul</span>
                                                <svg class="w-5 h-5" id="icon-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </button>
                                        <div id="content-1" class="hidden p-4 bg-white">
                                            <div class="form-group mb-3">
                                                <label for="deskripsi_modul" class="form-label">Masukkan Deskripsi Modul</label>
                                                <textarea class="form-control" id="deskripsi_modul" name="deskripsi_modul" rows="3" required>{{ old('deskripsi_modul', $modul->deskripsi_modul ?? '') }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pdf_modul" class="form-label">Tambahkan file PDF Modul</label>
                                                <input class="form-control" type="file" id="pdf_modul" name="pdf_modul">
                                                @if(isset($modul->pdf_modul))
                                                <p>File sebelumnya: <a href="{{ asset('storage/' . $modul->pdf_modul) }}" target="_blank">Lihat PDF</a></p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PPT Section -->
                                    <div class="border border-gray-300 mb-2 rounded-lg">
                                        <button type="button" class="w-full px-4 py-2 text-left text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none"
                                            onclick="toggleAccordion(2)">
                                            <div class="flex justify-between items-center">
                                                <span>PPT</span>
                                                <svg class="w-5 h-5" id="icon-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </button>
                                        <div id="content-2" class="hidden p-4 bg-white">
                                            <div class="form-group">
                                                <label for="judul_ppt">Tambahkan Judul Presentasi</label>
                                                <input type="text" class="form-control" id="judul_ppt" name="judul_ppt" value="{{ old('judul_ppt', $ppt->judul_ppt ?? '') }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="link_ppt">Tambahkan Link PPT</label>
                                                <input type="text" class="form-control" id="link_ppt" name="link_ppt" value="{{ old('link_ppt', $ppt->link_ppt ?? '') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- LKPD Section -->
                                    <div class="border border-gray-300 mb-2 rounded-lg">
                                        <button type="button" class="w-full px-4 py-2 text-left text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none"
                                            onclick="toggleAccordion(3)">
                                            <div class="flex justify-between items-center">
                                                <span>LKPD</span>
                                                <svg class="w-5 h-5" id="icon-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </button>
                                        <div id="content-3" class="hidden p-4 bg-white">
                                            <div class="form-group mb-3">
                                                <label for="deskripsi_lkpd" class="form-label">Masukkan Deskripsi LKPD</label>
                                                <textarea class="form-control" id="deskripsi_lkpd" name="deskripsi_lkpd" rows="3" required>{{ old('deskripsi_lkpd', $lkpd->deskripsi_lkpd ?? '') }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pdf_lkpd" class="form-label">Tambahkan File PDF LKPD</label>
                                                <input class="form-control" type="file" id="pdf_lkpd" name="pdf_lkpd">
                                                @if(isset($lkpd->pdf_lkpd))
                                                <p>File sebelumnya: <a href="{{ asset('storage/' . $lkpd->pdf_lkpd) }}" target="_blank">Lihat PDF</a></p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success mb-3">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>
<script>
    function toggleAccordion(id) {
        const content = document.getElementById(`content-${id}`);
        const icon = document.getElementById(`icon-${id}`);

        // Toggle visibility
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.style.transform = "rotate(180deg)"; // Rotate down
        } else {
            content.classList.add('hidden');
            icon.style.transform = "rotate(0deg)"; // Rotate back up
        }
    }
</script>
@include('layout/foot')
</div>