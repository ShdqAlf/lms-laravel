@include('layout/head')
@include('layout/side')

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
                <li class="breadcrumb-item active">Kamu adalah {{ Auth::user()->role }} @if (Auth::user()->role === 'guru' && Auth::user()->course) {{ Auth::user()->course->course }} @endif</li> <!-- Menampilkan role user -->
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Heading to guide user -->
                            <h5 class="text-center mb-3">Klik pada kalender untuk melihat atau menambah kegiatan</h5>

                            <!-- Calendar Container -->
                            <div id="calendar-container" class="mb-3">
                                <div id="calendar"></div>
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
<script>
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