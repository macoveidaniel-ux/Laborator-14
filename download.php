<?php
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $path = "galerie/" . $file;
    
    if (file_exists($path) && is_file($path)) {
        $mime = mime_content_type($path);
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }
}
header('Location: index.php');
exit;
?>