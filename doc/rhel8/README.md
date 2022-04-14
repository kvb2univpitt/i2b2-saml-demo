# I2B2 Installation Guide (RHEL8)

A guide for installing i2b2 on Red Hat Enterprise Linux 8 (RHEL8) or compatible distribution.

**Prerequisites**
- Red Hat Enterprise Linux 8 (RHEL8) or compatible distribution.

**Requirements**
- Administrative privileges.

## Preparing for Software Installation

### Updating the Operating System.

It is generally best practice to update the operating system to get the latest security patches and software updates before installing any new software.

Execute the following command to update the operating system:

```
sudo dnf -y update
```

Restart the server for the changes to apply.

### Installing EPEL (Extra Packages for Enterprise Linux)

Please visit [Extra Packages for Enterprise Linux](https://docs.fedoraproject.org/en-US/epel/) for more information.

Execute the following command to install additional open source packages:

```
sudo dnf -y install epel-release
```

Run update again to pull the packages:

```
sudo dnf -y update
```

## Installing Development Tools:

### Installing Java SE Development Kit 8

JDK 8 is required to import i2b2 data into the database and to build and run i2b2 Hive.

Execute the following command to install OpenJDK 8:

```
sudo dnf -y install java-1.8.0-openjdk java-1.8.0-openjdk-devel
```

### Installing Apache Ant 1.10.x

Apache Ant is required to to import i2b2 data into the database and to build i2b2 Hive.

Execute the following command to download Apache Ant:

```
sudo curl -s -L -o /tmp/apache-ant.tar.gz https://dlcdn.apache.org//ant/binaries/apache-ant-1.10.12-bin.tar.gz
```

Extract Apache Ant to **/usr/local/** directory:

```
sudo tar zxf /tmp/apache-ant.tar.gz -C /usr/local/
```

Clean up Apache Ant temp file:

```
sudo rm -rf /tmp/apache-ant.tar.gz 
```

Create a symbolic link to the **ant** command:

```
sudo ln -s /usr/local/apache-ant-1.10.12/bin/ant /usr/bin/
```

### Setting the Environment Variables

Add the following lines in the file **/etc/profile**:

```
export JAVA_HOME=/usr/lib/jvm/java-1.8.0-openjdk
export ANT_HOME=/usr/local/apache-ant-1.10.12
```

> It is always a good idea to create a backup of the file before modifying it.

Restart the server for the changes to apply.

## Installing Web Application Servers

### Installing Apache HTTP Server With SSL Support

Execute the following command to install Apache HTTP server:

```
sudo dnf -y install httpd mod_ssl
```

#### Adding to Systemd Services


Execute the following command to enable the Apache HTTP Server to run on startup:

```
sudo systemctl enable httpd
```

Execute the following command to start the Apache HTTP Server

```
sudo systemctl start httpd
```

#### Configuring the Firewall

Add the https service to the firewall policy to allow https access outside of the network.

Execute the following command to add https service to the firewall policy permanently:

```
sudo firewall-cmd --permanent --add-service=https
```

Reload the firewall policy

```
sudo firewall-cmd --reload
```

#### Customizing the SELinux SELinux (Security-Enhanced Linux) Policy

By default SELinux prevents Apache HTTP Server scripts and modules from connecting to database servers.

Execute the following command to enable Apache HTTP Server scripts and modules to connect to database servers:

```
sudo setsebool -P httpd_can_network_connect_db on
```

#### Installing SSL Certificates

Default SSL certificates are already created and installed when mod_ssl is installed. The instruction below are for creating and installing your custom SSL certificates or for installing SSL certificates signed by a certificate authority.

##### Creating a Certificate and a Key self-signed for HTTPS

You can create your own self-signed certificate and key if you don't have the official ones provided by the Certificate Authority.

Execute the follow to generate your own certificate and key that expires in 10 years:

```
sudo openssl req -x509 -newkey rsa:3072 -keyout /etc/pki/tls/private/$(hostname -f).key -out /etc/pki/tls/certs/$(hostname -f).crt -nodes -days 3650
```

##### Installing a Certificate and a Key self-signed for HTTPS

- Place the HTTPS Server Certificate (Public Key) in the folder **/etc/pki/tls/certs**. For an example, ***/etc/pki/tls/certs/localhost.crt***.
- Place the HTTPS Server Key (Private Key) in the folder **/etc/pki/tls/private**. For an example, ***/etc/pki/tls/private/localhost.key***.
- Place CA Cert in the directory **/etc/pki/tls/certs**.

#### Installing PHP 7

Execute the following command to install PHP 7 for the Apache HTTP Server:

```
sudo dnf -y install php php-cli php-common php-fpm php-bcmath php-gd \
php-mbstring php-xml php-xmlrpc php-zip php-pgsql php-curl php-pear php-json
```

Execute the following command to restart the Apache HTTP server for the PHP module to registered:

```
sudo systemctl restart httpd
```

### Installing Wildfly 17.0.1

#### Installing Wildfly

Execute the following command to download Wildfly to tmp directory:

```
sudo curl -s -L -o /tmp/wildfly-17.0.1.Final.tar.gz \
https://download.jboss.org/wildfly/17.0.1.Final/wildfly-17.0.1.Final.tar.gz
```

Extract Wildfly to **/opt** directory:

```
sudo tar xvf /tmp/wildfly-17.0.1.Final.tar.gz -C /opt/
```

Rename installation folder:

```
sudo mv /opt/wildfly-17.0.1.Final /opt/wildfly
```

Clean up.  Remove temporary file:

```
sudo rm -rf /tmp/wildfly-17.0.1.Final.tar.gz
```

#### Creating System User and Group

WildFly should never be run as the root user due to the security risks. We need to create a new system user and group for Wildfly.

Execute the following command to create a system group called **wildfly**:

```
sudo groupadd -r wildfly
```

Create system user wildfly and added it to the group wildfly:

```
sudo useradd -r -g wildfly -s /sbin/nologin wildfly
```

#### Configuring Installation

Execute the following command to create the directory for the WildFly configuration file:

```
sudo mkdir /etc/wildfly
```

Copy the configuration file to new directory:

```
sudo cp /opt/wildfly/docs/contrib/scripts/systemd/wildfly.conf \
/etc/wildfly/
```

Modify the file **/etc/wildfly/wildfly.conf** to bind Wildfly only to host 127.0.0.1:

```
# The address to bind to
WILDFLY_BIND=127.0.0.1
```

> It is always a good idea to create a backup of the file before modifying it.

Copy the WildFly launch.sh script to the binary directory:

```
sudo cp /opt/wildfly/docs/contrib/scripts/systemd/launch.sh \
/opt/wildfly/bin/
```

Set the script is inside binary directory to be executable:

```
sudo sh -c 'chmod +x /opt/wildfly/bin/*.sh'
```

#### Change Installation Ownership

Execute the following command to change the ownership from ***root*** to ***wildfly***:

```
sudo chown -RH wildfly: /opt/wildfly/
```

#### Adding to Systemd Services

Execute the following command to copy the systemd unit service file now to /etc/systemd/system/ directory:

```
sudo cp /opt/wildfly/docs/contrib/scripts/systemd/wildfly.service \
/etc/systemd/system/
```

Notify systemd that a new service unit file is in place:

```
sudo systemctl daemon-reload
```

Enable Wildfly to run on startup:

```
sudo systemctl enable wildfly
```

Start Wildfly

```
sudo systemctl start wildfly
```

#### Checking Wildfly Status

Execute the following command to check the current status of Wildfly:

```
sudo systemctl status wildfly
```

You should see something similar to the following if Wildfly is running properly;

```
● wildfly.service - The WildFly Application Server
   Loaded: loaded (/etc/systemd/system/wildfly.service; enabled; vendor preset: disabled)
   Active: active (running) since Wed 2022-04-13 15:30:36 EDT; 39s ago
 Main PID: 2334 (launch.sh)
    Tasks: 44 (limit: 24785)
   Memory: 439.6M
   CGroup: /system.slice/wildfly.service
           ├─2334 /bin/bash /opt/wildfly/bin/launch.sh standalone standalone.xml 0.0.0.0
           ├─2335 /bin/sh /opt/wildfly/bin/standalone.sh -c standalone.xml -b 0.0.0.0
           └─2392 java -D[Standalone] -server -Xms64m -Xmx512m -XX:MetaspaceSize=96M -XX:MaxMetaspaceSize=256m -Djava.net.preferIPv4Stack=true -Djboss.modules.system.pkgs=org.jboss.byteman -Djava.awt.headless=t>

Apr 13 15:30:36 localhost.localdomain systemd[1]: Started The WildFly Application Server.
```

## Installing Database:

### Installing PostgreSQL Database

#### Installing PostgreSQL 10

Execute the following command to install PostgreSQL database:

```
sudo dnf -y install postgresql postgresql-server postgresql-contrib
```

Initialize the database:

```
sudo postgresql-setup --initdb --unit postgresql
```

#### Configuring PostgreSQL

##### Modifying the File /var/lib/pgsql/data/postgresql.conf

Uncomment line 59 to:

```
listen_addresses = '*'                  # what IP address(es) to listen on;
```

Uncomment line 63 to:

```
port = 5432                            # (change requires restart)
```

##### Modifying the File /var/lib/pgsql/data/pg_hba.conf

Edit the file as shown below (line 77-84):

```
# TYPE  DATABASE        USER            ADDRESS                 METHOD

# "local" is for Unix domain socket connections only
local   all             all                                     peer
# IPv4 local connections:
host    all             all             127.0.0.1/32            md5
# IPv6 local connections:
host    all             all             ::1/128                 md5
host    all             all             0.0.0.0/0               trust
```

#### Adding to Systemd Services

Enable PostgreSQL to run on startup:

```
sudo systemctl enable postgresql
```

Start PostgreSQL:

```
sudo systemctl start postgresql
```

#### Configuring the Firewall

Add the PostgreSQL service to the firewall policy to allow access outside of the network.

Execute the following command to add PostgreSQL service to the firewall policy permanently:

```
sudo firewall-cmd --zone=public --permanent --add-service=postgresql
```

Reload the firewall policy

```
sudo firewall-cmd --reload
```

## Installing i2b2

### Installing i2b2 Demo Data (PostgreSQL)

#### Creating i2b2 Database and Users

Exectute the following commands to download script to create i2b2 database and users:

```
sudo curl -s -L -o /tmp/create_database.sql https://raw.githubusercontent.com/kvb2univpitt/i2b2-saml-demo/main/doc/rhel8/create_database.sql
```
Create i2b2 database and users:

```
sudo -i -u postgres psql -f /tmp/create_database.sql
```

You should see the output similar to this:

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

Remove temporary file:

```
sudo rm -rf /tmp/create_database.sql
```

#### Importing i2b2 Data

##### Downloading i2b2 Demo Data

Execute the following command to download i2b2 demo data:

```
sudo curl -s -L -o /tmp/v1.7.12a.0001.zip \
https://github.com/i2b2/i2b2-data/archive/refs/tags/v1.7.12a.0001.zip
```

Extract the zip file:

```
sudo unzip /tmp/v1.7.12a.0001.zip -d /opt/
```

Remove temporary file:

```
sudo rm -rf /tmp/v1.7.12a.0001.zip
```

##### Configuring db.properties Files

Modify the file **/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Crcdata/db.properties** as shown below:

```properties
db.type=postgresql
db.username=i2b2demodata
db.password=demouser
db.driver=org.postgresql.Driver
db.url=jdbc:postgresql://localhost:5432/i2b2
db.project=demo
```

Modify the file **/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Hivedata/db.properties** as shown below:

```properties
db.type=postgresql
db.username=i2b2hive
db.password=demouser
db.driver=org.postgresql.Driver
db.url=jdbc:postgresql://localhost:5432/i2b2
```

Modify the file **/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Imdata/db.properties** as shown below:

```properties
db.type=postgresql
db.username=i2b2imdata
db.password=demouser
db.driver=org.postgresql.Driver
db.url=jdbc:postgresql://localhost:5432/i2b2
```

Modify the file **/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Metadata/db.properties** as shown below:

```properties
db.type=postgresql
db.username=i2b2metadata
db.password=demouser
db.driver=org.postgresql.Driver
db.url=jdbc:postgresql://localhost:5432/i2b2
db.project=demo
db.dimension=OBSERVATION_FACT
db.schemaname=public
```

Modify the file **/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Pmdata/db.properties** as shown below:

```properties
db.type=postgresql
db.username=i2b2pm
db.password=demouser
db.driver=org.postgresql.Driver
db.url=jdbc:postgresql://localhost:5432/i2b2
db.project=demo
```

Modify the file **/opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/Workdata/db.properties** as shown below:

```properties
db.type=postgresql
db.username=i2b2workdata
db.password=demouser
db.driver=org.postgresql.Driver
db.url=jdbc:postgresql://localhost:5432/i2b2
db.project=demo
```

##### Import Data

Execute the following command to import i2b2 demo data into the database:

```
sudo /opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/apache-ant/bin/ant \
-f /opt/i2b2-data-1.7.12a.0001/edu.harvard.i2b2.data/Release_1-7/NewInstall/build.xml \
create_database load_demodata
```
