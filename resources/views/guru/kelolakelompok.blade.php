@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Kelola Kelompok</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Kelola Kelompok Siswa</li>
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
                            <!-- Tombol Tambah Course -->
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addKelompokModal">
                                    Tambah Kelompok
                                </button>
                            </div>

                            <!-- Tabel Kelompok -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Kelompok</th>
                                        <th>Anggota</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kelompok as $key => $group)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $group->nama_kelompok }}</td>
                                        <td>
                                            @foreach($group->users as $user)
                                            {{ $user->nama }}<br> <!-- Tampilkan nama anggota -->
                                            @endforeach
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editKelompokModal"
                                                data-id="{{ $group->id }}"
                                                data-nama_kelompok="{{ $group->nama_kelompok }}"
                                                data-anggota="{{ json_encode($group->users->map(function($user) { return ['id' => $user->id, 'nama' => $user->nama]; })) }}">
                                                Edit Kelompok
                                            </button>



                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('kelolakelompok.destroy', $group->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kelompok ini?')">Hapus</button>
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
    <!-- Modal Tambah Kelompok -->
    <div class="modal fade" id="addKelompokModal" tabindex="-1" aria-labelledby="addKelompokModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('kelolakelompok.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="course">Nama Kelompok:</label>
                            <input type="text" name="course" class="form-control" required>
                        </div>

                        <div class="form-group" id="anggota-container">
                            <label for="course">Anggota Kelompok:</label>
                            <div class="input-group">
                                <select name="anggota[]" class="form-select anggota-select" aria-label="Pilih Anggota Kelompok">
                                    <option selected>Pilih Anggota Kelompok</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nama }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-outline-secondary" type="button" id="tambahAnggota">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah Kelompok</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Modal Edit Kelompok -->
    <div class="modal fade" id="editKelompokModal" tabindex="-1" aria-labelledby="editKelompokModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editKelompokForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editKelompokModalLabel">Edit Kelompok</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="_method" value="PUT">
                        <!-- Nama Kelompok -->
                        <div class="form-group">
                            <label for="nama_kelompok">Nama Kelompok:</label>
                            <input type="text" name="nama_kelompok" class="form-control" id="edit-nama_kelompok" required>
                        </div>

                        <!-- Anggota Kelompok -->
                        <div class="form-group">
                            <label for="anggota">Anggota Kelompok:</label>
                            <div class="input-group">
                                <select name="anggota[]" class="form-select" id="edit-anggota" multiple required>
                                    <!-- Anggota akan diisi lewat JS -->
                                </select>
                                <button class="btn btn-outline-secondary" type="button" id="tambahAnggota">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
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

    <script>
        // Menambahkan anggota baru setiap kali tombol "+" diklik
        document.getElementById('tambahAnggota').addEventListener('click', function() {
            var container = document.getElementById('anggota-container');
            var select = document.createElement('select');
            select.name = 'anggota[]'; // Pastikan data anggota dikirim sebagai array
            select.classList.add('form-select');
            select.innerHTML = `
        <option selected>Pilih Anggota Kelompok</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->nama }}</option>
        @endforeach
    `;
            container.appendChild(select);
        });

        // Ketika modal edit kelompok dibuka, isi data ke dalam form
        var editKelompokModal = document.getElementById('editKelompokModal');
        editKelompokModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nama_kelompok = button.getAttribute('data-nama_kelompok');
            var anggota = JSON.parse(button.getAttribute('data-anggota')); // Anggota sekarang berupa array dengan key=id dan nama

            var modalNamaKelompok = document.getElementById('edit-nama_kelompok');
            var modalAnggota = document.getElementById('edit-anggota');
            var form = document.getElementById('editKelompokForm');

            // Set nama kelompok
            modalNamaKelompok.value = nama_kelompok;

            // Set anggota
            modalAnggota.innerHTML = ''; // Clear anggota yang ada
            anggota.forEach(function(user) {
                var option = document.createElement('option');
                option.value = user.id; // ID anggota
                option.selected = true; // Tandai anggota yang sudah ada
                option.text = user.nama; // Nama anggota
                modalAnggota.appendChild(option);
            });

            // Set form action URL
            form.action = '/kelolakelompok/' + id; // Set URL untuk mengupdate kelompok
        });
    </script>
</div>

@include('layout/foot')
</div>