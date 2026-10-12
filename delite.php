<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file'])) {
    $file = basename($_POST['file']);
    $path = 'galerie/' . $file;
    $thumbPath = 'galerie/thumbs/' . $file;
    
    if (is_file($path)) {
        unlink($path);
    }
    if (is_file($thumbPath)) {
        unlink($thumbPath);
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
$fisierImagine = rawurlencode($file);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmă ștergerea</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="flex min-h-screen items-center justify-center bg-gray-100 px-4 py-6 text-gray-900">
    <main class="w-full max-w-md rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <h1 class="text-xl font-bold">Ștergi această imagine?</h1>
        <img src="galerie/<?= $fisierImagine; ?>" alt="<?= $numeImagine; ?>" class="mt-4 h-40 w-full rounded-md bg-gray-100 object-contain">
        <p class="mt-3 break-all text-sm text-gray-600"><?= $numeImagine; ?></p>
        <form action="delete.php" method="post" class="mt-5 flex items-center justify-end space-x-3">
            <input type="hidden" name="file" value="<?= $numeImagine; ?>">
            <a href="index.php" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Anulează</a>
            <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Șterge</button>
        </form>
    </main>
</body>
</html>