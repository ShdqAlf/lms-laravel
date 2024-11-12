@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Postest</h1> <!-- Menampilkan nama user -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Kerjakan Postest</li> <!-- Menampilkan role user -->
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
                            <!-- Container Content postest -->
                            <div id="content-3" class="p-4 bg-white">
                                <a href="#" onclick="showpostestModal(event)" class="d-flex align-items-center p-3 border border-gray-200 rounded-lg text-decoration-none text-dark hover-bg-light">
                                    <i class="bi bi-file-earmark-play-fill text-danger me-3" style="font-size: 1.8rem;"></i>
                                    <div>
                                        <p class="m-0 fw-bold">Kerjakan postest</p>
                                        <small class="text-muted">
                                            Kamu {{ $hasSubmitted ? 'Sudah' : 'Belum' }} Mengerjakan Postest. {{ $hasSubmitted ? 'Nilai Kamu: ': '' }} {{ $score ? $score->score : '' }}
                                        </small>
                                    </div>
                                </a>
                            </div>
                            <!-- End of Container Content postest -->
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="postestModal" tabindex="-1" aria-labelledby="postestModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="postestModalLabel">Konfirmasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $hasSubmitted ? 'Anda sudah mengerjakan postest dan tidak bisa mengisi kembali.' : 'Apakah kamu ingin memulai postest?' }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        @if(!$hasSubmitted)
                                        <a href="{{ route('showpostestQuestions') }}" class="btn btn-primary">Mulai postest</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Script to Show Modal -->
                        <script>
                            function showpostestModal(event) {
                                event.preventDefault();
                                var postestModal = new bootstrap.Modal(document.getElementById('postestModal'));
                                postestModal.show();
                            }
                        </script>

                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@include('layout/foot')
</div>