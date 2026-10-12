<?php
$dir = 'galerie';
$thumbDir = 'galerie/thumbs';

if (!is_dir($dir)) mkdir($dir, 0755, true);
if (!is_dir($thumbDir)) mkdir($thumbDir, 0755, true);

$toateFisierele = array_diff(scandir($dir), [".", "..", "thumbs"]);
$imagini = array_filter($toateFisierele, function($file) use ($dir) {
    return is_file($dir . '/' . $file) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
});
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie de imagini</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">
    <main class="mx-auto max-w-4xl px-4 py-6 sm:px-6">
        <header class="mb-5 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Galerie de imagini</h1>
                <p class="mt-1 text-sm text-gray-600">Încarcă și gestionează imaginile.</p>
            </div>
            <span class="rounded-full bg-indigo-100 px-3 py-1 text-sm font-medium text-indigo-800">
                <?= count($imagini); ?>
                <?= count($imagini) === 1 ? 'imagine' : 'imagini'; ?>
            </span>
        </header>

        <section class="mb-5 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
            <form action="upload.php" method="post" enctype="multipart/form-data" class="sm:flex sm:items-end sm:space-x-3">
                <div class="flex-1">
                    <label for="file" class="mb-1 block text-sm font-medium text-gray-700">Adaugă o imagine</label>
                    <input
                        type="file"
                        name="file"
                        id="file"
                        accept="image/jpeg, image/png, image/gif"
                        required
                        class="block w-full rounded-md border border-gray-300 bg-white p-2 text-sm text-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    >
                    <p class="mt-1 text-xs text-gray-500">JPG, PNG sau GIF · maximum 2 MB</p>
                </div>
                <button
                    type="submit"
                    class="mt-3 w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto"
                >Încarcă</button>
            </form>
        </section>

        <section aria-label="Imagini încărcate">
            <?php if (empty($imagini)): ?>
                <p class="rounded-lg border border-dashed border-gray-300 bg-white px-4 py-8 text-center text-sm text-gray-500">
                    Nu există imagini. Încarcă prima imagine folosind formularul de mai sus.
                </p>
            <?php else: ?>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                    <?php foreach ($imagini as $imagine): ?>
                        <?php
                        $numeImagine = htmlspecialchars($imagine, ENT_QUOTES, 'UTF-8');
                        $fisierImagine = rawurlencode($imagine);
                        $caleAfisare = file_exists("$thumbDir/$imagine") ? "$thumbDir/$fisierImagine" : "galerie/$fisierImagine";
                        ?>
                        <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                            <a href="galerie/<?= $fisierImagine; ?>" target="_blank" aria-label="Afișează <?= $numeImagine; ?>">
                                <img
                                    src="<?= $caleAfisare; ?>"
                                    alt="<?= $numeImagine; ?>"
                                    loading="lazy"
                                    class="h-32 w-full bg-gray-100 object-cover"
                                >
                            </a>
                            <div class="flex items-center justify-between gap-2 p-2 text-xs font-medium">
                                <a href="download.php?file=<?= $fisierImagine; ?>" class="text-indigo-700 hover:text-indigo-900">Descarcă</a>
                                <a
                                    href="delete.php?file=<?= $fisierImagine; ?>"
                                    class="text-red-600 hover:text-red-800"
                                    aria-label="Șterge <?= $numeImagine; ?>"
                                >Șterge</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>