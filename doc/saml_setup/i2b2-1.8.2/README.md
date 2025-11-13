# SAML Setup  For i2b2 1.8.2 Release

A guide for configuring i2b2 with SAML-Based single sign-on with Shibboleth.

> This guide uses ***sp.example.org*** as the domain name for the service provider (SP).  Please replace ***sp.example.org*** with your domain name.

**Prerequisites**

The following applications and services must be already setup and running:

- RHEL 8.x
- Shibboleth 3.x
- i2b2 database 1.8.2 release
- i2b2 core server 1.8.2 release
- i2b2 web client 1.8.2 release

**Requirements**
- Administrative privileges.

## Configuring Shibboleth

### Configuring the Apache HTTP Server

Modify the ***shib.conf*** located in the directory **/etc/httpd/conf.d**.

Delete the following configuration:

```
<Location /secure>
  AuthType shibboleth
  ShibRequestSetting requireSession 1
  require shib-session
</Location>
```

Add the following configuration:

```
<Location />
  AuthType shibboleth
  ShibRequestSetting requireSession 0
  require shibboleth
</Location>
```

### Setting Up Federation Files and Metadata

Your institution should provide you the IdP metadata to register your application or service with their Identity Provider (IdP).  For an example, the Harvard University Information Technology (HUIT) provides a guide and files to reigister with their IdP: https://iam.harvard.edu/resources/saml-shibboleth-integration.

#### Updating the Shibboleth2 XML File

Modify the ***/etc/shibboleth/shibboleth2.xml*** file.

##### Update the SP Entity ID:

Modify the attributes of the **ApplicationDefaults** element as follow:

```xml
<!-- The ApplicationDefaults element is where most of Shibboleth's SAML bits are defined. -->
<ApplicationDefaults entityID="https://sp.example.org/shibboleth"
                        REMOTE_USER="eduPersonPrincipalName,eppn"
                        cipherSuites="DEFAULT:!EXP:!LOW:!aNULL:!eNULL:!DES:!IDEA:!SEED:!RC4:!3DES:!kRSA:!SSLv2:!SSLv3:!TLSv1:!TLSv1.1"
                        signing="true"
                        attributePrefix="AJP_">
```

> Remember to replace *sp.example.org* with your domain name.

##### Set the IdP Entity ID:

Modify the ```<SSO>``` tag as follow to set the IdP entity ID:

```xml
<SSO entityID="https://idp.example.org/saml2">
    SAML2
</SSO>
```
> Remember to replace *https://idp.example.org/saml2* with your IdP entity.  Your IdP entity can be found in your IdP metadata.

##### Modify the ```<Handler>``` Tags:

Replace the following:

```xml
<!-- Extension service that generates "approximate" metadata based on SP configuration. -->
<Handler type="MetadataGenerator" Location="/Metadata" signing="true"/>

<!-- Session diagnostic service. -->
<Handler type="Session" Location="/Session" showAttributeValues="true"/>
```

##### Point to the IdP Metadata:

The IdP metadata file should be placed in the directory **/etc/shibboleth**.  In this example, the IdP metadata file is ***/etc/shibboleth/federation-metadata.xml***.

Add the following:

```xml
<!-- Example of locally maintained metadata. -->
<MetadataProvider type="XML" validate="true" path="federation-metadata.xml"/>
```

> Remember to replace ***federation-metadata.xml*** with the name of your IdP metadata file located in the directory /etc/shibboleth.

#### Updating the Attribute-Map XML File

The ***attribute-map.xml***, located in the directory **/etc/shibboleth**, contains the names of the SAML 2.0 attributes that can be mapped to the IdP attributes.

Add the following attribute mapping to the file ***/etc/shibboleth/attribute-map.xml***.
```xml
<Attribute name="uid" nameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:basic" id="uid"/>
<Attribute name="eduPersonPrincipalName" nameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:basic" id="eduPersonPrincipalName"/>
<Attribute name="eduPersonAffiliation" nameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:basic" id="eduPersonAffiliation"/>
<Attribute name="mail" nameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:basic" id="mail"/>
<Attribute name="displayName" nameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:basic" id="displayName"/>
<Attribute name="givenName" nameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:basic" id="givenName"/>
<Attribute name="sn" nameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:basic" id="sn"/>
```

> Note that your IdP attributes may be different.  Please change the attribute **name** to the correct IdP attribute name.  Do **NOT** change the **id** attribute.

If you are not getting the attribute **eduPersonPrincipalName** returned after you sign in with your IdP, you will need to aliases your eppn by adding ```aliases="eduPersonPrincipalName"```:

```xml
<Attribute name="urn:oid:1.3.6.1.4.1.5923.1.1.1.6" id="eppn" aliases="eduPersonPrincipalName">
    <AttributeDecoder xsi:type="ScopedAttributeDecoder" caseSensitive="false"/>
</Attribute>
<Attribute name="urn:mace:dir:attribute-def:eduPersonPrincipalName" id="eppn" aliases="eduPersonPrincipalName">
    <AttributeDecoder xsi:type="ScopedAttributeDecoder" caseSensitive="false"/>
</Attribute>
```

#### Getting the Service Provider Metadata

Open up a web browser and navigate to ***https://sp.example.org/Shibboleth.sso/Metadata***.  You should see a dialog for opening the metadata file ***Metadata***.  Instead of opening it up, download it onto your computer.

![Download Metadata](./metadata_download.png)

> You can rename the file Metadata to Metadata.xml for readability.

The metadata file contains information about the Service Provider (SP) including the entity ID and the public certificates for signing and encryption.  Regisiter this file with your Identity Provider (IdP).

> Note that the signing certificate and encryption certificate included in the metadata file are from ***/etc/shibboleth/sp-signing-cert.pem*** and ***/etc/shibboleth/sp-encrypt-cert.pem***, respectively.  If you want to use your own certificates, just replace them along with the private keys and regenerate the metadata.
