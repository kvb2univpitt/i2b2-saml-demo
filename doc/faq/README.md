# I2B2 Release 1.7.13 Frequently Asked Question (FAQ)

This document contains topics commonly asked.

## Apache JServ Protocol (AJP)

AJP is a binary protocol that is used to proxy requests from a web server to an application server.  It is a highly trusted protocol and should only be exposed to trusted clients.

#### How is AJP Used?

For security purposes, it is highly recommended to put the Wildfly server (application server) behind the Apache web server on the same network.  The Apache web server should be configured to only accept incoming requests on port 443 (https), therefore, blocking direct access to Wildfly on port 9090 via http.

All inbound request to Wildfly will go through the Apache web server on port 443 (https).  The web server then prox the requests over to Wildfly via AJP.  With this setup, i2b2 can limit what method to expose to the clients outside the network.

#### Why Use AJP Instead of HTTP?

AJP has performance advantage over HTTP.  HTTP is plain-text protocol, making it quite expensive in terms of band width.  AJP carries the same information as http but in a more compact format.  With AJP, request method can be reduced to a single byte and the header can be reduced to two bytes.  For more information, please see the "Basic Packet Structure" section of the [Apache Module mod_proxy_ajp](https://httpd.apache.org/docs/2.4/mod/mod_proxy_ajp.html) documentation.

> Note that AJP is **not required** to run i2b2.  It is recommended for SAML authentication setup.

## Shibboleth

### Shibboleth Variables in i2b2

All Shibboleth variable attributes must be prefixed with "**AJP_**".

#### What Shibboleth variables are required?

Below is a list of varibles that are required by the webclient.

| Variable               | Type                |
|------------------------|---------------------|
| uid                    | User ID             |
| eduPersonPrincipalName | User's Identifier   |
| eduPersonAffiliation   | User's Organization |
| mail                   | User's Email        |
| displayName            | User's Display Name |
| givenName              | User's First Name   |
| sn                     | User's Last Name    |

#### How are Shibboleth Variables Passed From Apache to Wildfly ?

When the user clicks the "Sign In" button, the request does not go directly to the i2b2 PM cell.  Instead, the request goes back to the webclient server for further processing and then proxied over to the PM cell.  This process occurs in all version of i2b2.

After the user sign with his/her organization's login credentials, the IdP redirects back to the webclien along with the Shibboleth variables.  The webclient automatically submit a login request with ***eduPersonPrincipalName*** as the user name and Shibbleth's session ID as the password.  As mentioned above, the request does not go directly to the PM cell.  The request goes back to the webclient server for further processing.  At this time, the Shibboleth variables are set as the Apache environment variables.  The Shibboleth variable attributes and values are placed in the request headers send to the PM cell.  The PM cell extracts the eduPersonPrincipalName and the shibboleth session ID from the headers and compares them with the ones submitted in the login form for validation.

The process where the webclient sends the Shibboleth variables in the request headers to the PM cell must be secured.  Therefore, it is recommended not to allow direct access to the PM cell outside the network.  It is a good practice to have the PM cell sits behind the Apache server and have all requests from the webclient proxy over the PM cell via AJP. ***Note that this is not an issue when the webclient is not setup to use SAML authentication.***

> Note that Shibboleth is not required to run i2b2 when SAML is not used for authentication.

### i2b2 Authetication Flow
![Authentication Flow](./../../img/saml_auth_flow.svg)

