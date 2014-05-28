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

GET   - receive entire copy of the profile at this address
              
POST    add a top level item to the profile
GET     item


Install
=======

Install these files to e.g. yourserver.com/profile/ and ensure that your server has write access to the profile.txt file

add.php is intended to be called by a remote server, not intended for viewing in the browser. Loading it in the browser will just insert an empty item in your profile.
