# Installation Guide For i2b2 on Red Hat Enterprise Linux 8 (RHEL 8)

This documentation provides steps on how to install the SAML version of the i2b2 software along with its dependencies.

> Note: Most of the commands below require admin privilege.  You will need root access to execute these commands.

## Table of Contents

1. [Operation System Setup](#operation-system-setup)
    1. [Updating the Operating System](#updating-the-operating-system)
    2. [Installing Extra Packages for Enterprise Linux (EPEL)](#installing-extra-packages-for-enterprise-linux--epel-)
2. [Installing the Web Servers](#installing-the-web-servers)
    1. [Installing the Apache HTTP Server With SSL v3 and TLS v1.x Support](#installing-the-apache-http-server-with-ssl-v3-and-tls-v1x-support)
        1. [Installation](#installation)
        2. [Firewall Configuration](#firewall-configuration)
        3. [SSL Certificates Installation](#ssl-certificates-installation)
            1. [Creating a Certificate and a Key self-signed for HTTPS](#creating-a-certificate-and-a-key-self-signed-for-https)
            2. [Installing a Certificate and a Key self-signed for HTTPS](#installing-a-certificate-and-a-key-self-signed-for-https)

## Operation System Setup

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

Run the update to download the repository files 

```
dnf -y update
```

## Installing the Web Servers

### Installing the Apache HTTP Server With SSL v3 and TLS v1.x Support

#### Installation

Execute the following command to install the Apache HTTP Server and SSL module

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

#### Firewall Configuration

Configure the firewall to allow https access.

Add https to the firewall list permanently:

```
firewall-cmd --permanent --add-service=https
```

Reload the firewall policy:

```
firewall-cmd --reload
```

#### SSL Certificates Installation

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
