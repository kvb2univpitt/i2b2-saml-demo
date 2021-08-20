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
            'X509Certificate' => 'MIID6zCCAlOgAwIBAgIJAKMwWSZwfEiDMA0GCSqGSIb3DQEBCwUAMBcxFTATBgNV
                        BAMTDGNlMTQ1YTYyMTlhNDAeFw0yMTA4MjAxODEyMzBaFw0zMTA4MTgxODEyMzBa
                        MBcxFTATBgNVBAMTDGNlMTQ1YTYyMTlhNDCCAaIwDQYJKoZIhvcNAQEBBQADggGP
                        ADCCAYoCggGBAKloMuJpL8PI+kWtgktwFIwgwHpOqOuFSU+yCYqaFst+ESqQHwio
                        1dO0AOIALBlvMKHfuSRoRCNjn/ouQwS/KcWMD1x+XnOU8Cvl15SkMhoQm3h4NSkt
                        FsH8hfnJ7U8g+Iil9PhIewMjNiMMeDZKaNugyML5W0LiQ9XVowTe/O+7/DE/BkpU
                        yZLQJ5WCc6R1OgmBzgiARVRlXM3CScCzlKu28sLAjKXbsvBoaiovanWI0NzoRm2i
                        /UFyWH5zvKtENIN7c2afKLySR5bIQZ8ce39IOYtOsnNMMODPGLSl+78kEtZSXgmY
                        9SdFxM3uFhLsO9eKq0lBKVDV8nmsjHCkQ9aDW8wZSupDoee1YNeTv+tmyxz0Y1Rj
                        275UcEZpSFDj83uaeCWZq+wk15kNaW+srJuSn9YSef/i1awoqFtHg0Elq4mZ6rV6
                        Cb3XtFlgMNjLpO+BF3gFjCXpnBp2hrZJ6Wnnb5tGKKJpwERhW5jBxbBJwr59rKd+
                        Y+SM74XcKu2+qQIDAQABozowODAXBgNVHREEEDAOggxjZTE0NWE2MjE5YTQwHQYD
                        VR0OBBYEFLPeqAINSTgADicI6QCwcFO9kmHrMA0GCSqGSIb3DQEBCwUAA4IBgQCD
                        Nhf8fYqo7JB0gTzl0bspwe7762yMi6Hr27XttzVaifHemUGpV1AzEiQkqON5HkQ0
                        /whk7gn10MUMTvgYQSGKJPJaUK5nTB5UY+KiymzpFCwdYtBAYrWyXP3WVfYUSlKq
                        oPqE4A7+tLPBoAUm1uqR4tJQDg2atA9Ht697Ap5T9lig/aAe5Z8c8SPfT7npunO2
                        vXIW7FH+cAVkSrpNBQjcXaENFgqccE27mrSrMF2MUqmqk9qA4LIZ7tGEPyc7hhLr
                        2hMJjQmNJTuiBJg4gV9O05VQu/dVhZD9KH9qSN+tvviWozHAiruhhTMaG3Lm7+rz
                        s+o+GmmPDHDOA7VM0F1eYDdnUu3HKaQAPp6yEQROfqjdlVluXA7jEzxRROovldsO
                        rxuty+I+UPD4sf7YG081v6aZk0BTT1QIC8ERXVTpCtOQ5IiWCQg4YFetDmw1SK1p
                        hSqz/sE9pYlc4lpbInXHbOTLNNSeWdQ2YZp8ep7bLp4aG7b15gAxtrYRmvFcops=',
        ],
        [
            'encryption' => true,
            'signing' => false,
            'type' => 'X509Certificate',
            'X509Certificate' => 'MIID6zCCAlOgAwIBAgIJAN0uYflgzBhSMA0GCSqGSIb3DQEBCwUAMBcxFTATBgNV
                        BAMTDGNlMTQ1YTYyMTlhNDAeFw0yMTA4MjAxODEyMzBaFw0zMTA4MTgxODEyMzBa
                        MBcxFTATBgNVBAMTDGNlMTQ1YTYyMTlhNDCCAaIwDQYJKoZIhvcNAQEBBQADggGP
                        ADCCAYoCggGBAJu47y5bJcUpRABzvSUtxgpxw17UbxxlL9jZ7ZN7rKFDz19BZsHx
                        mkcgof5QqwSVMmZKwz+jLHWtnldEfEDzqnA7YvB1JrIAqHA197zqM8ocFVptjUB1
                        z3bvU/em7x3aHM/5aDS51Txoh6zTpEfPSxRSGKiw0rgxwMRdXUE4jzXmvHhHXGbz
                        iDhKTcB7e7tPPoxJhpWJkoRiM+FsionWSrIEkyZjvRFYGHzdHamgVRx2cpI3/F1H
                        4PN1dGsVOGY6j21HGfrQuVqfEEFh0QQMxjI0jN7m6ZhQM8STgpzlLbkue0FFc+1d
                        pLV0DxdcEkv8X0GTWDvzMhwjcSIveCYk/jr+NNge2s85cGx8kzUTCVDrJIUpjf5q
                        RyMxKOrW1PEkV9J6uuRdmo4W9VAS8ef6Z6FIIr1G70IlYbH64bKJ4+IirM3mymcw
                        2QBgzB8ak3j3tx0XpWPd2i7BQ9v+fOOAU8vClmJIpW8inpFUn7D/m25V/WVKvfXo
                        Ts3qDTJRRMl+5QIDAQABozowODAXBgNVHREEEDAOggxjZTE0NWE2MjE5YTQwHQYD
                        VR0OBBYEFO1KmERbH4uQ7fqQ+ZbZltxgl9+zMA0GCSqGSIb3DQEBCwUAA4IBgQCa
                        e5DHsNSEFESn7A+1N6x37jHcHBXLLLxqvHoxlho1jaZcvsTuI8FjBPKbKmnU9Eo0
                        +f1ESMGq7U7kLCuWPOgVqOq3ozu8KnRIWoxC95V3/N/qFz09Cx7MPpothr9Q8wjd
                        UOqm9gkT6D/4DSfGZt6IihPVEfcBFvsbxSVHH4oYhUvBCZfw9AZHuyZL3GleolXF
                        OqBdsqjAbbJ2/VxcUqjWOvNEVSr0mGXO4lqQESSvKSdMhwiD+KPVmTrZtm7CVOYu
                        nHo2yUX41lqkPGXib+7R/WJhZcAYMPmrDaYccsaOV+vhCEzC3mRieuzCzKqZ0MlP
                        FJU8vMkxWLh9TwQF/eIcPh5lTJSIVv5Yp8XWS+/N1tow9OKrc7V8teEK6xc4btmD
                        8bZB/WZQ+W6PYsi7g/meBDMS/VBjzX0yngh+HCvM3P3cpYL7UjolpF+HEdkCfJx1
                        ksuD2P9/4ooswBMjSs4AP1edjswGnqf7ZMTPnwbPERJ8J+ujsfJ/GAB5zFOvRp8=',
        ],
    ],
    'validate.authnrequest' => true,
    'validate.logout' => true,
    'sign.logout' => true,
    'redirect.sign' => true,
    'redirect.validate' => true,
];
