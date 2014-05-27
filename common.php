<?php
define('JSON_PROFILE_FILENAME', 'profile.json');
define('LOG_FILENAME', 'log.txt');

function logMessage($message) {
    $fh = fopen(LOG_FILENAME, 'a+');
    fputs($fh, $message."\n");
    fclose($fh);
}

?>