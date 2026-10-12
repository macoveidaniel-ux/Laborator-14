<?php
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $path = "galerie/" . $file;
    
    if (is_file($path)) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $path);
        finfo_close($finfo);
        
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }
}
header('Location: index.php');
exit;
?>