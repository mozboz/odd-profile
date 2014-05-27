<?php
require_once('common.php');
require_once('content_type_utils.php');

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        switch(true) {

            case headerIsJson():
                // Output raw JSON
                echo file_get_contents(JSON_PROFILE_FILENAME);

                logMessage('GET: Profile sent in JSON');
                break;

            case headerIsHtml():
                // Output pretty printed JSON to a browser
                require_once('pretty_print_json.php');

                echo '<pre>';
                echo json_format(file_get_contents(JSON_PROFILE_FILENAME));
                echo '</pre>';

                logMessage('GET: Profile sent in HTML');
                break;

        }
        break;


    case 'POST':

        $data = loadJsonProfile();
        logMessage('started post 1');
        if (empty($_POST['content']) && empty($_POST['category'])) {
            header('HTTP/1.1 400 Invalid Input');
            logMessage('POST Error: content field not set');
            exit(1);
        }
        logMessage('started post 2');
        if (!empty($_POST['category'])) {
            if (empty($_POST['content'])) {
                if (!isset($data[$_POST['category']])) {
                    $data[$_POST['category']] = array();
                    logMessage('POST: Writing new empty category');
                } else {
                    logMessage('POST: Can not write new empty category, already exists');
                }

            } else {
                if (!isset($data->$_POST['category'])) {
                    $data->$_POST['category'] = array($_POST['content']);
                    logMessage('POST: Appended new content to new category');
                } else {
                    $arr = $data->$_POST['category'];
                    $arr[] = $_POST['content'];
                    $data->$_POST['category'] = $arr;
                    logMessage('POST: Appended new content to existing category');
                }
            }
        } else {
           // from above check we know that if category empty, content must be populated
            $data[] = $_POST['content'];
            logMessage('POST: Add new top level content');
        }

        writeJsonProfile($data);
        break;

}

function loadJsonProfile() {
    return json_decode(file_get_contents(JSON_PROFILE_FILENAME));
}

function writeJsonProfile($data) {
    file_put_contents (JSON_PROFILE_FILENAME, json_encode($data));
}
?>
