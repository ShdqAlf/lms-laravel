@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Kelola Manual Book</h1> <!-- Menampilkan nama user -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Kelola Manual Book</li>
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
                            <form method="POST" action="{{ route('storekelolamanualbook') }}" enctype="multipart/form-data">
                                    @csrf
                            <div class="mb-3">
                                <label for="pdf_modul" class="form-label">Tambahkan file PDF Manual Book</label>
                                <input class="form-control" type="file" id="pdf_manualbook" name="file_manualbook">
                                <p>File sebelumnya: <a href="https://docs.google.com/gview?url={{ asset($manualBook->file_manualbook) }}&embedded=true" target="_blank">Lihat PDF</a></p>
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


@include('layout/foot')
</div>