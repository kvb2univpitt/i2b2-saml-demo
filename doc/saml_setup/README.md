# SAML Setup  For i2b2 (1.7.12a Release) on CentOS 7

A guide for setting up federated authentication using SAML for i2b2 on CentOS 7

> This guide uses ***sp.example.org*** as the domain name.  Please replace ***sp.example.org*** with your domain name.

**Prerequisites**

The following applications and services must be already setup and running:

- i2b2 core server 1.7.12a release
- i2b2 web client release 1.7.12a
- i2b2 database

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

## Installing Shibboleth

### Installing Shibboleth Service Provider (SP)

Add Shibboleth repository:

```
sudo wget http://download.opensuse.org/repositories/security://shibboleth/CentOS_7/security:shibboleth.repo -P /etc/yum.repos.d \
&& yum -y update
```

Install Shibboleth:

```
sudo yum -y install shibboleth
```

Enable Shibboleth and restart Apache HTTP server:

```
sudo systemctl enable shibd
sudo systemctl start shibd
sudo systemctl restart httpd
```
### Verifying Installation

Verify that Shibboleth has been properly installed.

#### Confirm Shibboleth functionality:

```
sudo shibd -t
```

You should see output response that ends with  `overall configuration is loadable, check console or log for non-fatal problems
`

#### Confirm Apache functionality:

```
sudo apache2ctl configtest
```

You should see the output `Syntax OK`.

#### Confirm shibd functionality:

Restart the web server.

Open up a web browser and navigate to ***https://sp.example.org/Shibboleth.sso/Session***.

> Note: replace sp.example.org with your domain name.

You should see the message **A valid session was not found.** in your browser.

### Setting Up Federation Files and Metadata

Your institution should provide you the IdP metadata to register your application or service with their Identity Provider (IdP).  For an example, the Harvard University Information Technology (HUIT) provides a guide and files to reigister with their IdP: https://iam.harvard.edu/resources/saml-shibboleth-integration.

