# Installation Guide For i2b2 on Red Hat Enterprise Linux 8 (RHEL 8)

This documentation provides step-by-step on how to install the following:

- The system software for running i2b2.
- The development tools for building i2b2.
- The i2b2 software for federated login.

> Note: Most of the commands below require admin privilege.  You will need root access to execute these commands.

## Table of Contents

- [Setting Up the Operating System](#setting-up-the-operating-system)
  * [Updating the Operating System](#updating-the-operating-system)
  * [Installing Extra Packages for Enterprise Linux (EPEL)](#installing-extra-packages-for-enterprise-linux--epel-)
- [Installing Development Tools](#installing-development-tools)
  * [Installing OpenJDK 8](#installing-openjdk-8)
  * [Installing Apache Ant 1.10.x](#installing-apache-ant-110x)
  * [Setting the Environment Variables](#setting-the-environment-variables)
  * [Restarting the Server](#restarting-the-server)
- [Installing Web Servers](#installing-web-servers)
  * [Installing Apache HTTP Server With PHP 7.x and SSL v3 and TLS v1.x Support](#installing-apache-http-server-with-php-7x-and-ssl-v3-and-tls-v1x-support)
    + [Installing Apache HTTP Server](#installing-apache-http-server)
    + [Adding to Systemd Services](#adding-to-systemd-services)
    + [Configurating Firewall For the Apache HTTP Server](#configurating-firewall-for-the-apache-http-server)
    + [Configurating SELinux For the Apache HTTP Server](#configurating-selinux-for-the-apache-http-server)
    + [Installing SSL Certificates](#installing-ssl-certificates)
      - [Creating a Certificate and a Key self-signed for HTTPS](#creating-a-certificate-and-a-key-self-signed-for-https)
      - [Installing a Certificate and a Key self-signed for HTTPS](#installing-a-certificate-and-a-key-self-signed-for-https)
    + [Installing PHP 7](#installing-php-7)
  * [Installing Wildfly 17.0.1](#installing-wildfly-1701)
    + [Creating System User and Group](#creating-system-user-and-group)
    + [Installing Wildfly](#installing-wildfly)
    + [Configuring Wildfly](#configuring-wildfly)
    + [Setting Up WildFly Service](#setting-up-wildfly-service)
- [Installing Database](#installing-database)
  * [Installing PostgreSQL 10](#installing-postgresql-10)
    + [Installing PostgreSQL](#installing-postgresql)
    + [Configuring PostgreSQL](#configuring-postgresql)
      - [Modifying the File /var/lib/pgsql/data/postgresql.conf](#modifying-the-file--var-lib-pgsql-data-postgresqlconf)
      - [Modifying the File /var/lib/pgsql/data/pg_hba.conf](#modifying-the-file--var-lib-pgsql-data-pg-hbaconf)
    + [Adding to Systemd Services](#adding-to-systemd-services-1)

## Setting Up the Operating System

### Updating the Operating System

Sometimes it is a good idea to update the operation system with the latest security fixes.  Execute the following command to update the operation system.

```
dnf -y update
```

### Installing Extra Packages for Enterprise Linux (EPEL)

EPEL provides a set of additional packages for RHEL from the Fedora Project.  For more information, please visit [What's EPEL, and how do I use it?](https://www.redhat.com/en/blog/whats-epel-and-how-do-i-use-it).

Execute the following command to install EPEL and update the operating system:

```
dnf -y install epel-release
```

Run the update to download the repository files epel*.repo to the directory **/etc/yum.repos.d/**.

```
dnf -y update
```

## Installing Development Tools

### Installing OpenJDK 8

```
dnf -y install java-1.8.0-openjdk java-1.8.0-openjdk-devel
```

### Installing Apache Ant 1.10.x

Download Apache Ant to a temp folder:

```
curl -s -L -o /tmp/apache-ant.tar.gz https://dlcdn.apache.org//ant/binaries/apache-ant-1.10.12-bin.tar.gz
```

Extract Apache Ant to **/usr/local/** directory:

```
tar zxf /tmp/apache-ant.tar.gz -C /usr/local/
```

Clean up Apache Ant temp file:

```
rm -rf /tmp/apache-ant.tar.gz 
```

Create a symbolic link to the **ant** command:

```
ln -s /usr/local/apache-ant-1.10.12/bin/ant /usr/bin/
```

### Setting the Environment Variables

Add the following lines in the file **/etc/profile**:

```
export JAVA_HOME=/usr/lib/jvm/java-1.8.0-openjdk
export ANT_HOME=/usr/local/apache-ant-1.10.12
```

### Restarting the Server

Execute the following common to reboot the machine:

```
/sbin/shutdown -r now
```

> Note:  You will need to log back into the machine as a root user.


## Installing Web Servers

### Installing Apache HTTP Server With PHP 7.x and SSL v3 and TLS v1.x Support

#### Installing Apache HTTP Server

Execute the following command to install Apache HTTP Server and SSL module

```
dnf -y install httpd mod_ssl
```

#### Adding to Systemd Services

Enable the Apache HTTP Server to run on startup:

```
systemctl enable httpd
```

Start the Apache HTTP Server
```
systemctl start httpd
```

#### Configurating Firewall For the Apache HTTP Server

Configure the firewall to allow https access.

Add https to the firewall list permanently:

```
firewall-cmd --permanent --add-service=https
```

Reload the firewall policy:

```
firewall-cmd --reload
```

#### Configurating SELinux For the Apache HTTP Server

To allow the Apache HTTP Server to communicate with database, execute the following command:

```
setsebool -P httpd_can_network_connect_db on
```

#### Installing SSL Certificates

Default SSL certificates are already created and installed when **mod_ssl** is installed.  The instruction below are for creating and installing your custom SSL certificates or for installing SSL certificates signed by a certificate authority.

##### Creating a Certificate and a Key self-signed for HTTPS

You can create your own self-signed certificate and key if you don't have the official ones provided by the Certificate Authority.

Generate your own certificate and key:

```
openssl req -x509 -newkey rsa:3072 -keyout /etc/pki/tls/private/$(hostname -f).key -out /etc/pki/tls/certs/$(hostname -f).crt -nodes -days 3650
```

##### Installing a Certificate and a Key self-signed for HTTPS

- Place the HTTPS Server Certificate (Public Key) in the folder **/etc/pki/tls/certs**. For an example, /etc/pki/tls/certs/localhost.crt.
- Place the HTTPS Server Key (Private Key) in the folder **/etc/pki/tls/private**. For an example, /etc/pki/tls/private/localhost.key.
- Place CA Cert in the directory **/etc/pki/tls/certs**.

#### Installing PHP 7

Execute the following command to install PHP 7 for the Apache HTTP Server

```
dnf -y install php php-cli php-common php-fpm php-bcmath php-gd \
php-mbstring php-xml php-xmlrpc php-zip php-pgsql php-curl php-pear php-json
```

Restart the Apache HTTP Server for the PHP module to registered.

```
systemctl restart httpd
```

### Installing Wildfly 17.0.1

#### Creating System User and Group

WildFly should never be run as the root user due to the security risks.  We need to create a new system user and group for Wildfly.

Create user group **wildfly**.

```
groupadd -r wildfly
```

Create system user **wildfly** and added it to the group **wildfly**: 

```
useradd -r -g wildfly -d /opt/wildfly -s /sbin/nologin wildfly
```

#### Installing Wildfly

Download Wildfly to **tmp** directory:

```
curl -s -L -o /tmp/wildfly-17.0.1.Final.zip https://download.jboss.org/wildfly/17.0.1.Final/wildfly-17.0.1.Final.zip
```

Extract Wildfly:

```
unzip /tmp/wildfly-17.0.1.Final.zip -d /opt/
```

Clean up Wildfly temp file:

```
rm -rf /tmp/wildfly-17.0.1.Final.zip
```

Create a symbolic link to WildFly that will point to the WildFly installation directory

```
ln -s /opt/wildfly-17.0.1.Final /opt/wildfly
```

Change the ownership of the installation directory to WildFly user

```
chown -RH wildfly: /opt/wildfly-17.0.1.Final/
```

#### Configuring Wildfly

Create the directory for the WildFly configuration file:

```
mkdir -p /etc/wildfly
```

Copy the configuration file to new directory:

```
cp /opt/wildfly-17.0.1.Final/docs/contrib/scripts/systemd/wildfly.conf /etc/wildfly/
```

We want Wildfly to only bind to host ***127.0.0.1***.  Modify the ***wildfly.conf*** file to the following:

```text
# The address to bind to
WILDFLY_BIND=127.0.0.1
```

Copy the WildFly launch.sh script to the binary directory:

```
cp /opt/wildfly-17.0.1.Final/docs/contrib/scripts/systemd/launch.sh /opt/wildfly-17.0.1.Final/bin/
```

Set the script is inside binary directory to be executable:

```
sh -c 'chmod +x /opt/wildfly-17.0.1.Final/bin/*.sh'
```

#### Setting Up WildFly Service

Copy the systemd unit service file now to **/etc/systemd/system/** directory:

```
cp /opt/wildfly-17.0.1.Final/docs/contrib/scripts/systemd/wildfly.service /etc/systemd/system/
```

Notify ***systemd*** that a new service unit file is in place:

```
systemctl daemon-reload
```

Enable Wildfly to start on system bootup:

```
systemctl enable wildfly
```

Start Wildfly:

```
systemctl start wildfly
```

Check Wildfly status:

```
systemctl status wildfly
```

You should see output like this:

```
● wildfly.service - The WildFly Application Server
   Loaded: loaded (/etc/systemd/system/wildfly.service; enabled; vendor preset: disabled)
   Active: active (running) since Tue 2021-11-16 16:41:38 EST; 1min 50s ago
 Main PID: 4823 (launch.sh)
    Tasks: 44 (limit: 24776)
   Memory: 419.4M
   CGroup: /system.slice/wildfly.service
           ├─4823 /bin/bash /opt/wildfly/bin/launch.sh standalone standalone.xml 127.0.0.1
           ├─4824 /bin/sh /opt/wildfly/bin/standalone.sh -c standalone.xml -b 127.0.0.1
           └─4881 java -D[Standalone] -server -Xms64m -Xmx512m -XX:MetaspaceSize=96M -XX:MaxMetaspaceSi>

Nov 16 16:41:38 localhost.localdomain systemd[1]: Started The WildFly Application Server.
```

> Note: Normally, we would configure the firewall policy to allow public access to Wildfly.  However, we will be using AJP for communication between Apache HTTP Server and Wildfly.  We will need to keep Wildfly access local.

## Installing Database

### Installing PostgreSQL 10

#### Installing PostgreSQL

Execute the following command to install PostgreSQL:

```
dnf -y install postgresql postgresql-server postgresql-contrib
```

Initialize the database:

```
postgresql-setup --initdb --unit postgresql
```

#### Configuring PostgreSQL

##### Modifying the File /var/lib/pgsql/data/postgresql.conf

Uncomment line **59** to:

```text
listen_addresses = 'localhost'		# what IP address(es) to listen on;
```

Uncomment line **63** to:

```text
port = 5432				# (change requires restart)
```

##### Modifying the File /var/lib/pgsql/data/pg_hba.conf

Edit the file as shown below (line 77-84):

```text
# TYPE  DATABASE        USER            ADDRESS                 METHOD

# "local" is for Unix domain socket connections only
local   all             all                                     peer
# IPv4 local connections:
host    all             all             127.0.0.1/32            md5
# IPv6 local connections:
host    all             all             ::1/128                 md5
```

#### Adding to Systemd Services

Enable PostgreSQL to run on startup:

```
systemctl enable postgresql
```

Start PostgreSQL
```
systemctl start postgresql
```

#### Configurating Firewall For the Apache HTTP Server

Enable public access to PostgreSQL:

```
firewall-cmd --zone=public --permanent --add-service=postgresql
```

Reload firewall rules:

```
firewall-cmd --reload
```

## Installing the i2b2 Software

### Installing the i2b2-data

#### Downloading the i2b2 Demo Data

Download the i2b2 data to a temp directory:

```
curl -s -L -o /tmp/v1.7.12a.0001.zip https://github.com/i2b2/i2b2-data/archive/refs/tags/v1.7.12a.0001.zip
```
Extract the i2b2 data to **/opt/** directory.

```
unzip /tmp/v1.7.12a.0001.zip -d /opt/
```

#### Configuring the db.properties Files

We need to modify the ***db.properties*** files to point to the PostgreSQL database.

> Note:  The instruction below assume your hostname is **localhost**.  If you want to use a different hostname, replace ***localhost*** with your hostname.

Replace all of the content in the file ***/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Crcdata/db.properties*** with the following content:

```properties
# Database setup parameters for PostgreSQL
db.type=postgresql
db.username=i2b2demodata
db.password=demouser
db.driver=org.postgresql.Driver
db.url=jdbc:postgresql://localhost:5432/i2b2
db.project=demo
```

Replace all of the content in the file ***/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Hivedata/db.properties*** with the following content:

```properties
# Database setup parameters for PostgreSQL
db.type=postgresql
db.username=i2b2hive
db.password=demouser
db.driver=org.postgresql.Driver
db.url=jdbc:postgresql://localhost:5432/i2b2
```

Replace all of the content in the file ***/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Imdata/db.properties*** with the following content:

```properties
# Database setup parameters for PostgreSQL
db.type=postgresql
db.username=i2b2imdata
db.password=demouser
db.driver=org.postgresql.Driver
db.url=jdbc:postgresql://localhost:5432/i2b2
```

Replace all of the content in the file ***/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Metadata/db.properties*** with the following content:

```properties
# Database setup parameters for PostgreSQL
db.type=postgresql
db.username=i2b2metadata
db.password=demouser
db.driver=org.postgresql.Driver
db.url=jdbc:postgresql://localhost:5432/i2b2
db.project=demo
db.dimension=OBSERVATION_FACT
db.schemaname=public
```

Replace all of the content in the file ***/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Pmdata/db.properties*** with the following content:

```properties
# Database setup parameters for PostgreSQL
db.type=postgresql
db.username=i2b2pm
db.password=demouser
db.driver=org.postgresql.Driver
db.url=jdbc:postgresql://localhost:5432/i2b2
db.project=demo
```

Replace all of the content in the file ***/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Workdata/db.properties*** with the following content:

```properties
# Database setup parameters for PostgreSQL
db.type=postgresql
db.username=i2b2workdata
db.password=demouser
db.driver=org.postgresql.Driver
db.url=jdbc:postgresql://localhost:5432/i2b2
db.project=demo
```

#### Creating i2b2 Database

##### Download the SQL Script

Download the SQL script to create i2b2 database and i2b2 database users in the directory **/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall**:

```
curl -s -L -o /opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/create_database.sql \
https://raw.githubusercontent.com/kvb2univpitt/i2b2-saml-demo/main/i2b2-data-saml-demo/resources/create_database.sql
```

##### Run the SQL Script

Switch to PostgreSQL root user ***postgres***:

```
su - postgres
```

Run the ***create_database.sql*** script:

```
psql -f /opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/create_database.sql
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