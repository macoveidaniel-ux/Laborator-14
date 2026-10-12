<?php
function afiseazaEroare(string $mesaj) {
    http_response_code(400);
    $mesajSigur = htmlspecialchars($mesaj, ENT_QUOTES, 'UTF-8');
    echo '<!DOCTYPE html><html lang="ro"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Eroare</title><script src="https://cdn.tailwindcss.com"></script></head><body class="bg-slate-50 h-screen flex items-center justify-center p-4"><div class="bg-white p-8 rounded-xl shadow-sm border border-red-100 max-w-md w-full text-center"><h1 class="text-2xl font-bold text-red-600 mb-4">Eroare la încărcare</h1><p class="text-slate-600 mb-6">' . $mesajSigur . '</p><a href="index.php" class="inline-block bg-slate-800 text-white font-semibold py-2 px-6 rounded-lg hover:bg-slate-700 transition-colors">Înapoi la galerie</a></div></body></html>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_FILES['file'])) {
    $dir = 'galerie';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_error = $_FILES['file']['error'];
    
    if ($file_error !== UPLOAD_ERR_OK) {
        afiseazaEroare("Fișierul nu a putut fi procesat.");
    }
    
    if ($file_size > 2 * 1024 * 1024) {
        afiseazaEroare("Imaginea depășește dimensiunea maximă admisă de 2 MB.");
    }
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file_tmp);
    finfo_close($finfo);
    
    $tipuri_permise = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($mime_type, $tipuri_permise)) {
        afiseazaEroare("Fișier corupt sau format nepermis. Folosiți doar JPG, PNG sau GIF.");
    }
    
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $extensii_permise = ["jpeg", "jpg", "png", "gif"];
    
    if (!in_array($file_ext, $extensii_permise)) {
         afiseazaEroare("Extensia fișierului nu este permisă.");
    }
    
    $nume_nou = uniqid('img_', true) . "." . $file_ext;
    $cale_finala = $dir . "/" . $nume_nou;
    
    if (!move_uploaded_file($file_tmp, $cale_finala)) {
        afiseazaEroare("A apărut o eroare la salvarea imaginii pe server.");
    }
    
    header('Location: index.php');
    exit;
} else {
    header('Location: index.php');
    exit;
}
?>