@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Kelola Akun</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Kelola Akun Guru & Siswa</li>
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
                            <!-- Tombol Tambah Akun -->
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                                    Tambah Akun
                                </button>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIS</th>
                                        <th>Role</th>
                                        <th>Course</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->nomor_id }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>{{ $user->course->course ?? '-' }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="{{ $user->id }}"
                                                data-nama="{{ $user->nama }}"
                                                data-role="{{ $user->role }}"
                                                data-course_id="{{ $user->course_id }}">
                                                Edit
                                            </button>

                                            <!-- Tombol Ganti Password -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#passwordModal"
                                                data-id="{{ $user->id }}">
                                                Ganti Password
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('deleteakun', $user->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus akun ini?')">Hapus</button>
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

    <!-- Modal Tambah Akun -->
    <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addAccountForm" action="{{ route('storeakun') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAccountModalLabel">Tambah Akun</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_id">Nomor ID:</label>
                            <input type="text" name="nomor_id" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select name="role" class="form-control" required>
                                <option value="guru">Guru</option>
                                <option value="siswa">Siswa</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course_id">Course:</label>
                            <select name="course_id" class="form-control">
                                <option value="">Pilih Course (khusus untuk Guru)</option>
                                @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Akun</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="_method" value="POST">
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" name="nama" class="form-control" id="edit-nama">
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select name="role" class="form-control" id="edit-role">
                                <option value="guru">Guru</option>
                                <option value="siswa">Siswa</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course_id">Course:</label>
                            <select name="course_id" class="form-control" id="edit-course_id">
                                @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course }}</option>
                                @endforeach
                            </select>
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

    <!-- Modal Ganti Password -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="passwordForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="passwordModalLabel">Ganti Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="_method" value="POST">
                        <div class="form-group">
                            <label for="password">Password Baru:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password:</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Ganti Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Saat modal edit dibuka, data diisi ke dalam form
    var editModal = document.getElementById('editModal')
    editModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var nama = button.getAttribute('data-nama')
        var role = button.getAttribute('data-role')
        var course_id = button.getAttribute('data-course_id')

        var modalNama = document.getElementById('edit-nama')
        var modalRole = document.getElementById('edit-role')
        var modalCourse = document.getElementById('edit-course_id')
        var form = document.getElementById('editForm')

        modalNama.value = nama
        modalRole.value = role
        modalCourse.value = course_id
        form.action = '/kelolaakun/update/' + id // Set form action URL
    })

    // Saat modal ganti password dibuka, set form action URL
    var passwordModal = document.getElementById('passwordModal')
    passwordModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')

        var form = document.getElementById('passwordForm')
        form.action = '/kelolaakun/changepassword/' + id // Set form action URL
    })
</script>

@include('layout/foot')
</div>