<?php
$dir = 'galerie';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
$imagini = array_diff(scandir($dir), [".", ".."]);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie Foto PRO</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <header class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-sm mb-8 border border-slate-100">
            <div>
                <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Galeria de Imagini</h1>
                <p class="text-sm text-slate-500 mt-1">Încarcă, vizualizează și gestionează pozele tale</p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-2 bg-blue-50 px-4 py-2 rounded-lg">
                <span class="text-blue-700 font-bold text-lg"><?= count($imagini) ?></span>
                <span class="text-blue-600 text-sm font-medium"><?= count($imagini) === 1 ? 'imagine' : 'imagini' ?></span>
            </div>
        </header>

        <section class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-slate-100">
            <form action="upload.php" method="post" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-4 items-center">
                <div class="flex-1 w-full">
                    <label for="file" class="block text-sm font-semibold text-slate-700 mb-2">Selectează o imagine</label>
                    <input type="file" name="file" id="file" accept="image/jpeg,image/png,image/gif" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors border border-slate-200 rounded-lg cursor-pointer">
                    <p class="mt-2 text-xs text-slate-400">JPG, PNG sau GIF · Maximum 2 MB</p>
                </div>
                <button type="submit" class="w-full md:w-auto mt-4 md:mt-0 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3 px-8 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                    Încarcă
                </button>
            </form>
        </section>

        <section aria-label="Imagini încărcate">
            <?php if (empty($imagini)): ?>
                <div class="bg-white rounded-xl border-2 border-dashed border-slate-200 p-12 text-center">
                    <p class="text-slate-500 text-lg">Nu ai încărcat nicio imagine încă.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php foreach ($imagini as $imagine): 
                        $numeImagine = htmlspecialchars($imagine, ENT_QUOTES, 'UTF-8');
                        $fisierImagine = rawurlencode($imagine);
                    ?>
                        <article class="group relative bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-slate-100">
                            <a href="galerie/<?= $numeImagine ?>" target="_blank" class="block aspect-square overflow-hidden bg-slate-100" aria-label="Afișează <?= $numeImagine ?>">
                                <img src="galerie/<?= $numeImagine ?>" alt="<?= $numeImagine ?>" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                            </a>
                            <div class="p-4 flex justify-between items-center bg-white border-t border-slate-50">
                                <a href="download.php?file=<?= $fisierImagine ?>" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">Descarcă</a>
                                <a href="delete.php?file=<?= $fisierImagine ?>" class="text-sm font-semibold text-red-500 hover:text-red-700 transition-colors">Șterge</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>