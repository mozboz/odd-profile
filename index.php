<?php
require_once('common.php');
require_once('content_type_utils.php');

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':   // REQUEST ALL OR PART OF DATA

        // If a path is specified in the URL, it is passed in the variable $_GET['urlPath'] by mod_rewrite
        // If this value is set, return that node from the JSON document, otherwise return the whole document.

        $data = loadJsonProfile();

        $urlPath = parseUrlPath($_REQUEST['urlPath']);

        if ($urlPath = $_REQUEST['urlPath']) {
            if (isset($data->$urlPath)) {
                $sendData = $data->$urlPath;
            } else {
                echo '<img src="http://cdn.memegenerator.net/instances/500x/37298356.jpg">';
                logMessage('GET Error: ' . $urlPath . ' document not found');
                httpErrorResponseAndExit(404, 'Context Not Found');
                break;
            }
        } else {
            $sendData = $data;
        }

        if (headerIsAPIRequest()) {
            echo json_encode($sendData);
            if (empty($urlPath)) { $urlPath = "ALL"; }
            logMessage('GET: ' . $urlPath . ' sent in JSON');
            break;
        } else {
            require_once('pretty_print_json.php');

            echo '<pre>';
            echo stripslashes(json_format($sendData));
            echo '</pre>';

            logMessage('GET: ' . $urlPath . ' Profile sent in HTML');
        }

        break;

    case 'POST':

        // Creates a new resource in the document, and returns the key of the resource created

        exitIfNoApiHeader();

        exitIfMissingRequiredFields('POST', $_POST);

        $urlPath = parseUrlPath($_REQUEST['urlPath']);
        $data = loadJsonProfile();

        // Check if the key mapping function is implemented. If so, call it, but only
        // change the key if the function returns a value!

        // Duplicate checking on the key will only be done if there is no custom handler, so if you
        // do not want the same key to be overwritten, add the appropriate logic to your custom handler

        if ( $overwriteKeyFunction = api_config::getSetting('overwriteKeyFunction')) {
            $resetUrlPath = api_config::$overwriteKeyFunction($urlPath, $_POST, $data);
            if (!empty($resetUrlPath)) {
                $urlPath = $resetUrlPath;
            }
        } else {
            if (getContext($data, $urlPath)) {
                logMessage('POST Error: Tried to create existing context at ' . $urlPath);
                httpErrorResponseAndExit(409, '409 Resource Already Exists');
            }
        }

        $o = new stdClass();
        $o->content = new stdClass();

        $allRequiredFields = api_config::getSetting('requiredVariables');

        foreach ($allRequiredFields['POST'] as $fieldName) {
            $o->$fieldName = $_POST[$fieldName];
        }

        // Return key, so caller can check if it was reassigned by $idHook function
        // @todo validate URL matches actual URL!
        echo "{'urlPath':'" . $urlPath ."'}";

        $data->$urlPath = $o;

        writeJsonProfile($data);
        break;

    case 'PUT':     // Add a new entry to an existing context

        exitIfNoApiHeader();

        parse_str(file_get_contents('php://input'), $params);
        exitIfMissingRequiredFields('PUT', $params);

        $urlPath = parseUrlPath($params['urlPath']);

        $data = loadJsonProfile();

        exitIfPathNotFound($data, $urlPath);

        // Find the node to add content to
        $addNode = $data->$urlPath->{api_config::getSetting('contentNode')};

        $addNode->$params['key'] = $params['value'];

        writeJsonProfile($data);

        break;
}

function exitIfPathNotFound($data, $path) {
    if (!isset($data->$path)) {
        logMessage('Tried to PUT to non existent path: ' + $path);
        httpErrorResponseAndExit(400, '400 Invalid Input - Path not found');
    }
}

function exitIfNoApiHeader() {
    if (!headerIsAPIRequest()) {
        logMessage('POST Error: header not recognised');
        httpErrorResponseAndExit(400, '400 Invalid Input - Header not recognised');
    }
}

/**
 * @param $callType     POST, PUT, etc.
 * @param $vars         Variables from client
 *
 * Check that for the call type given, the required variables are set in $vars
 */
function exitIfMissingRequiredFields($callType, $vars) {

    $fields = api_config::getSetting('requiredVariables');

    foreach ($fields[$callType] as $fieldName) {
        if (empty($vars[$fieldName])) {
            logMessage($callType . ' Error: ' . $fieldName . ' field not set');
            httpErrorResponseAndExit(400, 'Invalid Input - ' . $fieldName . ' missing');
        }
    }
}

function loadJsonProfile() {
    return json_decode(file_get_contents(JSON_PROFILE_FILENAME));
}

function writeJsonProfile($data) {
    file_put_contents (JSON_PROFILE_FILENAME, json_encode($data));
}

// Get file for a particular query path
function getContext($data, $urlPath) {
    if (isset($data->$urlPath)) {
        return $data->$urlPath;
    } else {
        return false;
    }
}

// If path supplied is empty (i.e. profile root requested), use '/' as path
function parseUrlPath($path) {
    if (empty($path)) {
        return '/';
    } else {
        return $path;
    }
}
?>
