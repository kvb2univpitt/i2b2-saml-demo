# Installation Guide for i2b2 With Federated Login on Red Hat Enterprise Linux 8 (RHEL 8)
This documentation provides a guide on how to build, configure, and deploy i2b2 application with federated login.

### Prerequisite

The following applications are required to run the applications:

- Apache HTTP web server 2.4 with SSL
- PHP 7
- PostgreSQL 12 or above
- Wildfly 17.0.1.Final

The following tools are required for building the applications:
- OpenJDK 1.8
- Apache Ant 1.10

## Update the Operating System

```
dnf -y -y update
```

## Install Extra Packages for Enterprise Linux (EPEL)

EPEL provides a set of additional packages for RHEL from the Fedora Project.  For more information, please visit [What's EPEL, and how do I use it?](https://www.redhat.com/en/blog/whats-epel-and-how-do-i-use-it).

Execute the following command to install EPEL and update the operating system:

```
dnf -y install epel-release
dnf -y -y update
```

## Install Apache HTTP Server With SSL

Install the Apache HTTP Server:

```
dnf -y install httpd mod_ssl
```

Start and enable the Apache HTTP Server:

```
systemctl enable httpd
systemctl start httpd
```

Configure the firewall for allowing https access:

```
firewall-cmd --permanent --add-service=https
firewall-cmd --reload
```

Configure SELinux to allow the Apache HTTP Server to communicate with database:

```
setsebool -P httpd_can_network_connect_db on
```

## Install PHP 7 and dependencies

```
dnf -y install php php-cli php-common php-fpm php-bcmath php-gd \
php-mbstring php-xml php-xmlrpc php-zip php-pgsql php-curl php-pear php-json
```

Rest the Apache HTTP Server:

```
systemctl restart httpd
```

## Install Development Tools

### Install OpenJDK 8

```
dnf -y install java-1.8.0-openjdk java-1.8.0-openjdk-devel
```

### Install Apache Ant 1.10.x

Download Apache Ant to a temp folder:

```
curl -s -L -o /tmp/apache-ant.tar.gz https://dlcdn.apache.org//ant/binaries/apache-ant-1.10.12-bin.tar.gz
```

Extract Apache Ant to **/usr/local/** directory:

```
tar zxf /tmp/apache-ant.tar.gz -C /usr/local/
```

Delete Apache Ant temp file:

```
rm -rf /tmp/apache-ant.tar.gz 
```

Create a symbolic link to the **ant** command:

```
ln -s /usr/local/apache-ant-1.10.12/bin/ant /usr/bin/
```

### Set the Environment Variables

Add the following lines in the file **/etc/profile**:

```
export JAVA_HOME=/usr/lib/jvm/java-1.8.0-openjdk
export ANT_HOME=/usr/local/apache-ant-1.10.12
```