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

## Update the OS
```shell
sudo dnf -y update
```

## Install Extra Packages for Enterprise Linux (EPEL)

EPEL provides a set of additional packages for RHEL from the Fedora Project.  For more information, please visit [What's EPEL, and how do I use it?](https://www.redhat.com/en/blog/whats-epel-and-how-do-i-use-it).

Execute the following command to install EPEL and update the OS:

```shell
sudo dnf -y install epel-release && dnf -y update
```