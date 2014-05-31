<?php
require_once('common.php');

function headerIsOddProfile() {
    $jsonHeaders = array(ODD_PROFILE_MIME_TYPE. '.' . 'v' . ODD_PROFILE_VERSION . '+json');
    return matchHeader($jsonHeaders);
}

function headerIsHtml() {
    $htmlHeaders = array('text/html');
    return matchHeader($htmlHeaders);
}

function matchHeader($testHeaders) {
    $request_headers = apache_request_headers();
    $headers = explode("," , $request_headers['Accept']);
    foreach ($headers as $header) {
        if (in_array($header, $testHeaders)) {
            return true;
        }
    }
    return false;
}
