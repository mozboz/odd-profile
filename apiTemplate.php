<?php

/**
 * Template for API version specific configuration
 *
 * DO NOT INCLUDE THIS FILE!
 */


class api_config{

    private static $settings = array(
        // Set required variables in the POST and PUT calls here
        'requiredVariables' => array('POST' => array('url', 'owner', 'type', 'name'),
                                        'PUT' => array('key', 'value')),

        // If you want to use a key overwrite function, set it here, and definte it below!
        'overwriteKeyFunction' => 'overwriteKey'
    );
    public static function getSetting($key){
        if (isset(self::$settings[$key])) {
            return self::$settings[$key];
        } else {
            return false;
        }
    }

/**
 * Override data key name as requested by caller
 *
 * Receives the $_POST variable in $postVars, and the current data document in $data
 */

    public static function overwriteKey ($urlPath, $postVars, $data) {
        if ($postVars['MY_SPECIAL_KEY']) {
            if (isset($data[$postVars['MY_SPECIAL_KEY']])) {
                // oh noes, we have key collision, so use some special magic to make a new key
                $key = "123423423";
                return $key;
            }
        } else {
            // Don't want to do any special mapping, so just return
            return null ;
        }
    }
}