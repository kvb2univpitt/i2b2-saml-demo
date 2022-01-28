# i2b2-data-saml-demo (PostgreSQL)

A Docker image of PostgreSQL database containing i2b2 demo data ([Release 1.7.12a](https://github.com/i2b2/i2b2-data/releases/tag/v1.7.12a.0001)) for SAML demostration purposes.

## Docker User-defined Bridge Network

The container runs on a user-defined bridge network ***i2b2-saml-demo-net***.  The user-defined bridge network provides better isolation and allows containers on the same network to communicate with each other using their container names instead of their IP addresses.

### Ensure User-defined Bridge Network Exists

To verify that the network ***i2b2-saml-demo-net*** exists, execute the following command to list all of the Docker's networks:

```
docker network ls
```

The output should be similar to this:

```
NETWORK ID     NAME                 DRIVER    SCOPE
9ea1de540506   bridge               bridge    local
bf7e75025889   host                 host      local
88a9b525113e   i2b2-saml-demo-net   bridge    local
```

If ***i2b2-saml-demo-net*** network is **not** listed, execute the following command to create it:

```
docker network create i2b2-saml-demo-net
```

## Run the Prebuilt Image

A prebuilt Docker image is provided on [Docker Hub](https://hub.docker.com/r/kvb2univpitt/i2b2-data-saml-demo-postgresql).

### Prerequisites

- [Docker 19 or above](https://docs.docker.com/get-docker/)

Open up a terminal and execute the following command to download and run the prebuilt image in a container named ***i2b2-data-saml-demo***.

###### Linux / macOS:

```
docker run -d --name=i2b2-data-saml-demo \
--network i2b2-saml-demo-net \
-e POSTGRESQL_ADMIN_PASSWORD=demouser \
-p 5432:5432 \
kvb2univpitt/i2b2-data-saml-demo-postgresql:v1.7.12a.2022.01
```

###### Windows:

```
docker run -d --name=i2b2-data-saml-demo ^
--network i2b2-saml-demo-net ^
-e POSTGRESQL_ADMIN_PASSWORD=demouser ^
-p 5432:5432 ^
kvb2univpitt/i2b2-data-saml-demo-postgresql:v1.7.12a.2022.01
```

### Application Users

Below is a list of user accounts for logging into the i2b2 web client:

| Username              | Password | Type  |
|-----------------------|----------|-------|
| demo                  | demouser | local |
| ckent                 | demouser | local |
| ckent@dailyplanet.com |          | SAML  |

The **local** account means using ***username*** and ***password*** for authentication.  The **SAML** account means using a third-party ***identity provider (IdP)*** for authentication.

> Note that the user accounts above is not the database admin account.

### Access the Database

The database can be accessed with any database tool by using the following configurations:

| Attribute | Value     |
|-----------|-----------|
| Host      | localhost |
| Port      | 5432      |
| Database  | i2b2      |
| Username  | postgres  |
| Password  | demouser  |

### Docker Container and Image Management

Execute the following to stop the running Docker container:

```
docker stop i2b2-data-saml-demo
```

Execute the following to delete the Docker container:

```
docker rm i2b2-data-saml-demo
```

Execute the following to delete the Docker image:

```
docker rmi kvb2univpitt/i2b2-data-saml-demo-postgresql:v1.7.12a.2022.01
```

## Build the Image

### Prerequisites

- [Docker or above](https://docs.docker.com/get-docker/)
-  Java SDK 8 ([Oracle JDK](https://www.oracle.com/java/technologies/javase-downloads.html) or [OpenJDK](https://adoptopenjdk.net/))
- [PostgreSQL](https://www.postgresql.org/download/)

### Build the Docker Image:

Open up a terminal in the directory **i2b2-saml-demo/i2b2-data-saml-demo/postgresql**, where the ***Dockerfile*** file is, and execute the following command to build the image:

```
docker build -t local/i2b2-data-saml-demo-postgresql .
```

To verify that the image has been built, execute the following command to list the Docker images:

```
docker images
```

The output should be similar to the following:

```
REPOSITORY                             TAG       IMAGE ID       CREATED         SIZE
local/i2b2-data-saml-demo-postgresql   latest    6d2894938264   9 minutes ago   548MB
centos/postgresql-12-centos7           latest    ead3e66c2b54   6 months ago    372MB
```

### Run the Image In a Container

Execute the following command the run the image in a Docker container name ***i2b2-data-saml-demo*** on the user-defined bridge network ***i2b2-saml-demo-net***:

###### Linux / macOS:

```
docker run -d --name=i2b2-data-saml-demo \
--network i2b2-saml-demo-net \
-e POSTGRESQL_ADMIN_PASSWORD=demouser \
-p 5432:5432 \
local/i2b2-data-saml-demo-postgresql
```

###### Windows:

```
docker run -d --name=i2b2-data-saml-demo ^
--network i2b2-saml-demo-net ^
-e POSTGRESQL_ADMIN_PASSWORD=demouser ^
-p 5432:5432 ^
local/i2b2-data-saml-demo-postgresql
```

To verify that the container is running, execute the following command to list the Docker containers:

```
docker ps
```

The output should be similar to the following:

```
CONTAINER ID   IMAGE                                  COMMAND                  CREATED              STATUS              PORTS                                       NAMES
e06a79a143cb   local/i2b2-data-saml-demo-postgresql   "container-entrypoin…"   About a minute ago   Up About a minute   0.0.0.0:5432->5432/tcp, :::5432->5432/tcp   i2b2-data-saml-demo
```

### Create i2b2 Database and Users

Open up a terminal in the directory **i2b2-saml-demo/i2b2-data-saml-demo/postgresql**.  Execute the following command to run PostgreSQL to execute the SQL script that creates i2b2 database and i2b2 database users:

```
psql postgresql://postgres:demouser@localhost:5432/postgres -f ./resources/create_database.sql
```

The output should be similar to the following:

```
CREATE DATABASE
CREATE ROLE
CREATE ROLE
CREATE ROLE
CREATE ROLE
CREATE ROLE
CREATE ROLE
GRANT
GRANT
GRANT
GRANT
GRANT
GRANT
GRANT
```

### Import the i2b2 Demo Data into the Database

Download the zip file [i2b2-data-1.7.12a.0001.zip](https://github.com/i2b2/i2b2-data/archive/refs/tags/v1.7.12a.0001.zip) and extract it to the directory **i2b2-saml-demo/i2b2-data-saml-demo/postgresql**.

#### Copy the Database Property Files to the i2b2-data Software

Open up a terminal in the directory **i2b2-saml-demo/i2b2-data-saml-demo/postgresql**, where the ***i2b2-data-1.7.12a.0001.zip*** was extracted, and execute the following command to copy the database property files over:

###### Linux / macOS:

```
cp ./resources/db_configs/Crcdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Crcdata/
cp ./resources/db_configs/Hivedata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Hivedata/
cp ./resources/db_configs/Imdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Imdata/
cp ./resources/db_configs/Metadata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Metadata/
cp ./resources/db_configs/Pmdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Pmdata/
cp ./resources/db_configs/Workdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Workdata/
```

###### Windows:

```
copy ./resources/db_configs/Crcdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Crcdata/
copy ./resources/db_configs/Hivedata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Hivedata/
copy ./resources/db_configs/Imdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Imdata/
copy ./resources/db_configs/Metadata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Metadata/
copy ./resources/db_configs/Pmdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Pmdata/
copy ./resources/db_configs/Workdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Workdata/
```

#### Run the Ant Script to Import the i2b2 Demo Data

Execute the following command to run the ant script to import the i2b2 demo data into the database:

###### Linux / macOS:

```
./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/apache-ant/bin/ant \
-f ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/build.xml \
create_database load_demodata
```

###### Windows:

```
./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/apache-ant/bin/ant ^
-f ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/build.xml ^
create_database load_demodata
```

The process should take about 15-20 minutes, depending on how fast your computer is.

### Add Additional Web Client User Accounts

The databause currently has the following user account for logging into the web client:

| Username              | Password | Type  |
|-----------------------|----------|-------|
| demo                  | demouser | local |

The following additional user accounts will be added to the database for logging into the web client:

| Username              | Password | Type  |
|-----------------------|----------|-------|
| ckent                 | demouser | local |
| ckent@dailyplanet.com |          | SAML  |

Open up a terminal in the directory **i2b2-saml-demo/i2b2-data-saml-demo/postgresql** and execute the following command to run PostgreSQL to execute the SQL script that adds additional user accounts:

```
psql postgresql://postgres:demouser@localhost:5432/i2b2 -f ./resources/users.sql
```

### Update the pm_cell_data Table

The **pm_cell_data** table contains URLs used by the i2b2 web client to communicate with the i2b2 core server. In this setup, the Apache JServ Protocol (AJP) is used for communication between Wildfly and the Apache web server.  In other words, the i2b2 web client ***does not*** communicate directly to the i2b2 core server.  Instead, the web client sends the request to itself on a designated path that gets proxy over to the i2b2 core server.

Open up a terminal in the directory **i2b2-saml-demo/i2b2-data-saml-demo/postgresql** and execute the following command to run PostgreSQL to execute the SQL script that updates the URLs in the **pm_cell_data** table:

```
psql postgresql://postgres:demouser@localhost:5432/i2b2 -f ./resources/update_tables.sql
```

### Save the Docker Container State to the Docker Image

The changes made to the Docker container need to be saved to the Docker image so that the data is still there when the image is launched into a new container.

The container ID is required to commit the changes to the image.  Execute the following to get the container ID:

```
docker ps
```

The output should be similar to the following:

```
CONTAINER ID   IMAGE                                  COMMAND                  CREATED              STATUS              PORTS                                       NAMES
e06a79a143cb   local/i2b2-data-saml-demo-postgresql   "container-entrypoin…"   About a minute ago   Up About a minute   0.0.0.0:5432->5432/tcp, :::5432->5432/tcp   i2b2-data-saml-demo
```

The container ID is **e06a79a143cb** in this example.  execute the following command to save the state of the container to the image:

```
docker commit e06a79a143cb local/i2b2-data-saml-demo-postgresql
```

### Docker Container and Image Management

Execute the following to stop the running Docker container:

```
docker stop i2b2-data-saml-demo
```

Execute the following to delete the Docker container:

```
docker rm i2b2-data-saml-demo
```

Execute the following to delete the Docker image:

```
docker rmi local/i2b2-data-saml-demo-postgresql
```
