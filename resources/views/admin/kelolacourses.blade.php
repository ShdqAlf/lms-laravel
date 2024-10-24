@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Kelola Kelola Courses</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Kelola Courses Siswa</li>
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
                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                                    Tambah Course
                                </button>
                            </div>

                            <!-- Tabel Courses -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Course</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $index => $course)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $course->course }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCourseModal"
                                                data-id="{{ $course->id }}"
                                                data-course="{{ $course->course }}">
                                                Edit
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('deletecourse', $course->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus course ini?')">Hapus</button>
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
    <!-- Modal Tambah Course -->
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('storecourse') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCourseModalLabel">Tambah Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="course">Nama Course:</label>
                            <input type="text" name="course" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Course -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editCourseForm" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="course">Nama Course:</label>
                            <input type="text" name="course" id="edit-course-name" class="form-control" required>
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
        // Modal Edit Course
        var editCourseModal = document.getElementById('editCourseModal')
        editCourseModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget
            var id = button.getAttribute('data-id')
            var course = button.getAttribute('data-course')

            var modalCourseName = document.getElementById('edit-course-name')
            var form = document.getElementById('editCourseForm')

            modalCourseName.value = course
            form.action = '/kelolacourses/update/' + id // Set form action URL
        })
    </script>
</div>

@include('layout/foot')
</div>