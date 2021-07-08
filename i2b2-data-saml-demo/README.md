# i2b2-data-saml-demo

A Docker image of the i2b2-data demo, version 1.7.12a, for SAML demonstration.

## Run the Prebuilt Image in a Container

### Prerequisites

- [Docker 19.x](https://docs.docker.com/get-docker/)

A prebuilt [Docker image](https://hub.docker.com/r/kvb2univpitt/i2b2-data-saml-demo) is provided on Docker Hub.  Open up a terminal and execute the following command:

Linux / macOS:

```
docker run -d --name=i2b2-data-saml-demo \
-e POSTGRESQL_ADMIN_PASSWORD=demouser \
-p 5432:5432 \
kvb2univpitt/i2b2-data-saml-demo:v1.2021.7
```

Windows:

```
docker run -d --name=i2b2-data-saml-demo ^
-e POSTGRESQL_ADMIN_PASSWORD=demouser ^
-p 5432:5432 ^
kvb2univpitt/i2b2-data-saml-demo:v1.2021.7
```

The above command will run PostgreSQL 12 on port 5432 in a Docker container with the following default PostgreSQL admin account:

| Username | Password |
|----------|----------|
| postgres | demouser |

> The admin account is associated with PostgreSQL and is only used for managing the database.  It is NOT for logging into the i2b2 webclient application.

The following user account can log into the i2b2-webclient application using local login:

| Username | Password |
|----------|----------|
| demo     | demouser |

The following user account can log into the i2b2-webclient application using either local login or federated login:

| Username | Password |
|----------|----------|
| kdanvers | demouser |
| ckent    | demouser |

## Build the Image

### Prerequisites

- [Docker 19.x](https://docs.docker.com/get-docker/)
-  Java SDK 8 or higher ([Oracle JDK](https://www.oracle.com/java/technologies/javase-downloads.html) or [OpenJDK](https://adoptopenjdk.net/))
- [Apache Ant 1.10.x](https://ant.apache.org/bindownload.cgi)
- [PostgreSQL 12](https://www.postgresql.org/download/)

### Build the Docker Image:

Open up a terminal in the directory ***i2b2-data-demo***, containing the file **Dockerfile**, and execute the following command:

```
docker build -t local/i2b2-data-saml-demo .
```

The above command will build a Docker image with CentOS 7 and PostgreSQL 12 installed.

To verify that the image has been buit, execute the following command:

```
docker images
```

The output should be similar to the following:

```
REPOSITORY                      TAG              IMAGE ID       CREATED              SIZE
local/i2b2-data-saml-demo       latest           71d1fd83981e   About a minute ago   541MB
centos/postgresql-12-centos7    latest           d12590213acd   13 days ago          372MB
```

### Run the Image In a Container

Execute the following command:

Linux / macOS:

```
docker run -d --name=i2b2-data-saml-demo \
-e POSTGRESQL_ADMIN_PASSWORD=demouser \
-p 5432:5432 \
local/i2b2-data-saml-demo
```

Windows:

```
docker run -d --name=i2b2-data-saml-demo ^
-e POSTGRESQL_ADMIN_PASSWORD=demouser ^
-p 5432:5432 ^
local/i2b2-data-saml-demo
```

The above command will run PostgreSQL on port 5432 in a Docker container.

To verify that PostgreSQL is running in a container, execute the following command:

```
docker ps
```

You should see the output similar to this:

```
CONTAINER ID   IMAGE                       COMMAND                  CREATED         STATUS        PORTS                                       NAMES
44e1d3165627   local/i2b2-data-saml-demo   "container-entrypoin…"   2 seconds ago   Up 1 second   0.0.0.0:5432->5432/tcp, :::5432->5432/tcp   i2b2-data-saml-demo
```

### Create Database i2b2 and Database Users

Open up a terminal in the directory ***i2b2-data-demo*** and execute the following command the run the SQL script to create a database called **i2b2** along with the database users:

```
psql postgresql://postgres:demouser@localhost:5432/postgres -f ./resources/create_database.sql
```

You should see the following output:

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

> The i2b2 database users are associated with the i2b2 database and are used by the i2b2 core-server to access the database.

### Insert i2b2 Demo Data to the Database

#### Download the i2b2 Software

Download the [i2b2-data-1.7.12a.0001.zip](https://github.com/i2b2/i2b2-data/archive/refs/tags/v1.7.12a.0001.zip) and unzip the file to the directory ***i2b2-data-saml-demo***.

#### Copy the Database Property Files to the i2b2-data Software

Open up a terminal in the directory ***i2b2-data-saml-demo***, where the **i2b2-data-1.7.12a.0001.zip** was extracted.  Execute the following command to copy the database property files over:

Linux / macOS:

```
cp ./resources/db_configs/Crcdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Crcdata/
cp ./resources/db_configs/Hivedata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Hivedata/
cp ./resources/db_configs/Imdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Imdata/
cp ./resources/db_configs/Metadata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Metadata/
cp ./resources/db_configs/Pmdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Pmdata/
cp ./resources/db_configs/Workdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Workdata/
```

Windows:

```
copy ./resources/db_configs/Crcdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Crcdata/
copy ./resources/db_configs/Hivedata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Hivedata/
copy ./resources/db_configs/Imdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Imdata/
copy ./resources/db_configs/Metadata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Metadata/
copy ./resources/db_configs/Pmdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Pmdata/
copy ./resources/db_configs/Workdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Workdata/
```

#### Run the Ant Scripts

Execute the following command to run the ant script to insert the i2b2 demo data into the database:

Linux / macOS:

```
./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/apache-ant/bin/ant \
-f ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/build.xml \
create_database load_demodata
```

Windows:

```
./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/apache-ant/bin/ant ^
-f ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/build.xml ^
create_database load_demodata
```

The process should take about 15-20 minutes, depending on how fast your computer is.

#### Run the SQL Scripts

##### Add Additional Local Users

Currently, the database has the following user account for logging into the i2b2-webclient application:

| Username | Password |
|----------|----------|
| demo     | demouser |

Execute the following command to add additional users that can log into the i2b2-webclient application either using local login or federated login:

```
psql postgresql://postgres:demouser@localhost:5432/i2b2 -f ./resources/users.sql
```

The following additional user accounts will be added to the database:

| Username | Password | EPPN (SAML unique ID)                      | First Name | Last Name |
|----------|----------|--------------------------------------------|------------|-----------|
| kdanvers | demouser | karadanvers@catco.com                      | Kara       | Danvers   |
| ckent    | demouser | ckent@dailyplanet.com, clarkkent@catco.com | Clark      | Kent      |


##### Update the pm_cell_data Table

The i2b2 webclient requests will no longer be made directly to the i2b2 hives (Wildfly server).  All of the requests will be proxy over to the Wildfly server from the Apache server that is hosting the i2b2 webclient. The urls in the **pm_cell_data** table must be updated.

Open up a terminal in the directory ***i2b2-data-saml-demo*** and execute the following command to run the SQL script to update the **pm_cell_data** table:

```
psql postgresql://postgres:demouser@localhost:5432/i2b2 -f ./resources/update_tables.sql
```

### Save the Docker Container State to the Docker Image

After the i2b2 demo data has been inserted into the database, we need to persist the changes to the Docker image so that the demo data is still there when we rerun the imagine in a container.

To save the Docker container state to the Docker image, we first need the **container ID**.  Execute the following command to get the container ID:

```
docker ps
```

The output similar to this:

```
CONTAINER ID   IMAGE                       COMMAND                  CREATED       STATUS          PORTS                                       NAMES
44e1d3165627   local/i2b2-data-saml-demo   "container-entrypoin…"   4 hours ago   Up 27 minutes   0.0.0.0:5432->5432/tcp, :::5432->5432/tcp   i2b2-data-saml-demo
```

From the above example output, the container ID is ***44e1d3165627***.

Execute the following command to persist the container state to the image:

```
docker commit 44e1d3165627 local/i2b2-data-saml-demo
```
