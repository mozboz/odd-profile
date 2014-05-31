<?php
define('JSON_PROFILE_FILENAME', 'profile.json');
define('LOG_FILENAME', 'log.txt');

define('ODD_PROFILE_MIME_TYPE', 'application/vnd.odd-profile');
define('ODD_PROFILE_VERSION', '1');

function logMessage($message) {
    $fh = fopen(LOG_FILENAME, 'a+');
    fputs($fh, $message."\n");
    fclose($fh);
}

?>