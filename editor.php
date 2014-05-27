<html>
<head>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function() {

    $('#addbutton').on('click', function() {
        alert('foo');
        var content = $('#content').val();
        var category = $('#category').val();
        var dataString = 'content=' + content + '&category=' + category;
        $.ajax({
            type: "POST",
            url: "index.php",
            data: dataString
        }).done(function(msg) {
                alert( "success: " + msg);
            })
            .fail(function() {
                alert( "error" );
            })
    });

    $('#clear').on('click', function() {
        $('#content').val('');
        $('#category').val('');
    });
});

</script>

Content: <input type="text" id="content" size="50"> - Category: <input type="text" id="category" size="50"><br>
<button id="addbutton">Add to profile</button><br>
<button id="clear">Clear</button>
