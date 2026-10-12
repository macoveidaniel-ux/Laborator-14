<?php
function afiseazaEroare(string $mesaj) {
    http_response_code(400);
    $mesajSigur = htmlspecialchars($mesaj, ENT_QUOTES, 'UTF-8');
    ?>
    <!DOCTYPE html>
    <html lang="ro">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Eroare la încărcare</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    </head>
    <body class="flex min-h-screen items-center justify-center bg-gray-100 px-4 py-6 text-gray-900">
        <main class="w-full max-w-md rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <h1 class="text-xl font-bold text-red-600">Imaginea nu a putut fi încărcată</h1>
            <p class="mt-2 text-sm text-gray-600"><?= $mesajSigur; ?></p>
            <a href="index.php" class="mt-4 inline-block rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Înapoi la galerie
            </a>
        </main>
    </body>
    </html>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_FILES['file'])) {
        $dir = 'galerie';
        $thumbDir = 'galerie/thumbs';

        if (!is_dir($dir)) mkdir($dir, 0755, true);
        if (!is_dir($thumbDir)) mkdir($thumbDir, 0755, true);

        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_error = $_FILES['file']['error'];
        
        if ($file_error !== UPLOAD_ERR_OK) {
            afiseazaEroare("Eroare tehnică la încărcare. (Cod: $file_error)");
        }

        $file_ext = strtolower(pathinfo(basename($file_name), PATHINFO_EXTENSION));
        $extensii_permise = ["jpg", "jpeg", "png", "gif"];
        
        if (!in_array($file_ext, $extensii_permise)) {
            afiseazaEroare("Selectați o imagine în format JPG, PNG sau GIF.");
        }

        if ($file_size > 2 * 1024 * 1024) {
            afiseazaEroare("Imaginea depășește dimensiunea maximă admisă de 2 MB.");
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file_tmp);
        finfo_close($finfo);
        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
            afiseazaEroare("Fișierul încărcat nu este o imagine validă.");
        }

        $nume_unic = uniqid('img_', true) . "." . $file_ext;
        $path = $dir . "/" . $nume_unic;
        $thumbPath = $thumbDir . "/" . $nume_unic;

        if (!move_uploaded_file($file_tmp, $path)) {
            afiseazaEroare("A apărut o eroare la salvarea imaginii. Încercați din nou.");
        }

        $thumbWidth = 400;
        if ($mimeType == 'image/jpeg') $sursa = imagecreatefromjpeg($path);
        elseif ($mimeType == 'image/png') $sursa = imagecreatefrompng($path);
        elseif ($mimeType == 'image/gif') $sursa = imagecreatefromgif($path);
        
        if (isset($sursa) && $sursa !== false) {
            $width = imagesx($sursa);
            $height = imagesy($sursa);
            $thumbHeight = floor($height * ($thumbWidth / $width));
            
            $virtualImagine = imagecreatetruecolor($thumbWidth, $thumbHeight);
            
            if ($mimeType == 'image/png' || $mimeType == 'image/gif') {
                imagecolortransparent($virtualImagine, imagecolorallocatealpha($virtualImagine, 0, 0, 0, 127));
                imagealphablending($virtualImagine, false);
                imagesavealpha($virtualImagine, true);
            }
            
            imagecopyresampled($virtualImagine, $sursa, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
            
            if ($mimeType == 'image/jpeg') imagejpeg($virtualImagine, $thumbPath, 80);
            elseif ($mimeType == 'image/png') imagepng($virtualImagine, $thumbPath, 8);
            elseif ($mimeType == 'image/gif') imagegif($virtualImagine, $thumbPath);
            
            imagedestroy($virtualImagine);
            imagedestroy($sursa);
        }

        header('location:index.php');
        exit;
    }
}
?>