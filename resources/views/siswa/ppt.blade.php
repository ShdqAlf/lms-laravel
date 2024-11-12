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
            height: 100vh;
            /* Mengatur tinggi container sesuai dengan tinggi viewport */
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
    </style>
</head>

<body>

    <div class="ppt-container">
        <iframe src="{{ $ppt->link_ppt }}" frameborder="0" allowfullscreen="true"></iframe>
    </div>

</body>

</html>