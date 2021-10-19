<?php

$metadata['https://localhost/shibboleth'] = [
    'entityid' => 'https://localhost/shibboleth',
    'contacts' => [],
    'metadata-set' => 'saml20-sp-remote',
    'AssertionConsumerService' => [
        [
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
            'Location' => 'https://localhost/Shibboleth.sso/SAML2/POST',
            'index' => 1,
        ],
        [
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
            'Location' => 'https://localhost/Shibboleth.sso/SAML2/POST-SimpleSign',
            'index' => 2,
        ],
        [
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact',
            'Location' => 'https://localhost/Shibboleth.sso/SAML2/Artifact',
            'index' => 3,
        ],
        [
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:PAOS',
            'Location' => 'https://localhost/Shibboleth.sso/SAML2/ECP',
            'index' => 4,
        ],
    ],
    'SingleLogoutService' => [
        [
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
            'Location' => 'https://localhost/Shibboleth.sso/SLO/SOAP',
        ],
        [
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
            'Location' => 'https://localhost/Shibboleth.sso/SLO/Redirect',
        ],
        [
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
            'Location' => 'https://localhost/Shibboleth.sso/SLO/POST',
        ],
        [
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact',
            'Location' => 'https://localhost/Shibboleth.sso/SLO/Artifact',
        ],
    ],
    'keys' => [
        [
            'encryption' => false,
            'signing' => true,
            'type' => 'X509Certificate',
            'X509Certificate' => 'MIID6zCCAlOgAwIBAgIJANKLeZidZkNWMA0GCSqGSIb3DQEBCwUAMBcxFTATBgNV
                        BAMTDDNmZDNjYWM2NDI4ZDAeFw0yMTEwMTkxNzEzNDZaFw0zMTEwMTcxNzEzNDZa
                        MBcxFTATBgNVBAMTDDNmZDNjYWM2NDI4ZDCCAaIwDQYJKoZIhvcNAQEBBQADggGP
                        ADCCAYoCggGBAKrHGUFdJXJ7YNre1/KwyHaEXz62DzaFWkqTZtLMcq+uotXf+aJt
                        PvT5/kLOW60VkhXSqqaYoKmJjzRkff1vcgItL3ABlvSEbcQrJyHmzJl9DbMURjK9
                        yfq6NcB2GqSK4UWfLoVcc/RamZBv69U0rsc/XBOmLCWV0zPqP90B1Dl+rj0Pf21u
                        EJAAxM2LCBrZ7N2vk3Ykrlawt3o+6WF3lcSQFLxp2m+MpJRlGehzYeE/nskvsUqa
                        DDdCLdaPDuOj/VVITIhuaL0Fb7mzKDBLpPL6ANqzuEUzJld3so6gBxJK+08rxEgu
                        70StTRoIagZdHVupcEFjsGZUM5La9HztXYQyJOvSqE4wyL4aPWEo9tT7oiZApxdd
                        XQKy6poNHKlEF6pGCyE+HSYDGQYax2gDMUFKzaOGhg+hc4QxKKSHflPymOURG4Tb
                        40U0KqP0egki6leERvJDrR2SpnaGltjOheRMcbAEq37LGK8chaZMtjtO429kxvjR
                        YrC+NFPioR4VYQIDAQABozowODAXBgNVHREEEDAOggwzZmQzY2FjNjQyOGQwHQYD
                        VR0OBBYEFMVeDGqzIFHnCPUApDpLQf/8ckVAMA0GCSqGSIb3DQEBCwUAA4IBgQAl
                        IYnC3Q6zfLMUcHiKG0PjWs6Z0aYqaSkXjCP4/twklUgG1nZJH7aai0AJF2jW4OpW
                        0gCuHK2kcCbs6PaScy9QzNI53IcTC9rN+sy3ObibmZNUy68cyMBd+8DhDU1qNyAP
                        FVgOugwJxyM7MNlm7fmkiCRGPzjCrjpabm2Yqj2Did0Nt1CmT7DOb1uxh3hESCTu
                        xv3gwQLDUB/NTKQuskurpv3LsYj1gzQDnS68QAixYz9yB3IVwBpesiBMKCQrAoUB
                        SBAJ23xSluBXK9U7pJa955aKJkMiQ4XSZAEu+ODBLg6mv5PtPxfDi0N9HCN7iZUx
                        8xa2cr9IKPHa6rIS62o3Zw25OYzWcNqK6+gl5ueO50FU2OduwLZY/Nm94NVN0SXI
                        ND+iue1srM8aK5sfTq5B9rIJ0ShcEtXyVql1so8cMQ5jebzNhWkkvgVAhLOf/9ts
                        mqGs4B9ayjdo/sbg2w4FZfub4rzCORG67KYicIgAYz+DViJN2IoV96FAMWzh4Ig=',
        ],
        [
            'encryption' => true,
            'signing' => false,
            'type' => 'X509Certificate',
            'X509Certificate' => 'MIID6zCCAlOgAwIBAgIJAOKS8g1D1F8JMA0GCSqGSIb3DQEBCwUAMBcxFTATBgNV
                        BAMTDDNmZDNjYWM2NDI4ZDAeFw0yMTEwMTkxNzEzNDZaFw0zMTEwMTcxNzEzNDZa
                        MBcxFTATBgNVBAMTDDNmZDNjYWM2NDI4ZDCCAaIwDQYJKoZIhvcNAQEBBQADggGP
                        ADCCAYoCggGBAL0G/XNetiFaG0vYw6VI2c6IBCFD4G9BMr7zKTMacC4SOKwGzEyx
                        o9QJSisB77ZnYltMO86lABuI3+gW+pnVeyNe4rviHWoa8ifCvOv1ah/XkIutH26m
                        XHwc7n6SWjIM7E8W09ZbQVZPEAdGxa80SLGgSE3ZR4tzkvyRIBJStv+XYMVY5kf2
                        ijmn5/6bYeEPmXSUVgz6qvejQ0D7AUz08Zf1gOeGtcvxeFAtfJEMEl1O0qdCBC33
                        Fu0JS8pHsQ5moX48ctF8sXox3OPY+gGgW1ea4TPUXCJMQ0zWHJtkaoNP/k9Z4iFc
                        1wpXtXSUa3F8toCbEpcm3HNtYujfV+nLC4dIBJUuZe3/Af3CxuWw/KQM3rVYoUop
                        spYuqhIA39y7KBTgP6QJiWoGkVEsYdBrmixsg/jwG3ZSPqdDYrsKSDWNGBBdEyuj
                        2TtBLlId55ngbeILY2Y6anAobfEbGFHd4XtORSywjpnNwvpfPuCN8AF0dejxA7Ky
                        9usdshsUWjdETQIDAQABozowODAXBgNVHREEEDAOggwzZmQzY2FjNjQyOGQwHQYD
                        VR0OBBYEFIKWRu1MS1WTmlSaoyBl8AEcbsLhMA0GCSqGSIb3DQEBCwUAA4IBgQAq
                        xhcar4YUNtqjKMH7ZzT8MHlhq8M8A/odo0nplTYQsQS2IQZcSDDnAeydectDIQge
                        PACh70SPVTZwv+2CNtQT6gvq4heRTAj82Tf0W70fczZNtQCL9u4ydgx+TjNEvcKr
                        AKVJ1sQdrXrFgUlojFQUBITCLelBeHS7pVUfkiaNgJBnqwrpqKqMrsfpoRiQxOe1
                        oVhAmXoPTqW5PFtovZyf204rqaskWKJgfqGXzg806kjIKJl3cJkwmB2td7CzHiRB
                        yLHGM1k8U8pW6Ay5eg2XcFdhlpQLUMbECOv5UbaZjewHDnxMtlEYAXOq0l6YSj5i
                        umBB5FsD7ctzQji8HToSlrOAJMLWvfG+EQPUEqk8AfifR0C/HCwc2KO04a0Dofm7
                        oGoKhO+AKGVmzACZnpC/BqyFvVQPo1K/7Ok6PMk/cWCADnTe5YKbi2So3bcN9yVO
                        V1Fv3EhP4lkaC770W+EMlcYr44xOjiIll0BTnk0/Wzaw9JDD44mmCGyJzwugFWU=',
        ],
    ],
    'validate.authnrequest' => true,
    'validate.logout' => true,
    'sign.logout' => true,
    'redirect.sign' => true,
    'redirect.validate' => true,
];
