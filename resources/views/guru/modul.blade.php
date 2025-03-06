<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View PDF</title>
    <style>
        /* Membuat container untuk iframe */
        .pdf-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        /* Mengatur iframe agar memenuhi container */
        .pdf-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="pdf-container">
        <iframe src="https://docs.google.com/gview?url={{ asset($modul->pdf_modul) }}&embedded=true" frameborder="0" allowfullscreen="true"></iframe>
    </div>
</body>

</html>
