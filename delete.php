<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file'])) {
    $file = basename($_POST['file']);
    $path = 'galerie/' . $file;
    if (is_file($path)) {
        unlink($path);
    }
    header('Location: index.php');
    exit;
}

if (!isset($_GET['file'])) {
    header('Location: index.php');
    exit;
}

$file = basename($_GET['file']);
$path = 'galerie/' . $file;
if (!is_file($path)) {
    header('Location: index.php');
    exit;
}

$numeImagine = htmlspecialchars($file, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmare Ștergere</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <main class="bg-white p-8 rounded-xl shadow-sm border border-slate-100 max-w-md w-full">
        <h1 class="text-2xl font-bold text-slate-800 text-center mb-6">Ștergi această imagine?</h1>
        <div class="rounded-lg overflow-hidden border border-slate-100 mb-6 bg-slate-50">
            <img src="galerie/<?= $numeImagine ?>" alt="<?= $numeImagine ?>" class="w-full h-48 object-contain">
        </div>
        <form action="delete.php" method="post" class="flex gap-4">
            <input type="hidden" name="file" value="<?= $numeImagine ?>">
            <a href="index.php" class="flex-1 bg-slate-100 text-slate-700 font-semibold text-center py-3 px-4 rounded-lg hover:bg-slate-200 transition-colors">
                Anulează
            </a>
            <button type="submit" class="flex-1 bg-red-500 text-white font-semibold py-3 px-4 rounded-lg hover:bg-red-600 transition-colors shadow-sm">
                Confirmă
            </button>
        </form>
    </main>
</body>
</html>