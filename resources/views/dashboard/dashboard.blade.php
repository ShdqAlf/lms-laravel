@include('layout/head')
@include('layout/side')
<style>
    .d-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .text-end {
        text-align: right;
    }
</style>
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Selamat Datang, {{ Auth::user()->nama }}</h1> <!-- Menampilkan nama user -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Kamu adalah {{ Auth::user()->role }}</li> <!-- Menampilkan role user -->
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @endif
                            @if (Auth::user()->role == 'guru')
                            <div class="row">
                                <!-- Wrapper untuk menyelaraskan tabel Kehadiran dan Penugasan -->
                                <div class="d-flex flex-wrap justify-content-between">
                                    <!-- Tabel Status Kehadiran Siswa -->
                                    <div class="col-12 col-lg-5">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0" style="color: white;">Status Kehadiran Siswa</h5>
                                            </div>
                                            <div class="card-body" style="background-color: #E0FFFF;">
                                                <table class="table table-bordered table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama</th>
                                                            <th>NIS</th>
                                                            <th>Kehadiran</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($students as $student)
                                                        <tr>
                                                            <td>{{ $student->nama }}</td>
                                                            <td>{{ $student->nomor_id }}</td>
                                                            <td class="text-center">{{ $student->status_kehadiran }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabel Jumlah Penugasan Belum Terkumpul -->
                                    <div class="col-12 col-lg-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0" style="color: white;">Jumlah Penugasan Belum Terkumpul</h5>
                                            </div>
                                            <div class="card-body" style="background-color: #E0FFFF;">
                                                <table class="table table-borderless table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Penugasan</th>
                                                            <th class="text-end">Jumlah</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Pretest</td>
                                                            <td class="text-end">{{ $jumlahBelumPretest }} Siswa</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Postest</td>
                                                            <td class="text-end">{{ $jumlahBelumPostest }} Siswa</td>
                                                        </tr>
                                                        @foreach ($courses as $course)
                                                        <tr>
                                                            <td>LKPD {{ $course->course }}</td>
                                                            <td class="text-end">{{ $jumlahBelumLkpd[$course->id] }} Siswa</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabel Status Pengumpulan Penugasan Siswa -->
                                <div class="col-12 mt-3">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0" style="color: white;">Tabel Status Pengumpulan Penugasan Siswa</h5>
                                        </div>
                                        <div class="card-body" style="background-color: #E0FFFF;">
                                            <div class="table-responsive">
                                                <!-- kalo mau balikin datatablenya tinggal isi id="datatable"-->
                                                <table id="" class="table table-bordered table-striped table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Siswa</th>
                                                            <th>NIS</th>
                                                            <th>Pretest</th>
                                                            @foreach ($courses as $course)
                                                            <th>{{ $course->course }}</th>
                                                            @endforeach
                                                            <th>Postest</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
                                                        @foreach($students as $index => $student)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $student->nama }}</td>
                                                            <td>{{ $student->nomor_id }}</td>

                                                            <!-- Status Pretest -->
                                                            <td class="{{ $student->status_pengisian_pretest === 'Sudah Mengisi' ? 'text-success' : 'text-danger' }}">
                                                                {{ $student->status_pengisian_pretest }}
                                                            </td>

                                                            <!-- Status LKPD untuk setiap course -->
                                                            @foreach ($courses as $course)
                                                            <td class="{{ ($student->status_pengisian_lkpd[$course->id] ?? 'Belum Mengisi') === 'Sudah Mengisi' ? 'text-success' : 'text-danger' }}">
                                                                {{ $student->status_pengisian_lkpd[$course->id] ?? 'Belum Mengisi' }}
                                                            </td>
                                                            @endforeach

                                                            <!-- Status Postest -->
                                                            <td class="{{ $student->status_pengisian_postest === 'Sudah Mengisi' ? 'text-success' : 'text-danger' }}">
                                                                {{ $student->status_pengisian_postest }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif


                            @if (Auth::user()->role == 'siswa')
                            <div class="card" style="background-color: #E0FFFF;">
                                <div class="card-header" style="background-color: #E0FFFF;"">
                                    <h4>Kartu Nilai Siswa</h4>
                                </div>
                                <div class=" card-body">
                                    <p><strong>Nama:</strong> {{ $student->nama }}</p>
                                    <p><strong>NIS:</strong> {{ $student->nomor_id }}</p>
                                    <!-- <p><strong>Kehadiran:</strong>
                                        @if ($hadirHariIni)
                                        <span class="badge bg-success">Hadir</span>
                                        @else
                                    <form action="{{ route('markAttendance') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Klik untuk Hadir</button>
                                    </form>
                                    @endif -->

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Jenis Penugasan</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Nilai Pretest -->
                                            <tr>
                                                <td>Pretest</td>
                                                <td>{{ $student->nilai_pretest }}</td>
                                            </tr>

                                            <!-- Nilai LKPD -->
                                            @foreach ($courses as $course)
                                            <tr>
                                                <td>LKPD {{ $course->course }}</td>
                                                <td>{{ $student->nilai_lkpd[$course->id] }}</td>
                                            </tr>
                                            @endforeach

                                            <!-- Nilai Postest -->
                                            <tr>
                                                <td>Postest</td>
                                                <td>{{ $student->nilai_postest }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="text-center mb-3">Klik pada kalender untuk melihat atau menambah kegiatan</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Calendar Container -->
                                            <div id="calendar-container" class="mb-3">
                                                <div id="calendar"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Add Event Modal -->
                            <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addEventModalLabel">Tambah Kegiatan Baru</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form using POST method -->
                                            <form action="{{ route('storeEvent') }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="eventTitle" class="form-label">Deskripsi Kegiatan</label>
                                                    <input type="text" class="form-control" id="eventTitle" name="deskripsi_kegiatan" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="eventDate" class="form-label">Tanggal</label>
                                                    <input type="date" class="form-control" id="eventDate" name="tanggal_kegiatan" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Add Event Modal -->
                            <!-- View Event Modal -->
                            <div class="modal fade" id="viewEventModal" tabindex="-1" aria-labelledby="viewEventModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewEventModalLabel">Detail Kegiatan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p id="eventDescription"></p> <!-- This will hold the event description -->
                                            <p id="eventDateDetail"></p> <!-- This will hold the event date -->
                                            <p id="eventAddedBy"></p> <!-- This will hold the user information -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- JavaScript for Calendar and Event Addition -->
<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<!-- Optionally include Bootstrap integration styles -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/bootstrap/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.global.min.js'></script>

<!-- Include jQuery and DataTables JS and CSS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable with scroll and fixed header options
        $('#datatable').DataTable({
            "scrollY": "300px", // Enable vertical scrolling
            "scrollCollapse": true, // Allow the table to collapse with scrolling
            "paging": true, // Enable paging
            "fixedHeader": true // Fix the header to stay at the top while scrolling
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const events = @json($events); // Load existing events from backend

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: events.map(event => ({
                title: event.title,
                start: event.start,
                color: event.color, // Set the color based on the backend logic
                extendedProps: {
                    user: event.user // Pass user details to use in other functions if needed
                }
            })),
            dateClick: function(info) {
                // Populate the form's date input when a date is clicked
                document.getElementById('eventDate').value = info.dateStr;

                // Open the modal
                const addEventModal = new bootstrap.Modal(document.getElementById('addEventModal'));
                addEventModal.show();
            },
            eventClick: function(info) {
                // Populate modal with event details
                document.getElementById('eventDescription').textContent = info.event.title;
                document.getElementById('eventDateDetail').textContent = `Tanggal: ${info.event.start.toLocaleDateString()}`;

                // Display the user who added the event
                const addedBy = info.event.extendedProps.user ? info.event.extendedProps.user.nama : 'Tidak diketahui';
                document.getElementById('eventAddedBy').textContent = `Ditambahkan oleh: ${addedBy}`;

                // Show the modal
                const viewEventModal = new bootstrap.Modal(document.getElementById('viewEventModal'));
                viewEventModal.show();
            }
        });
        calendar.render();
    });
</script>


@include('layout/foot')
</div>