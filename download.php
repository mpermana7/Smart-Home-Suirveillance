<?php
// download.php

if (isset($_GET['file'])) {
    // File path
    $file_path = 'video/' . $_GET['file'];

    // Check if file exists
    if (file_exists($file_path)) {
        // Set headers to initiate the download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        
        // Clear output buffer
        ob_clean();
        flush();
        
        // Read the file
        readfile($file_path);
        
        // Exit to ensure no further output is sent
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "No file specified.";
}
?>
