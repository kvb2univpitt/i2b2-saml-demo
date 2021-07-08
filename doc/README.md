# i2b2 Demo Application Deployment Guide

This documentation provides a guide on how to build, configure, and deploy i2b2 demo application 

### Prerequisite

The following software is required for building and running the applications:

 - RHEL 7 or compatible like CentOS 7
 - Apache HTTP web server 2.4 with SSL 
 - PHP 7
 - OpenJDK 1.8
 - Shibboleth SP 3.2
 - PostgreSQL 12 or above
 - Apache Ant 1.10
 - Wildfly 17.0.1.Final
 - SimpleSAMLphp 1.19


## Setup the Environment

The following instructions require **root user** to excute the commands.

### Install the Operating System
Please follow the [RHEL 7 installation guide](https://access.redhat.com/documentation/en-us/red_hat_enterprise_linux/7/html/installation_guide/index) or the [CentOS 7 installation guide](https://docs.centos.org/en-US/centos/install-guide/Simple_Installation/).

### Install Extra Packages for Enterprise Linux (EPEL)

EPEL provides a set of additional packages for RHEL from the Fedora Project.  For more information, please visit [What's EPEL, and how do I use it?](https://www.redhat.com/en/blog/whats-epel-and-how-do-i-use-it).

Open up a terminal and execute the following command to install EPEL and update the OS:

```console
yum -y install epel-release \
&& yum -y update
```

### Install Apache HTTP Secure Server

Execute the following command to install Apache HTTP server with SSL support:

```console
yum -y install httpd mod_ssl
```

Execute the following commands to enable and start Apache HTTP server:

```cosole
systemctl enable httpd
systemctl start httpd
```

### Install PHP

Execute the following command to install PHP and PHP support for PostgreSQL.

```console
yum -y install php php-common php-fpm php-bcmath php-cli php-gd php-mbstring php-xml php-xmlrpc php-zip php-pgsql
```

Execute the following commands to restart Apache HTTP server to apply changes:

```console
systemctl restart httpd
```

### Install Shibboleth for SAML on Linux and Apache

Shibboleth is used for federated authenticationg using SAML.  Execute the following command to install Shibboleth.

```console
wget http://download.opensuse.org/repositories/security://shibboleth/CentOS_7/security:shibboleth.repo -P /etc/yum.repos.d \
&& yum -y update \
&& yum -y install shibboleth
```

Execute the following command to enable and start Shibboleth:

```console
systemctl enable shibd
systemctl start shibd

systemctl restart httpd
```

### Install OpenJDK 1.8

Execute the following command to install OpenJDK 1.8.

```console
yum install -y java-1.8.0-openjdk java-1.8.0-openjdk-devel
```

### Install and Configure PostgreSQL Database

Execute the following command to install PostgreSQL database:
```console
yum -y install postgresql postgresql-server postgresql-contrib
```

Execute the following command to initialize the database:

```console
postgresql-setup --initdb --unit postgresql
```

Uncomment the following lines in **/var/lib/pgsql/data/postgresql.conf** by removing the **#** symbol at the begining of each line:

```text
#listen_addresses = 'localhost'		# what IP address(es) to listen on;
#port = 5432				# (change requires restart)
```

Modify the file **/var/lib/pgsql/data/postgresql.conf** as shown below:

```text
# TYPE  DATABASE        USER            ADDRESS                 METHOD

# "local" is for Unix domain socket connections only
local   all             all                                     peer
# IPv4 local connections:
host    all             all             127.0.0.1/32            md5
# IPv6 local connections:
host    all             all             ::1/128                 md5
```

For more installation and configuration option, please visit [RHEL 7 PostgreSQL Installation](https://www.redhat.com/sysadmin/postgresql-setup-use-cases) guide.

Execute the following command to enable and start PostgreSQL:

```console
systemctl enable postgresql
systemctl start postgresql.service
```

## Configure the Environment

The following instructions require **root user** to excute the commands.

### Set Java Home

Add the following line in the file ***/etc/profile***

```bash
export JAVA_HOME=/usr/lib/jvm/java-1.8.0-openjdk
```

### Configure SSL on Apache HTTP Server

Place the HTTPS Server Certificate (Public Key) in the folder **/etc/pki/tls/certs**.  For an example, **/etc/pki/tls/certs/localhost.crt**.

Place the HTTPS Server Key (Private Key) in the folder **/etc/pki/tls/private**.  For an example, **/etc/pki/tls/private/localhost.key**.

Place CA Cert in the directory **/etc/pki/tls/certs**.

####  Create a Certificate and a Key self-signed for HTTPS (Optional)

Optionally, you can create your own self-signed certificate and key if you don't have the official ones provided by the Certificate Authority:

Execute the following command to generate your own certificate and key:

```console
openssl req -x509 -newkey rsa:3072 -keyout /etc/pki/tls/private/$(hostname -f).key -out /etc/pki/tls/certs/$(hostname -f).crt -nodes -days 3650
```

### Configure Shibboleth SP

We will use SimpleSAMLphp for IdP.  Place the following files to the folder **/etc/shibboleth/**:
- [attribute-map.xml](../i2b2-webclient-saml-demo/resources/shibboleth/attribute-map.xml)
- [federation-metadata.xml](../i2b2-webclient-saml-demo/resources/shibboleth/federation-metadata.xml)
- [idp.crt](../i2b2-webclient-saml-demo/resources/shibboleth/idp.crt)
- [native.logger](../i2b2-webclient-saml-demo/resources/shibboleth/native.logger)
- [shibboleth2.xml](../i2b2-webclient-saml-demo/resources/shibboleth/shibboleth2.xml)
- [shibd.logger](../i2b2-webclient-saml-demo/resources/shibboleth/shibd.logger)

If you would like to use your own IdP, please visit [Configuration - Service Provider 3 - Shibboleth Wiki](https://wiki.shibboleth.net/confluence/display/SP3/Configuration) for advance configurations.

Place the following files in the directory **/etc/httpd/conf.d/**:

- [ajp.conf](../i2b2-webclient-saml-demo/resources/httpd/conf.d/ajp.conf)
- [shib.conf](../i2b2-webclient-saml-demo/resources/httpd/conf.d/shib.conf)

### Configure SELinux

Execute the following command to allow HTTPD scripts and modules to connect to the network:

```console
setsebool -P httpd_can_network_connect on
```

## Install SimpleSAMLphp

Please follow the [SimpleSAMLphp Installation and Configuration](https://simplesamlphp.org/docs/stable/simplesamlphp-install) guide to install and set IdP on your server.  Note that we want to setup SimpleSAMLphp as an IdP.  Please follow the [SimpleSAMLphp Identity Provider QuickStart](https://simplesamlphp.org/docs/stable/simplesamlphp-idp) guide to configure it as an IdP.

## Install i2b2 Software

Download and extract the [resources.zip](https://www.dropbox.com/s/jlihalwystn7zni/resources.zip).  This folder contains pre-configuration files for setting up i2b2 database, i2b2 core servers and i2b2 webclient.

### Setup i2b2 Demo Database

Assuming PostgreSQL is installed with the following admin user account:

| Username | Password |
|----------|----------|
| postgres | demouser |


To create the i2b2 database with the initial i2b2 application users, open up a terminal where the ***resources*** folder is and execute the following command to run the ***create_database.sql*** script with PostgreSQL:

```console
psql postgresql://postgres:demouser@localhost:5432/postgres -f ./resources/i2b2_data_demo/create_database.sql
```

You should see the following output:

```console
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

The following user accounts are created with full access to the i2b2 database tables:

| Username     | Password |
|--------------|----------|
| i2b2demodata | demouser |
| i2b2hive     | demouser |
| i2b2imdata   | demouser |
| i2b2metadata | demouser |
| i2b2pm       | demouser |
| i2b2workdata | demouser |

### Insert the i2b2 Demo Data

#### Download the i2b2 data loader
Download and extract the file [i2b2-data-1.7.12a.0001.zip](https://github.com/i2b2/i2b2-data/releases/tag/v1.7.12a.0001) to where the ***resources*** folder is. This is the application for importing the demo data into the i2b2 database.  Since we are creating a new database, we are only interest in the directory **i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall**

#### Copy Database Property Files:

Open up a terminal where the ***resources*** folder and the ***i2b2-data-1.7.12a.0001*** folder are in the same directory and execute the following command to copy the database property files:

```console
cp ./resources/i2b2_data_demo/db_configs/Crcdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Crcdata/
cp ./resources/i2b2_data_demo/db_configs/Hivedata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Hivedata/
cp ./resources/i2b2_data_demo/db_configs/Imdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Imdata/
cp ./resources/i2b2_data_demo/db_configs/Metadata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Metadata/
cp ./resources/i2b2_data_demo/db_configs/Pmdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Pmdata/
cp ./resources/i2b2_data_demo/db_configs/Workdata/db.properties ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Workdata/
```

#### Run the Ant Scripts To Import Data

Execute the following command to import the demo data into the database:

```console
./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/apache-ant/bin/ant \
-f ./i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/build.xml \
create_database load_demodata
```

The process should take about 15-20 minutes, depending on how fast your computer is.

### Setup i2b2 Hives

#### Install Wildfly on Server

Because of security risks, WildFly should never run as the root user.  A new system user and group needed to be created for Wildfly.

To create a new group ***wildfly***, execute the following command:

```console
groupadd -r wildfly
```

To create a new user ***wildfly*** and added it to the group ***wildfly***, execute the following command:

```console
useradd -r -g wildfly -d /opt/wildfly -s /sbin/nologin wildfly
```

Download and extract [wildfly-17.0.1.Final.zip ](https://download.jboss.org/wildfly/17.0.1.Final/wildfly-17.0.1.Final.zip) to where the [resources.zip](resources.zip) file is extracted.

Execute the following command to copy the Wildfly configuration files and i2b2 files over to Wildfly:

```console
cp -R resources/i2b2_core_server_demo/wildfly-17.0.1.Final/* wildfly-17.0.1.Final/
```

By convention, Wildfly should path should be ***/opt/wildfly-17.0.1.Final***.  Execute the following command to move Wildfly to ***/opt/*** directory:

```console
mv wildfly-17.0.1.Final /opt/
```

A symbolic link to WildFly that will point to the WildFly installation directory is needed.  Execute the following command to create the symbolic link
 ```console
 ln -s /opt/wildfly-17.0.1.Final /opt/wildfly
 ```

 WildFly user needs ownership to the installation direction in order to run.  Execute the following command to change the ownership of the installation directory to WildFly user:

 ```console
 chown -RH wildfly: /opt/wildfly-17.0.1.Final/
 ```

 #### Configure Wildfly to Run on Startup

Create the directory for the WildFly configuration file:

 ```console
 mkdir -p /etc/wildfly
 ```

Copy the configuration file to new directory:

 ```console
 cp /opt/wildfly-17.0.1.Final/docs/contrib/scripts/systemd/wildfly.conf /etc/wildfly/
 ```

 Copy the WildFly launch.sh script to the binary directory.

 ```console
 cp /opt/wildfly-17.0.1.Final/docs/contrib/scripts/systemd/launch.sh /opt/wildfly-17.0.1.Final/bin/
 ```

Set the WildFly launch.sh script to be executable

 ```console
 sh -c 'chmod +x /opt/wildfly-17.0.1.Final/bin/*.sh'
 ```

Copy the systemd unit service file now to /etc/systemd/system/.

 ```console
 cp /opt/wildfly-17.0.1.Final/docs/contrib/scripts/systemd/wildfly.service /etc/systemd/system/
 ```

Execute the following command to start and to enable Wildfly on startup:
 ```console
systemctl daemon-reload
systemctl start wildfly
systemctl enable wildfly
 ```

To make sure that Wildfly run successfully, execute the following command to check the status:
 ```console
 systemctl status wildfly
 ```

### Setup i2b2 Webclient

#### Configure Shibboleth

Execute to following command to set error log configuration in ***/etc/httpd/conf/httpd.conf*** file and ***/etc/httpd/conf.d/ssl.conf***.
 ```console
 RUN sed -i 's/ErrorLog "logs\/error_log"/ErrorLog \/dev\/stdout/g' /etc/httpd/conf/httpd.conf \
     && echo -e "\nErrorLogFormat \"httpd-error [%{u}t] [%-m:%l] [pid %P:tid %T] %7F: %E: [client\ %a] %M% ,\ referer\ %{Referer}i\"" >> /etc/httpd/conf/httpd.conf \
     && sed -i 's/CustomLog "logs\/access_log" combined/CustomLog \/dev\/stdout \"httpd-combined %h %l %u %t \\\"%r\\\" %>s %b \\\"%{Referer}i\\\" \\\"%{User-Agent}i\\\"\"/g' /etc/httpd/conf/httpd.conf \
     && sed -i 's/ErrorLog logs\/ssl_error_log/ErrorLog \/dev\/stdout/g' /etc/httpd/conf.d/ssl.conf \
     && sed -i 's/<\/VirtualHost>/ErrorLogFormat \"httpd-ssl-error [%{u}t] [%-m:%l] [pid %P:tid %T] %7F: %E: [client\\ %a] %M% ,\\ referer\\ %{Referer}i\"\n<\/VirtualHost>/g' /etc/httpd/conf.d/ssl.conf \
     && sed -i 's/CustomLog logs\/ssl_request_log/CustomLog \/dev\/stdout/g' /etc/httpd/conf.d/ssl.conf \
     && sed -i 's/TransferLog logs\/ssl_access_log/TransferLog \/dev\/stdout/g' /etc/httpd/conf.d/ssl.conf
 ```

Copy the Shibboleth configuration for SSL and AJP configuration:

```console
cp resources/i2b2_webclient_demo/httpd/conf.d/* /etc/httpd/conf.d/
 ```

Copy Shibboleth configuration files:

 ```console
 cp resources/i2b2_webclient_demo/shibboleth/* /etc/shibboleth/
 ```

Start Shibboleth and enable Shibboleth on startup.

 ```console
systemctl start shibd.service
systemctl enable shibd.service
 ```

 #### Install i2b2 Webclient

 Download the i2b2 webclient [v1.7.12a.0002.zip](https://github.com/i2b2/i2b2-webclient/archive/v1.7.12a.0002.zip) file and extract it to where the ***resources*** folder is.

Copy the modification code for the i2b2 webclient:
 ```console
cp -R resources/i2b2_webclient_demo/www/* i2b2-webclient-1.7.12a.0002/
 ```

Move the i2b2 webclient to the ***/var/www/html/webclient*** directory:
 ```console
 mv i2b2-webclient-1.7.12a.0002 /var/www/html/webclient
 ```

Restart Apache HTTPD:
 ```console
 systemctl restart httpd.service
 ```
 