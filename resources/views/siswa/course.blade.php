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
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Modul Section -->
                            <div class="border border-gray-300 mb-3 rounded-lg shadow-sm">
                                <button type="button" class="w-full px-4 py-3 text-left text-gray-700 bg-light border-0 rounded-top"
                                    onclick="toggleAccordion(1)">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Modul {{ $course->course }}</span>
                                        <i class="bi bi-chevron-down" id="icon-1"></i>
                                    </div>
                                </button>
                                <div id="content-1" class="p-4 bg-white border-top d-none">
                                    @if($modul)
                                    <a href="{{ route('showModul', $modul->id) }}" class="d-flex align-items-center p-3 border border-gray-200 rounded-lg text-decoration-none text-dark hover-bg-light">
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
                            <!-- LKPD Section -->
                            <div class="border border-gray-300 mb-3 rounded-lg shadow-sm">
                                <button type="button" class="w-full px-4 py-3 text-left text-gray-700 bg-light border-0 rounded-top"
                                    onclick="toggleAccordion(2)">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">LKPD {{ $course->course }}</span>
                                        <i class="bi bi-chevron-down" id="icon-2"></i>
                                    </div>
                                </button>
                                <div id="content-2" class="p-4 bg-white border-top d-none">
                                    @if($lkpd)
                                    <a href="{{ route('showLkpd', $lkpd->id) }}" class="d-flex align-items-center p-3 border border-gray-200 rounded-lg text-decoration-none text-dark hover-bg-light">
                                        <i class="bi bi-file-earmark-text-fill text-success me-3" style="font-size: 1.8rem;"></i>
                                        <div>
                                            <p class="m-0 fw-bold">Materi LKPD</p>
                                            <small class="text-muted">File</small>
                                        </div>
                                    </a>
                                    @else
                                    <p>Belum ada LKPD yang tersedia.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- PPT Section -->
                            <div class="border border-gray-300 mb-3 rounded-lg shadow-sm">
                                <button type="button" class="w-full px-4 py-3 text-left text-gray-700 bg-light border-0 rounded-top"
                                    onclick="toggleAccordion(3)">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">PPT {{ $course->course }}</span>
                                        <i class="bi bi-chevron-down" id="icon-3"></i>
                                    </div>
                                </button>
                                <div id="content-3" class="p-4 bg-white border-top d-none">
                                    @if($ppt)
                                    <a href="{{ route('showPpt', $ppt->id) }}" target="_blank" class="d-flex align-items-center p-3 border border-gray-200 rounded-lg text-decoration-none text-dark hover-bg-light">
                                        <i class="bi bi-file-earmark-play-fill text-danger me-3" style="font-size: 1.8rem;"></i>
                                        <div>
                                            <p class="m-0 fw-bold">{{ $ppt->judul_ppt }}</p>
                                            <small class="text-muted">Klik untuk melihat PPT</small>
                                        </div>
                                    </a>
                                    @else
                                    <p>Belum ada PPT yang tersedia.</p>
                                    @endif
                                </div>
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