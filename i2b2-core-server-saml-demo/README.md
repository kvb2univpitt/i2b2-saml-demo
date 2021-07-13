# i2b2-core-server-saml-demo

A Docker image of the i2b2-core-server (version 1.7.12a) for SAML demonstration.

## Ensure i2b2-saml-demo-net Network Exists

Containers need to be run on the **i2b2-saml-demo-net** network so that they can communicate with each other.

To verify that network **i2b2-saml-demo-net** exists, open up a terminal and execute the following command:

```
docker network ls
```

You should see **i2b2-saml-demo-net** from the output similar to this:

```
NETWORK ID     NAME                 DRIVER    SCOPE
0576db9e5151   bridge               bridge    local
58593240ad9d   host                 host      local
52abc9676b47   i2b2-saml-demo-net   bridge    local
aa3bc8690d35   none                 null      local
```

If the **i2b2-saml-demo-net** network does not exists, execute the following command to create one:

```
docker network create i2b2-saml-demo-net
```

## Run the Prebuilt Image in a Container

### Prerequisites

- [Docker 19.x](https://docs.docker.com/get-docker/)

A prebuilt [Docker image](https://hub.docker.com/r/kvb2univpitt/i2b2-core-server-saml-demo) is provided on Docker Hub.  Open up a terminal and execute the following command:

Linux / macOS:

```
docker run -d --name=i2b2-core-server-saml-demo \
--network i2b2-saml-demo-net \
-p 9090:9090 \
kvb2univpitt/i2b2-core-server-saml-demo:v1.2021.7
```

Windows:

```
docker run -d --name=i2b2-core-server-saml-demo ^
--network i2b2-saml-demo-net ^
-p 9090:9090 ^
kvb2univpitt/i2b2-core-server-saml-demo:v1.2021.7
```

## Build the Image

### Prerequisites

- [Docker 19.x](https://docs.docker.com/get-docker/)

Open up a terminal in the directory ***i2b2-core-server-saml-demo***, containing the file **Dockerfile**, and execute the following command to build the Docker image:

```
docker build -t local/i2b2-core-server-saml-demo .
```

To verify that the image has been buit, execute the following command:

```
docker images
```

The output should be similar to the following:

```
REPOSITORY                         TAG              IMAGE ID       CREATED          SIZE
local/i2b2-core-server-saml-demo   latest           3bae8a9360d6   14 seconds ago   865MB
```

### Run the Image In a Container

Execute the following command to run the image in a Docker container:

Linux / macOS:

```
docker run -d --name=i2b2-core-server-saml-demo \
--network i2b2-saml-demo-net \
-p 9090:9090 \
local/i2b2-core-server-saml-demo
```

Windows:

```
docker run -d --name=i2b2-core-server-saml-demo ^
--network i2b2-saml-demo-net ^
-p 9090:9090 ^
local/i2b2-core-server-saml-demo
```

## Access the Application

Open up a web browser and go to the following URL to access the list of services:

[http://localhost:9090/i2b2/services/listServices](http://localhost:9090/i2b2/services/listServices)
