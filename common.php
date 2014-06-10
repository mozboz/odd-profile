<?php
define('JSON_PROFILE_FILENAME', 'profile.json');
define('LOG_FILENAME', 'log.txt');
define('URL_PATH', 'urlPath');

define('ODD_PROFILE_MIME_TYPE', 'application/vnd.odd-profile');
define('API_MINIMUM_SUPPORTED_VERSION', '2');
define('API_MAXIMUM_SUPPORTED_VERSION', '3');

function logMessage($message) {
    $fh = fopen(LOG_FILENAME, 'a+');
    fputs($fh, $message."\n");
    fclose($fh);
}

function httpErrorResponseAndExit($errorCode, $serverErrorMessage) {
    header('HTTP/1.1 ' . $errorCode . ' ' . $serverErrorMessage);
    exit(1);
}

?>