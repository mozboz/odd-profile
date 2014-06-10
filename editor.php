<html>
<head>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function() {

    $('#createbutton').on('click', function() {
        var path = $('#path').val();
        if (!path) {
            alert ('Path must be entered');
        } else {
            var dataString = 'urlPath=' + path + '&url=url&owner=owner&type=type&name=name';
            $.ajax({
                type: "POST",
                url: "index.php",
                data: dataString,
                beforeSend: setHeader

            }).done(function(data, textStatus, jqXHR) {
                    alert( "success: " + data + " | " + jqXHR.status);
                })
                .fail(function(jqXHR, textStatus, error) {
                    alert( "error"  + jqXHR.status + " " + textStatus + " " + error);
                });


        }
    });

    $('#addbutton').on('click', function() {
        var path = $('#path').val();
        var value = $('#value').val();
        var key = $('#key').val();
        if (key=='' || value=='') {
            alert('content and category must be filled');
        } else {
            var dataString = 'urlPath=' + path + '&key=' + key + '&value=' + value;

            $.ajax({
                type: "PUT",
                url: "index.php",
                data: dataString,
                beforeSend: setHeader

            }).done(function(data, textStatus, jqXHR) {
                    alert( "success: " + data + " | " + jqXHR.status);
                })
                .fail(function(jqXHR, textStatus, error) {
                    alert( "error"  + jqXHR.status + " " + textStatus + " " + error);
                });
        }
    });

    function setHeader(xhr) {
        xhr.setRequestHeader('Accept', 'application/vnd.odd-profile.v2+json');
    }

    $('#clear').on('click', function() {
        $('#content').val('');
        $('#category').val('');
    });
});

</script>

Path: <input type="text" id="path" size="50"> - <button id="createbutton">Create</button><br><br>


Key <input type="text" id="key" size="50"> - Value: <input type="text" id="value" size="50"><br>
<button id="addbutton">Add to profile</button><br>
<button id="clear">Clear</button>
