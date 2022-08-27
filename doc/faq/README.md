# I2B2 Release 1.7.13 Frequently Asked Question (FAQ)

This document contains topics commonly asked.

## Apache JServ Protocol (AJP)

AJP is a binary protocol that is used to proxy requests from a web server to an application server.  It is a highly trusted protocol and should only be exposed to trusted clients.

### How is AJP Used?

For security purposes, it is highly recommended to put the Wildfly server (application server) behind the Apache web server on the same network.  The Apache web server should be configured to only accept incoming requests on port 443 (https), therefore, blocking direct access to Wildfly on port 9090 via http.

All inbound request to Wildfly will go through the Apache web server on port 443 (https).  The web server then prox the requests over to Wildfly via AJP.  With this setup, i2b2 can limit what method to expose to the clients outside the network.

### Why Use AJP Instead of HTTP?

AJP has performance advantage over HTTP.  HTTP is plain-text protocol, making it quite expensive in terms of band width.  AJP carries the same information as http but in a more compact format.  With AJP, request method can be reduced to a single byte and the header can be reduced to two bytes.  For more information, please see the "Basic Packet Structure" section of the [Apache Module mod_proxy_ajp](https://httpd.apache.org/docs/2.4/mod/mod_proxy_ajp.html) documentation.

> Note that AJP is recommended but **not required** to setup and run i2b2.