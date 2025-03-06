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
            <h1>Pretest</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Jawab tiap pretest dibawah ini dengan jawaban berupa uraian</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Countdown Timer -->
                            <div class="mb-4" id="countdown-timer">
                                <h4>Waktu Tersisa: <span id="timer"></span></h4>
                            </div>

                            <form action="{{ route('storeAnswers') }}" method="POST">
                                @csrf
                                <input type="text" name="user_id" class="hidden" value="{{ Auth::user()->id }}">

                                <!-- Display Multiple Choice Questions -->
                                @foreach($multipleChoiceQuestions as $index => $question)
                                <div class="mb-4">
                                    <h5>{{ $index + 1 }}. {!! nl2br(e($question->soal_pretest)) !!}</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jawaban[{{ $question->id }}]" value="A" required>
                                        <label class="form-check-label" for="opsi_a">{{ $question->opsi_a }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jawaban[{{ $question->id }}]" value="B" required>
                                        <label class="form-check-label" for="opsi_b">{{ $question->opsi_b }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jawaban[{{ $question->id }}]" value="C" required>
                                        <label class="form-check-label" for="opsi_c">{{ $question->opsi_c }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jawaban[{{ $question->id }}]" value="D" required>
                                        <label class="form-check-label" for="opsi_d">{{ $question->opsi_d }}</label>
                                    </div>
                                </div>
                                @endforeach

                                <!-- Display Essay Questions -->
                                @foreach($essayQuestions as $index => $question)
                                <div class="mb-4">
                                    <h5>{{ $index + 1 }}. {!! nl2br(e($question->soal_pretest)) !!}</h5>
                                    <textarea name="jawaban[{{ $question->id }}]" class="form-control" placeholder="Masukkan jawaban Anda" required></textarea>

                                    <!-- Hidden input to store canvas image -->
                                    <input type="hidden" name="gambar_canvas[{{ $question->id }}]" id="gambar_canvas_{{ $question->id }}">
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                            <!-- Canvas for drawing -->
                                            <canvas id="canvas{{ $question->id }}" width="1000" height="300" class="border mt-3" style="display: block; margin: auto;"></canvas>

                                            <!-- Button container (row) -->
                                            <div style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                                                <button type="button" class="btn btn-secondary" onclick="clearCanvas('canvas{{ $question->id }}')">Bersihkan Kanvas</button>
                                                <button type="button" class="btn btn-info" onclick="enableRectangleDrawing('canvas{{ $question->id }}')">Gambar Persegi</button>
                                                <button type="button" class="btn btn-success" onclick="enableArrowDrawing('canvas{{ $question->id }}')">Gambar Panah</button>
                                                <button type="button" class="btn btn-primary" onclick="enableTextDrawing('canvas{{ $question->id }}')">Tambah Teks</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <!-- Button to trigger modal -->
                                <button type="button" onclick="showSavePretestModal()" class="btn btn-primary">Simpan Jawaban</button>

                                <!-- Modal -->
                                <div class="modal fade" id="savePretestModal" tabindex="-1" aria-labelledby="savePretestModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="savePretestModalLabel">Konfirmasi Pengumpulan Pretest</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin mengumpulkan pretest? Setelah dikumpulkan, pretest tidak dapat dikerjakan lagi.
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
                                function showSavePretestModal() {
                                    var savePretestModal = new bootstrap.Modal(document.getElementById('savePretestModal'));
                                    savePretestModal.show();
                                }
                                // Cek apakah sudah ada waktu mulai yang disimpan di session storage
                                let countdownDate = sessionStorage.getItem('countdownDate');

                                // Jika belum ada, set waktu mulai (misalnya 1 jam dari sekarang)
                                if (!countdownDate) {
                                    countdownDate = new Date().getTime() + 3600000; // 1 jam (3600000 ms)
                                    sessionStorage.setItem('countdownDate', countdownDate); // Simpan di session storage
                                } else {
                                    countdownDate = parseInt(countdownDate);
                                }

                                // Fungsi untuk mengupdate timer
                                var x = setInterval(function() {
                                    var now = new Date().getTime();
                                    var distance = countdownDate - now;

                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                    document.getElementById("timer").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

                                    // Jika countdown selesai
                                    if (distance < 0) {
                                        clearInterval(x);
                                        document.getElementById("timer").innerHTML = "Waktu Habis";
                                    }
                                }, 1000);

                                // Fungsi untuk reset countdown (misalnya, saat logout)
                                function resetCountdown() {
                                    sessionStorage.removeItem('countdownDate'); // Hapus waktu countdown di session storage
                                    location.reload(); // Reload halaman agar countdown dihitung ulang
                                }


                                let canvasObjects = {};

                                function setupCanvas(canvasId) {
                                    let canvas = document.getElementById(canvasId);
                                    let ctx = canvas.getContext('2d');

                                    canvasObjects[canvasId] = {
                                        ctx: ctx,
                                        isDrawingRectangle: false,
                                        isDrawingArrow: false,
                                        isDrawingText: false,
                                        isDraggingText: false,
                                        startX: null,
                                        startY: null,
                                        rectangles: [],
                                        arrows: [],
                                        texts: [],
                                        selectedText: null
                                    };

                                    canvas.addEventListener('mousedown', function(e) {
                                        let obj = canvasObjects[canvasId];
                                        let {
                                            offsetX,
                                            offsetY
                                        } = e;

                                        obj.selectedText = null;
                                        obj.isDraggingText = false;

                                        obj.texts.forEach(text => {
                                            if (
                                                offsetX >= text.x &&
                                                offsetX <= text.x + text.width &&
                                                offsetY >= text.y - text.height &&
                                                offsetY <= text.y
                                            ) {
                                                obj.selectedText = text;
                                                obj.isDraggingText = true;
                                            }
                                        });

                                        if (obj.isDraggingText) return;

                                        if (obj.isDrawingRectangle) {
                                            obj.startX = offsetX;
                                            obj.startY = offsetY;
                                        } else if (obj.isDrawingArrow) {
                                            obj.startX = offsetX;
                                            obj.startY = offsetY;
                                        } else if (obj.isDrawingText) {
                                            let text = prompt("Masukkan teks:");
                                            if (text) {
                                                ctx.font = "12px Arial";
                                                let textWidth = ctx.measureText(text).width;
                                                obj.texts.push({
                                                    text: text,
                                                    x: offsetX,
                                                    y: offsetY,
                                                    width: textWidth,
                                                    height: 12
                                                });
                                                redrawCanvas(canvasId);
                                            }
                                            obj.isDrawingText = false;
                                        }
                                    });

                                    canvas.addEventListener('mousemove', function(e) {
                                        let obj = canvasObjects[canvasId];
                                        let {
                                            offsetX,
                                            offsetY
                                        } = e;

                                        if (obj.isDraggingText && obj.selectedText) {
                                            obj.selectedText.x = offsetX - obj.selectedText.width / 2;
                                            obj.selectedText.y = offsetY;
                                            redrawCanvas(canvasId);
                                            return;
                                        }

                                        if (obj.isDrawingRectangle && obj.startX != null) {
                                            redrawCanvas(canvasId);
                                            let width = offsetX - obj.startX;
                                            let height = offsetY - obj.startY;
                                            obj.ctx.strokeRect(obj.startX, obj.startY, width, height);
                                        }

                                        if (obj.isDrawingArrow && obj.startX != null) {
                                            redrawCanvas(canvasId);
                                            drawArrow(obj.ctx, obj.startX, obj.startY, offsetX, offsetY);
                                        }
                                    });

                                    canvas.addEventListener('mouseup', function(e) {
                                        let obj = canvasObjects[canvasId];
                                        let {
                                            offsetX,
                                            offsetY
                                        } = e;

                                        if (obj.isDraggingText) {
                                            obj.isDraggingText = false;
                                            return;
                                        }

                                        if (obj.isDrawingRectangle && obj.startX != null) {
                                            let width = offsetX - obj.startX;
                                            let height = offsetY - obj.startY;
                                            obj.rectangles.push({
                                                x: obj.startX,
                                                y: obj.startY,
                                                width: width,
                                                height: height
                                            });
                                            obj.startX = obj.startY = null;
                                            redrawCanvas(canvasId);
                                        }

                                        if (obj.isDrawingArrow && obj.startX != null) {
                                            obj.arrows.push({
                                                x1: obj.startX,
                                                y1: obj.startY,
                                                x2: offsetX,
                                                y2: offsetY
                                            });
                                            obj.startX = obj.startY = null;
                                            redrawCanvas(canvasId);
                                        }
                                    });
                                }

                                function redrawCanvas(canvasId) {
                                    let obj = canvasObjects[canvasId];
                                    obj.ctx.clearRect(0, 0, obj.ctx.canvas.width, obj.ctx.canvas.height);

                                    obj.rectangles.forEach(rect => {
                                        obj.ctx.strokeRect(rect.x, rect.y, rect.width, rect.height);
                                    });

                                    obj.arrows.forEach(arrow => {
                                        drawArrow(obj.ctx, arrow.x1, arrow.y1, arrow.x2, arrow.y2);
                                    });

                                    obj.texts.forEach(text => {
                                        obj.ctx.font = "12px Arial";
                                        obj.ctx.fillText(text.text, text.x, text.y);
                                    });
                                }

                                function clearCanvas(canvasId) {
                                    let obj = canvasObjects[canvasId];
                                    obj.ctx.clearRect(0, 0, obj.ctx.canvas.width, obj.ctx.canvas.height);
                                    obj.rectangles = [];
                                    obj.arrows = [];
                                    obj.texts = [];
                                }

                                function enableRectangleDrawing(canvasId) {
                                    let obj = canvasObjects[canvasId];
                                    obj.isDrawingRectangle = true;
                                    obj.isDrawingArrow = false;
                                    obj.isDrawingText = false;
                                }

                                function enableArrowDrawing(canvasId) {
                                    let obj = canvasObjects[canvasId];
                                    obj.isDrawingArrow = true;
                                    obj.isDrawingRectangle = false;
                                    obj.isDrawingText = false;
                                }

                                function enableTextDrawing(canvasId) {
                                    let obj = canvasObjects[canvasId];
                                    obj.isDrawingText = true;
                                    obj.isDrawingRectangle = false;
                                    obj.isDrawingArrow = false;
                                }

                                function drawArrow(ctx, x1, y1, x2, y2) {
                                    let headlen = 10;
                                    let angle = Math.atan2(y2 - y1, x2 - x1);
                                    ctx.beginPath();
                                    ctx.moveTo(x1, y1);
                                    ctx.lineTo(x2, y2);
                                    ctx.stroke();

                                    ctx.beginPath();
                                    ctx.moveTo(x2, y2);
                                    ctx.lineTo(x2 - headlen * Math.cos(angle - Math.PI / 6), y2 - headlen * Math.sin(angle - Math.PI / 6));
                                    ctx.lineTo(x2 - headlen * Math.cos(angle + Math.PI / 6), y2 - headlen * Math.sin(angle + Math.PI / 6));
                                    ctx.closePath();
                                    ctx.stroke();
                                }

                                document.addEventListener('DOMContentLoaded', function() {
                                    @foreach($essayQuestions as $question)
                                    setupCanvas('canvas{{ $question->id }}');
                                    @endforeach
                                });

                                // Function to convert canvas to image and store it in hidden input
                                function saveCanvasAsImage(pretestId) {
                                    let canvas = document.getElementById('canvas' + pretestId);
                                    let imageData = canvas.toDataURL("image/png"); // Convert canvas to Base64
                                    document.getElementById('gambar_canvas_' + pretestId).value = imageData; // Store Base64 data
                                }

                                // Simpan semua gambar sebelum form dikirim
                                document.querySelector("form").addEventListener("submit", function(event) {
                                    @foreach($essayQuestions as $question)
                                    saveCanvasAsImage("{{ $question->id }}");
                                    @endforeach
                                });
                            </script>
                        </div>

                    </div>
                </div>
        </section>
    </div>
</div>

@include('layout/foot')
</div>