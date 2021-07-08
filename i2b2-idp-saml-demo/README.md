# i2b2-idp-saml-demo

A preconfigured SAML 2.0 identity provider (Idp) Docker image for demonstration i2b2 federated login.

The following platforms are used:

- The official [PHP7 Apache](https://hub.docker.com/_/php/) docker image.
- [SimpleSAMLphp](https://simplesamlphp.org/)

### SAML Attributes

Below is a table containing the user details associated with the SAML attributes that are used.

| User Detail    | SAML Attribute         |
|----------------|------------------------|
| Username       |                        |
| Password       |                        |
| UID            | uid                    |
| NetID          | eduPersonPrincipalName |
| Affiliation    | eduPersonAffiliation   |
| Email          | mail                   |
| First Name     | givenName              |
| Last Name      | sn                     |
| Preferred Name | displayName            |

### IdP Users

The IdP contains the following user accounts:

| Username    | Password  | UID         | NetID                 | Affiliation | Email                 | First Name | Last Name | Preferred Name      |
|-------------|-----------|-------------|-----------------------|-------------|-----------------------|------------|-----------|---------------------|
| lex         | luthor    | lex         | lex@lexcorp.com       | staff       | lex@lexcorp.com       | Alexander  | Luthor    | Lex Luthor          |
| ckent       | superman  | ckent       | ckent@dailyplanet.com | staff       | ckent@dailyplanet.com | Clark      | Kent      | Clark Kent (Kal-El) |
| karadanvers | supergirl | karadanvers | karadanvers@catco.com | staff       | karadanvers@catco.com | Kara       | Danvers   | Kara Zor-El         |
| clarkkent   | superman  | clarkkent   | clarkkent@catco.com   | staff       | clarkkent@catco.com   | Clark      | Kent      | Kal-El              |

### Access the Identity Provider (IdP)

Open up a web browser and go to the URL [http://localhost:8080/simplesaml](http://localhost:8080/simplesaml).

Below is the admin account:

| Username | Password |
|----------|----------|
| admin    | demouser |

## Run the Prebuilt Image in a Container

### Prerequisites

- [Docker 19.x](https://docs.docker.com/get-docker/)

A prebuilt [Docker image](https://hub.docker.com/r/kvb2univpitt/i2b2-idp-saml-demo) is provided on Docker Hub.  Open up a terminal and execute the following command:

Linux / macOS:

```
docker run -d --name=i2b2-idp-saml-demo \
-p 8080:8080 \
-p 8443:8443 \
-e SIMPLESAMLPHP_ADMIN_PASSWORD=demouser \
kvb2univpitt/i2b2-idp-saml-demo:v1.2021.7
```

Windows:

```
docker run -d --name=i2b2-idp-saml-demo ^
-p 8080:8080 ^
-p 8443:8443 ^
-e SIMPLESAMLPHP_ADMIN_PASSWORD=demouser ^
kvb2univpitt/i2b2-idp-saml-demo:v1.2021.7
```

## Build the Image

### Prerequisites

- [Docker 19.x](https://docs.docker.com/get-docker/)

Open update a terminal the **Dockerfile** is in the directory ***i2b2-idp-saml-demo*** and execute the following command:

```
docker build -t local/i2b2-idp-saml-demo .
```

To verify that the image has been buit, execute the following command:

```
docker images
```

The output should be similar to the following:

```
REPOSITORY                      TAG              IMAGE ID       CREATED             SIZE
local/i2b2-idp-saml-demo        latest           1ce5b671ff03   39 seconds ago      506MB
php                             7.4.9-apache     811269837652   10 months ago       414MB
```

### Run the Image In a Container

Linux / macOS:

```
docker run -d --name=i2b2-idp-saml-demo \
-p 8080:8080 \
-p 8443:8443 \
-e SIMPLESAMLPHP_ADMIN_PASSWORD=demouser \
local/i2b2-idp-saml-demo
```

Windows:

```
docker run -d --name=i2b2-idp-saml-demo ^
-p 8080:8080 ^
-p 8443:8443 ^
-e SIMPLESAMLPHP_ADMIN_PASSWORD=demouser ^
local/i2b2-idp-saml-demo
```
