# i2b2-saml-demo

A collection of Docker images preinstalled with [i2b2 software](https://www.i2b2.org/software/index.html) configured with SAML authentication for demonstration purposes.

The following i2b2 software are preinstalled:

- i2b2 Data [Release 1.7.12a](https://github.com/i2b2/i2b2-data/releases/tag/v1.7.12a.0001)
- i2b2 Core Server [Release 1.7.12a](https://github.com/i2b2/i2b2-core-server/releases/tag/v1.7.12a.0002)
- i2b2 Web Client [Release 1.7.12a](https://github.com/i2b2/i2b2-webclient/releases/tag/v1.7.12a.0002)

For documentations on the i2b2 software please visit the [i2b2 Community Wiki](https://community.i2b2.org/wiki/)

### i2b2 Architecture
![Welcome Page](./img/i2b2_saml_flow.svg)

### i2b2 Authetication Flow
![Authentication Flow](./img/saml_auth_flow.svg)

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

## Run the i2b2 Demo

### Prerequisites

- [Docker 19 or above](https://docs.docker.com/get-docker/)

Open up a terminal and execute the following commands to download and run the prebuilt images:

#### Run Demo With PostgreSQL

###### Linux / macOS:

```
docker run -d --name=i2b2-idp-saml-demo \
--network i2b2-saml-demo-net \
-p 8080:8080 \
-p 8443:8443 \
-e SIMPLESAMLPHP_ADMIN_PASSWORD=demouser \
kvb2univpitt/i2b2-idp-saml-demo:v1.7.12a.2022.01

docker run -d --name=i2b2-data-saml-demo \
--network i2b2-saml-demo-net \
-e POSTGRESQL_ADMIN_PASSWORD=demouser \
-p 5432:5432 \
kvb2univpitt/i2b2-data-saml-demo-postgresql:v1.7.12a.2022.01

docker run -d --name=i2b2-core-server-saml-demo \
--network i2b2-saml-demo-net \
-p 9090:9090 \
kvb2univpitt/i2b2-core-server-saml-demo-postgresql:v1.7.12a.2022.01

docker run -d \
--name=i2b2-webclient-saml-demo \
--network i2b2-saml-demo-net \
-p 80:80 -p 443:443 \
kvb2univpitt/i2b2-webclient-saml-demo:v1.7.12a.2022.01
```

###### Windows

```
docker run -d --name=i2b2-idp-saml-demo ^
--network i2b2-saml-demo-net ^
-p 8080:8080 ^
-p 8443:8443 ^
-e SIMPLESAMLPHP_ADMIN_PASSWORD=demouser ^
kvb2univpitt/i2b2-idp-saml-demo:v1.7.12a.2022.01

docker run -d --name=i2b2-data-saml-demo ^
--network i2b2-saml-demo-net ^
-e POSTGRESQL_ADMIN_PASSWORD=demouser ^
-p 5432:5432 ^
kvb2univpitt/i2b2-data-saml-demo-postgresql:v1.7.12a.2022.01

docker run -d --name=i2b2-core-server-saml-demo ^
--network i2b2-saml-demo-net ^
-p 9090:9090 ^
kvb2univpitt/i2b2-core-server-saml-demo-postgresql:v1.7.12a.2022.01

docker run -d ^
--name=i2b2-webclient-saml-demo ^
--network i2b2-saml-demo-net ^
-p 80:80 -p 443:443 ^
kvb2univpitt/i2b2-webclient-saml-demo:v1.7.12a.2022.01
```

#### Run Demo With SQL Server

###### Linux / macOS:

```
docker run -d --name=i2b2-idp-saml-demo \
--network i2b2-saml-demo-net \
-p 8080:8080 \
-p 8443:8443 \
-e SIMPLESAMLPHP_ADMIN_PASSWORD=demouser \
kvb2univpitt/i2b2-idp-saml-demo:v1.7.12a.2022.01

docker run -d --name=i2b2-data-saml-demo \
--network i2b2-saml-demo-net \
-e MSSQL_AGENT_ENABLED=true \
-e ACCEPT_EULA=Y \
-e SA_PASSWORD=Demouser123! \
-p 1433:1433 \
kvb2univpitt/i2b2-data-saml-demo-sqlserver:v1.7.12a.2022.01

docker run -d --name=i2b2-core-server-saml-demo \
--network i2b2-saml-demo-net \
-p 9090:9090 \
kvb2univpitt/i2b2-core-server-saml-demo-sqlserver:v1.7.12a.2022.01

docker run -d \
--name=i2b2-webclient-saml-demo \
--network i2b2-saml-demo-net \
-p 80:80 -p 443:443 \
kvb2univpitt/i2b2-webclient-saml-demo:v1.7.12a.2022.01
```

###### Windows

```
docker run -d --name=i2b2-idp-saml-demo ^
--network i2b2-saml-demo-net ^
-p 8080:8080 ^
-p 8443:8443 ^
-e SIMPLESAMLPHP_ADMIN_PASSWORD=demouser ^
kvb2univpitt/i2b2-idp-saml-demo:v1.7.12a.2022.01

docker run -d --name=i2b2-data-saml-demo ^
--network i2b2-saml-demo-net ^
-e MSSQL_AGENT_ENABLED=true ^
-e ACCEPT_EULA=Y ^
-e SA_PASSWORD=Demouser123! ^
-p 1433:1433 ^
kvb2univpitt/i2b2-data-saml-demo-sqlserver:v1.7.12a.2022.01

docker run -d --name=i2b2-core-server-saml-demo ^
--network i2b2-saml-demo-net ^
-p 9090:9090 ^
kvb2univpitt/i2b2-core-server-saml-demo-sqlserver:v1.7.12a.2022.01

docker run -d ^
--name=i2b2-webclient-saml-demo ^
--network i2b2-saml-demo-net ^
-p 80:80 -p 443:443 ^
kvb2univpitt/i2b2-webclient-saml-demo:v1.7.12a.2022.01
```

#### Run Demo With Oracle

###### Linux / macOS:

```
docker run -d --name=i2b2-idp-saml-demo \
--network i2b2-saml-demo-net \
-p 8080:8080 \
-p 8443:8443 \
-e SIMPLESAMLPHP_ADMIN_PASSWORD=demouser \
kvb2univpitt/i2b2-idp-saml-demo:v1.7.12a.2022.01

docker run -d --name=i2b2-data-saml-demo \
--network i2b2-saml-demo-net \
--shm-size="4G" \
-p 1521:1521 -p 5500:5500 \
-e ORACLE_PWD=demouser \
kvb2univpitt/i2b2-data-saml-demo-oracle:v1.7.12a.2022.01

docker run -d --name=i2b2-core-server-saml-demo \
--network i2b2-saml-demo-net \
-p 9090:9090 \
kvb2univpitt/i2b2-core-server-saml-demo-oracle:v1.7.12a.2022.01

docker run -d \
--name=i2b2-webclient-saml-demo \
--network i2b2-saml-demo-net \
-p 80:80 -p 443:443 \
kvb2univpitt/i2b2-webclient-saml-demo:v1.7.12a.2022.01
```

###### Windows

```
docker run -d --name=i2b2-idp-saml-demo ^
--network i2b2-saml-demo-net ^
-p 8080:8080 ^
-p 8443:8443 ^
-e SIMPLESAMLPHP_ADMIN_PASSWORD=demouser ^
kvb2univpitt/i2b2-idp-saml-demo:v1.7.12a.2022.01

docker run -d --name=i2b2-data-saml-demo ^
--network i2b2-saml-demo-net ^
--shm-size="4G" ^
-p 1521:1521 -p 5500:5500 ^
-e ORACLE_PWD=demouser ^
kvb2univpitt/i2b2-data-saml-demo-oracle:v1.7.12a.2022.01

docker run -d --name=i2b2-core-server-saml-demo ^
--network i2b2-saml-demo-net ^
-p 9090:9090 ^
kvb2univpitt/i2b2-core-server-saml-demo-oracle:v1.7.12a.2022.01

docker run -d ^
--name=i2b2-webclient-saml-demo ^
--network i2b2-saml-demo-net ^
-p 80:80 -p 443:443 ^
kvb2univpitt/i2b2-webclient-saml-demo:v1.7.12a.2022.01
```

### Access the Web Client

Open up a web browser and go to the URL [https://localhost/webclient/](https://localhost/webclient/).

The browser will show a security warning because the SSL certificates are ***not*** signed and validated by a trusted Certificate Authority (CA).  Click "Accept the Risk and Continue"

![SSL Warning Page](/img/ssl_warning.png)

The browser will show thelogin page, as shown below.

#### Local Login

Select ***Local Demo*** from the **i2b2 Host:** drop down.

![Local Login Page](/img/local_login.png)

Login with the following local account credentials:

| Attribute | Value    |
|-----------|----------|
| Username  | demo     |
| Password  | demouser |

Once logged in, the browser will redirect to the landing page:

![Local Main Page](/img/local_main_page.png)

#### SAML Login

Select ***SAML Demo*** from the **i2b2 Host:** drop down.

![SAML Login Page](/img/saml_login.png)

Click on ***Sign In With SimpleSAMLphp*** to sign in to identity provider (IdP).

![Main Page](/img/idp_login.png)

Use the following IdP credentials to log in:

| Attribute | Value    |
|-----------|----------|
| Username  | ckent    |
| Password  | superman |

Once logged in, the browser will redirect to the landing page:

![SAML Main Page](/img/saml_main_page.png)
