<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
if (str_contains($rootPath, 'htdocs') and str_contains($rootPath, 'xampp')) {
    $rootPath .= "\ERS-Web_Technologies";
}