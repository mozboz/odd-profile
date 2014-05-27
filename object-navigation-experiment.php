<?php

// This is an experiment to see how easy it is to navigate
// through a PHP object, creating objects/arrays along
// the way.

// A node in a document could be addressed with a path, and
// a value written/added at that path.

$path = "top/posts/conversations/conversation-1";

$content = "hello";

$o = new stdClass() ;

$currentPoint = $o;

$elems = explode("/", $path);

$endElem = $elems[count($elems)-1];
$elems = array_slice($elems,0,count($elems)-1);

// Navigate through the object creating parts of the tree that are missing
foreach ($elems as $elem) {
    if (isset($currentPoint->$elem)) {
        $currentPoint = $currentPoint->$elem;
    } else {
        $currentPoint->$elem = new stdClass();
        $currentPoint = $currentPoint->$elem;
    }
}

// At the penultimate node, set the value of the final node to the content
$currentPoint->$endElem = $content;

if ($currentPoint->$endElem)

// print_r($o);

echo json_encode($o);