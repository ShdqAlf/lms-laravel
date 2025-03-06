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
                            <h5 class="card-title">Materi Modul</h5>
@if($modul)
    <p>{{ $modul->deskripsi_modul }}</p>
    <iframe 
        src="https://docs.google.com/gview?url={{ asset($modul->pdf_modul) }}&embedded=true" 
        width="100%" 
        height="600px" 
        frameborder="0">
    </iframe>
@else
    <p>Belum ada modul yang tersedia.</p>
@endif

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('layout/foot')
</div>