<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie Foto</title>
    <!-- Folosim scriptul Tailwind pentru acces la toate funcționalitățile moderne -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-200 text-slate-800 font-sans p-4 md:p-8">
    
    <!-- Container Principal -->
    <main class="max-w-5xl mx-auto bg-white p-6 md:p-8 rounded-xl shadow-lg">
        
        <!-- Antet și Formular de Încărcare -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8 border-b border-slate-100 pb-6">
            <h1 class="text-3xl font-bold text-slate-800">Galeria Mea</h1>
            
            <form action="upload.php" method="post" enctype="multipart/form-data" class="flex items-center gap-3 w-full md:w-auto">
                <!-- Input personalizat curat -->
                <input type="file" name="file" accept="image/jpeg, image/png, image/gif" required 
                       class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg font-medium tranzition-colors">
                    Încarcă
                </button>
            </form>
        </div>

        <!-- Logica PHP pentru preluarea imaginilor -->
        <?php
        $uploadDir = 'uploads';
        $imagini = is_dir($uploadDir) ? array_diff(scandir($uploadDir), [".", ".."]) : [];
        ?>

        <!-- Secțiunea Galeriei -->
        <?php if (empty($imagini)): ?>
            <div class="text-center py-16 text-slate-400 bg-slate-50 rounded-lg border border-dashed border-slate-300">
                <p>Nicio imagine încărcată momentan. Folosește butonul de mai sus!</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($imagini as $imagine): ?>
                    <?php
                    $numeImagine = htmlspecialchars($imagine, ENT_QUOTES, 'UTF-8');
                    $fisierImagine = rawurlencode($imagine);
                    ?>
                    
                    <!-- Card Imagine -->
                    <div class="group bg-white rounded-lg overflow-hidden border border-slate-100 shadow-sm hover:shadow-md transition-all">
                        <!-- Poza -->
                        <a href="uploads/<?= $numeImagine; ?>" target="_blank" class="block h-48 overflow-hidden bg-slate-100">
                            <img src="uploads/<?= $numeImagine; ?>" alt="Foto" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </a>
                        
                    
                        <div class="flex justify-between items-center p-3 bg-slate-50 border-t border-slate-100">
                            <a href="download.php?file=<?= $fisierImagine; ?>" class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                                Descarcă
                            </a>
                            <a href="delete.php?file=<?= $fisierImagine; ?>" class="text-sm font-semibold text-red-500 hover:text-red-700" onclick="return confirm('Ștergi imaginea?');">
                                Șterge
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </main>
</body>
</html>