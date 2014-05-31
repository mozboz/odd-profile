<html>
<head>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function() {

    $('#addbutton').on('click', function() {
        var content = $('#content').val();
        var category = $('#category').val();
        if (content=='' || category=='') {
            alert('content and category must be filled');
        } else {
            var dataString = 'content=' + content + '&category=' + category;
            $.ajax({
                type: "POST",
                url: "index.php",
                data: dataString
            }).done(function(data, textStatus, jqXHR) {
                    alert( "success: " + data + " | " + jqXHR.status);
                })
                .fail(function() {
                    alert( "error" );
                })
        }
    });

    $('#clear').on('click', function() {
        $('#content').val('');
        $('#category').val('');
    });
});

</script>

Category: <input type="text" id="category" size="50"> - Content: <input type="text" id="content" size="50"><br>
<button id="addbutton">Add to profile</button><br>
<button id="clear">Clear</button>
