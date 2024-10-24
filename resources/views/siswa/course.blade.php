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
                                    @if($modul)
                                    <p>{{ $modul->deskripsi_modul }}</p>
                                    <embed type="application/pdf" src="{{ asset('storage/' . $modul->pdf_modul) }}" width="600" height="400"></embed>
                                    @else
                                    <p>Belum ada modul yang tersedia.</p>
                                    @endif
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
                                    @if($ppt)
                                    <p><a href="{{ $ppt->link_ppt }}" target="_blank">{{ $ppt->judul_ppt }}</a></p>
                                    @else
                                    <p>Belum ada PPT yang tersedia.</p>
                                    @endif
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
                                    @if($lkpd)
                                    <p>{{ $lkpd->deskripsi_lkpd }}</p>
                                    <embed type="application/pdf" src="{{ asset('storage/' . $lkpd->pdf_lkpd) }}" width="600" height="400"></embed>
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
    </div>
</div>

@include('layout/foot')
</div>