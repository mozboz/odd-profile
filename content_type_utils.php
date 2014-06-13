<?php
require_once('common.php');

/**
 * Checks all http Accept headers to see if this is an API request, denoted by a Accept header in format:
 *
 *     application/vnd.odd-profile.v4+json
 *
 * Where 'v4' denotes a version number
 *
 * If a file a name including the version number specified is found e.g. 'apiv4.php', it will be included to
 * load configuration custom to this api version
 *
 * @return bool
 */

function headerIsAPIRequest() {
    $jsonHeaders = array();
    for ($k = API_MINIMUM_SUPPORTED_VERSION; $k <= API_MAXIMUM_SUPPORTED_VERSION; $k++) {
        $jsonHeaders[] = ODD_PROFILE_MIME_TYPE. '.' . 'v' . $k . '+json';
    }

    if ($header = matchHeader($jsonHeaders)) {
        if (preg_match('~' . quotemeta('application/vnd.odd-profile') . '.' . 'v' . '(\d+)' . quotemeta('+json') . '~', $header, $matches)) {
            $apiFileName = 'apiv' . $matches[1] . '.php';
            if (!file_exists($apiFileName)) {
                logMessage("API include file " . $apiFileName . " missing!");
                httpErrorResponseAndExit(500,'API Configuration Missing');
            } else {
                require_once($apiFileName);
            }
        }
    }
    return matchHeader($jsonHeaders);
}

/**
 * Check all http Accept headers to see if this is a request for an html document
 * @return bool
 */
function headerIsHtml() {
    $htmlHeaders = array('text/html');
    return matchHeader($htmlHeaders);
}

function matchHeader($testHeaders) {
    $request_headers = apache_request_headers();
    $headers = explode("," , $request_headers['Accept']);
    foreach ($headers as $header) {
        if (in_array($header, $testHeaders)) {
            return $header;
        }
    }
    return false;
}
