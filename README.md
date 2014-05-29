odd-profile
===========

odd-profile aims to implement the minimum set of functionality to serve the 'Active Profile API', defined below. 

This project exists because implementing an LDP server is hard, but it is probable that LDP is the 'correct' solution here. Before it is easy to setup and use an LDP server, this project allows you to build projects on top of a 'profile server' _today_.

Read about LDP here:

http://www.w3.org/TR/2014/WD-ldp-20140311/
http://www.w3.org/TR/2014/NOTE-ldp-ucr-20140313/

See an active LDP implementation in Scala using the Play frame work here:

https://github.com/read-write-web/rww-play


Active Profile API
==================

{ProfileURL} is a root REST URL to which the below calls can be made

* GET: receive entire copy of the profile at this address
    * content-type header: choose mime-type of data to receive
        * application/json : send in raw JSON
        * text/html : pretty print HTML for browser (this is what you'll get if you browse to index.php)
* POST: an item to the profile
    * param 'category' [REQUIRED] : the category name to add an entry to
    * param 'content' [REQUIRED] : the content to add to the specified category
* Return data:
    * 200 on success, 400 on bad params.
    
Install
=======

Install these files to e.g. yourserver.com/profile/ and ensure that your server has write access to the profile.json file.

Test by browsing to editor.php and inserting a test content/category pair. This should be stored in profile.json and visible by browsing to index.php

