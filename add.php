<?php
$fh=fopen('profile.txt', 'a+');
fwrite($fh, "\n" . $_POST['profileitem']);
fclose($fh);
?>

