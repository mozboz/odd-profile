<html>
<head>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function() {

    $('#addbutton').on('click', function() {
        var s = $('#status').val();
        var dataString = 'profileitem=' + s;
        $.ajax({
            type: "POST",
            url: "add.php",
            data: dataString,
        });
    });
});
</script>

<input type="text" id="status" size="50"><br>
<button id="addbutton">Add to profile</button><br>
