@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <nav>
            <h1>Postest</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Jawab tiap postest dibawah ini dengan jawaban berupa uraian</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('storeAnswers') }}" method="POST">
                                @csrf
                                <input type="text" name="user_id" class="hidden" value="{{ Auth::user()->id }}">
                                @foreach($questions as $index => $question)
                                <div class="mb-4">
                                    <h5>{{ $index + 1 }}. {{ $question->soal_postest }}</h5>
                                    <textarea name="jawaban[{{ $question->id }}]" class="form-control" placeholder="Masukkan jawaban Anda"></textarea>
                                </div>
                                @endforeach
                                <!-- Button to trigger modal -->
                                <button type="button" onclick="showSavepostestModal()" class="btn btn-primary">Simpan Jawaban</button>

                                <!-- Modal -->
                                <div class="modal fade" id="savepostestModal" tabindex="-1" aria-labelledby="savepostestModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="savepostestModalLabel">Konfirmasi Pengumpulan postest</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin mengumpulkan postest? Setelah dikumpulkan, postest tidak dapat dikerjakan lagi.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Kumpulkan Jawaban</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Script to Show Modal -->
                            <script>
                                function showSavepostestModal() {
                                    var savepostestModal = new bootstrap.Modal(document.getElementById('savepostestModal'));
                                    savepostestModal.show();
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@include('layout/foot')
</div>