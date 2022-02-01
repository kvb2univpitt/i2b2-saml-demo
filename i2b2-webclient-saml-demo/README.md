# i2b2-webclient-saml-demo

A Docker image of i2b2 web client ([Release 1.7.12a](https://github.com/i2b2/i2b2-webclient/releases/tag/v1.7.12a.0002)) with SAML authetication for demonstration purposes.

## Docker User-defined Bridge Network

The container runs on a user-defined bridge network ***i2b2-saml-demo-net***.  The user-defined bridge network provides better isolation and allows containers on the same network to communicate with each other using their container names instead of their IP addresses.

### Ensure User-defined Bridge Network Exists

To verify that the network ***i2b2-saml-demo-net*** exists, execute the following command to list all of the Docker's networks:

```
docker network ls
```

The output should be similar to this:

```
NETWORK ID     NAME            DRIVER    SCOPE
d86843421945   bridge          bridge    local
58593240ad9d   host            host      local
9a82abc00473   i2b2-saml-demo-net   bridge    local
```

If ***i2b2-saml-demo-net*** network is **not** listed, execute the following command to create it:

```
docker network create i2b2-saml-demo-net
```

## Run the Prebuilt Image

A prebuilt Docker image is provided on [Docker Hub](https://hub.docker.com/r/kvb2univpitt/i2b2-webclient-saml-demo).

### Prerequisites

- [Docker 19 or above](https://docs.docker.com/get-docker/)

Open up a terminal and execute the following command to download and run the prebuilt image in a container named ***i2b2-webclient-saml-demo***.

###### Linux / macOS:

```
docker run -d \
--name=i2b2-webclient-saml-demo \
--network i2b2-saml-demo-net \
-p 80:80 -p 443:443 \
kvb2univpitt/i2b2-webclient-saml-demo:v1.7.12a.2022.01
```

###### Windows:

```
docker run -d ^
--name=i2b2-webclient-saml-demo ^
--network i2b2-saml-demo-net ^
-p 80:80 -p 443:443 ^
kvb2univpitt/i2b2-webclient-saml-demo:v1.7.12a.2022.01
```

### Access the Web Client

Open up a web browser and go to the URL [https://localhost/webclient/](https://localhost/webclient/).

The browser will show a security warning because the SSL certificates are ***not*** signed and validated by a trusted Certificate Authority (CA).  Click "Accept the Risk and Continue"

![SSL Warning Page](../img/ssl_warning.png)

The browser will show thelogin page, as shown below.

#### Local Login

Select ***Local Demo*** from the **i2b2 Host:** drop down.

![Local Login Page](../img/local_login.png)

Login with the following local account credentials:

| Attribute | Value    |
|-----------|----------|
| Username  | demo     |
| Password  | demouser |

Once logged in, the browser will redirect to the landing page:

![Local Main Page](../img/local_main_page.png)

#### SAML Login

SAML login requires [i2b2-idp-saml-demo](i2b2-idp-saml-demo) Docker running.

Select ***SAML Demo*** from the **i2b2 Host:** drop down.

![SAML Login Page](../img/saml_login.png)

Click on ***Sign In With SimpleSAMLphp*** to sign in to identity provider (IdP).

![Main Page](../img/idp_login.png)

Use the following IdP credentials to log in:

| Attribute | Value    |
|-----------|----------|
| Username  | ckent    |
| Password  | superman |

Once logged in, the browser will redirect to the landing page:

![SAML Main Page](../img/saml_main_page.png)


### Docker Container and Image Management

Execute the following to stop the running Docker container:

```
docker stop i2b2-webclient-saml-demo
```

Execute the following to delete the Docker container:

```
docker rm i2b2-webclient-saml-demo
```

Execute the following to delete the Docker image:

```
docker rmi kvb2univpitt/i2b2-webclient-saml-demo:v1.7.12a.2022.01
```
## Build the Image

### Prerequisites

- [Docker or above](https://docs.docker.com/get-docker/)

### Build the Docker Image:

Open up a terminal in the directory **i2b2-demo/i2b2-webclient-saml-demo**, where the ***Dockerfile*** file is, and execute the following command to build the image:

```
docker build -t local/i2b2-webclient-saml-demo .
```

To verify that the image has been built, execute the following command to list the Docker images:

```
docker images
```

The output should be similar to the following:

```
REPOSITORY                            TAG          IMAGE ID       CREATED          SIZE
local/i2b2-webclient-saml-demo        latest       2025af93df72   31 minutes ago   1.2GB
kvb2univpitt/centos7-php-shibboleth   v1.2022.01   1d2cbf16c3ff   2 weeks ago      1.11GB
```

### Run the Image In a Container

Execute the following command the run the image in a Docker container name ***i2b2-webclient-saml-demo*** on the user-defined bridge network ***i2b2-saml-demo-net***:

###### Linux / macOS:

```
docker run -d --name=i2b2-webclient-saml-demo \
--network i2b2-saml-demo-net \
-p 80:80 -p 443:443 \
local/i2b2-webclient-saml-demo
```

###### Windows:

```
docker run -d --name=i2b2-webclient-saml-demo ^
--network i2b2-saml-demo-net ^
-p 80:80 -p 443:443 ^
local/i2b2-webclient-saml-demo
```

To verify that the container is running, execute the following command to list the Docker containers:

```
docker ps
```

The output should be similar to the following:

```
CONTAINER ID   IMAGE                            COMMAND                  CREATED          STATUS                             PORTS                                                                      NAMES
019b9652776d   local/i2b2-webclient-saml-demo   "/usr/local/bin/star…"   34 seconds ago   Up 32 seconds (health: starting)   0.0.0.0:80->80/tcp, :::80->80/tcp, 0.0.0.0:443->443/tcp, :::443->443/tcp   i2b2-webclient-saml-demo
```

### Docker Container and Image Management

Execute the following to stop the running Docker container:

```
docker stop i2b2-webclient-saml-demo
```

Execute the following to delete the Docker container:

```
docker rm i2b2-webclient-saml-demo
```

Execute the following to delete the Docker image:

```
docker rmi local/i2b2-webclient-saml-demo
```
