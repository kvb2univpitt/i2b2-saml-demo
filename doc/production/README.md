# Installation Guide For i2b2 on Red Hat Enterprise Linux 8 (RHEL 8)

This documentation provides steps on how to install the SAML version of the i2b2 software along with its dependencies.

> Note: Most of the commands below require admin privilege.  You will need root access to execute these commands.

## Table of Contents

1. [Operating System Setup](#operating-system-setup)
    1. [Updating the Operating System](#updating-the-operating-system)
    2. [Installing Extra Packages for Enterprise Linux (EPEL)](#installing-extra-packages-for-enterprise-linux--epel-)
2. [Installing Development Tools](#installing-development-tools)
    1. [Installing OpenJDK 8](#installing-openjdk-8)
    2. [Installing Apache Ant 1.10.x](#installing-apache-ant-110x)
    3. [Setting the Environment Variables](#setting-the-environment-variables)
    4. [Restarting the Server](#restarting-the-server)
3. [Installing Web Servers](#installing-web-servers)
    1. [Installing Apache HTTP Server With PHP 7.x and SSL v3 and TLS v1.x Support](#installing-apache-http-server-with-php-7x-and-ssl-v3-and-tls-v1x-support)
        1. [Installing Apache HTTP Server](#installing-apache-http-server)
        2. [Configurating Firewall For the Apache HTTP Server](#configurating-firewall-for-the-apache-http-server)
        3. [Configurating SELinux For the Apache HTTP Server](#configurating-selinux-for-the-apache-http-server)
        4. [Installing SSL Certificates](#installing-ssl-certificates)
            1. [Creating a Certificate and a Key self-signed for HTTPS](#creating-a-certificate-and-a-key-self-signed-for-https)
            2. [Installing a Certificate and a Key self-signed for HTTPS](#installing-a-certificate-and-a-key-self-signed-for-https)
        5. [Installing PHP 7](#installing-php-7)
    2. [Installing Wildfly 17.0.1](#installing-wildfly-1701)
        1. [Creating System User and Group](#creating-system-user-and-group)
        2. [Installing Wildfly](#installing-wildfly)
        3. [Configuring Wildfly](#configuring-wildfly)
        4. [Setting Up WildFly Service](#setting-up-wildfly-service)

## Operating System Setup

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

```properties
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
