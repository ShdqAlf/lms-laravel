@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Manual Book Ajaria</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Manual Book Ajaria</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Berikut Manual Book dari cara penggunaan sistem</h5>
    <iframe 
        src="https://docs.google.com/gview?url={{ asset($manualBook->file_manualbook) }}&embedded=true" 
        width="100%" 
        height="600px" 
        frameborder="0">
    </iframe>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('layout/foot')
</div>