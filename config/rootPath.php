<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
if (str_contains($rootPath, 'htdocs')) {
    $rootPath .= "\ERS-Web_Technologies";
}
