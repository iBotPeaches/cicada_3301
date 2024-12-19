<?php

// Directory to this file.
define('ROOT', dirname(__FILE__));

// Setup our locations for log file & file storage
$logFile = ROOT . '/log.txt';
$fileLocation = ROOT . '/files';

if (!is_file($logFile)) {
    file_put_contents($logFile, '');
}

if (!is_dir($fileLocation)) {
    mkdir($fileLocation, 0777, true);
}

// Dump $_GET, $_POST, and $_FILES if set
if (!empty($_GET)) {
    file_put_contents($logFile, 'GET: ' . print_r($_GET, true) . PHP_EOL, FILE_APPEND);
}

if (!empty($_POST)) {
    file_put_contents($logFile, 'POST: ' . print_r($_POST, true) . PHP_EOL, FILE_APPEND);
}

if (!empty($_FILES)) {
    foreach ($_FILES as $file) {
        $fileLocation = $fileLocation . '/' . $file['name'];
        move_uploaded_file($file['tmp_name'], $fileLocation);
        file_put_contents($logFile, 'FILE: ' . $fileLocation . PHP_EOL, FILE_APPEND);
    }
}

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Cicada Upload Service</title>
    </head>
    <body>
        <h1>Cicada Upload Service</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file" />
            <input type="submit" value="Upload" />
        </form>
    </body>
</html>
HTML;

echo $html;
