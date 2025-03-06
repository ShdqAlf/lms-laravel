<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Membuat container untuk iframe */
        .ppt-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: calc(100vh - 100px);
            /* Mengurangi tinggi untuk memberi ruang pada button dan timer */
            overflow: hidden;
        }

        /* Mengatur iframe agar memenuhi container */
        .ppt-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Styling untuk countdown dan button */
        .controls {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #f8f9fa;
            padding: 10px;
            text-align: center;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        #countdown {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        #nextButton {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #nextButton:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

    <!-- Container untuk iframe PPT -->
    <div class="ppt-container">
        <iframe src="{{ $ppt->link_ppt }}" frameborder="0" allowfullscreen="true"></iframe>
    </div>

    <!-- Container untuk countdown dan button -->
    <div class="controls">
        <div id="countdown">Menuju Pembelajaran Selanjutnya: <span id="timer">02:00</span></div>
        <button id="nextButton" disabled>Lanjut ke LKPD</button>
    </div>

    <!-- Script untuk handle countdown dan button -->
    <script>
        // Waktu countdown dalam detik (2 menit = 120 detik)
        let timeLeft = 120;

        // Fungsi untuk mengupdate timer
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById('timer').textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            if (timeLeft > 0) {
                timeLeft--;
                setTimeout(updateTimer, 1000); // Update setiap 1 detik
            } else {
                // Jika timer habis, aktifkan button dan sembunyikan timer
                document.getElementById('nextButton').disabled = false;
                document.getElementById('countdown').style.display = 'none';
            }
        }

        // Fungsi untuk mengarahkan ke halaman LKPD
        document.getElementById('nextButton').addEventListener('click', function() {
            // Redirect ke halaman LKPD dengan ID course yang sesuai
            window.location.href = "{{ route('showLkpd', ['id' => $course->id]) }}";
        });

        // Mulai countdown saat halaman dimuat
        window.onload = updateTimer;
    </script>

</body>

</html>