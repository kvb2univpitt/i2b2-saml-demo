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
            'X509Certificate' => 'MIID6zCCAlOgAwIBAgIJAPZEjQLZ7eNXMA0GCSqGSIb3DQEBCwUAMBcxFTATBgNV
BAMTDDc5ZTViNWYzZDcxOTAeFw0yMTA3MDgxNDQ4NDBaFw0zMTA3MDYxNDQ4NDBa
MBcxFTATBgNVBAMTDDc5ZTViNWYzZDcxOTCCAaIwDQYJKoZIhvcNAQEBBQADggGP
ADCCAYoCggGBAMsQ4OIYj8L7wANGhSIbHnMk9qiZY5Lu7I5plJg7YRDUAMZoCLyh
Uznzbdz4jkQAuzNd7gajdo3G+9egW5w/YYgpjZAjldAAFqJv4+WaqnKbHoFUzeN3
USwf9RrLnoqqppYxvSWJECF3JiU4+HaMHec3pfqMYeNoIujk7xyJxhndqLhRi+Gx
oN8A9+gNo4NQM/pDp6MaSzG7v8eBMWXD++slj/EHQFin0N4Fq0zK+ASk0BRhQnXO
1wwjfhAtBZNTqAb33GwgdUZhC6MmTgMcShHrMVlV6nkiNKj2KdxU8eGzkriF1qhd
CD39602dCgfZ65fSiAVTuzV2/46FWNAxgq1Ou6nJ2wahz5V3O1Wd70weTrYdZEmD
19/0EdiUvjdmhPKKMiQ6TJuI4lnSaU75YQZsPHmPv3r6EEsuNXDKGGg7bWsRA+kZ
vKxjvLY53BGhfzFM5GLiixvO7CCaIzRKLa+591KkGFG923QzwBdC79X9vOjZSpaj
pTUt0oBdjr3MwQIDAQABozowODAXBgNVHREEEDAOggw3OWU1YjVmM2Q3MTkwHQYD
VR0OBBYEFBkypCB1ZEuogw+oZC18jfXjaMRmMA0GCSqGSIb3DQEBCwUAA4IBgQAV
PweGxrgMGbnZV2CqOvZmpX8xcavDXWHltaLr3JIX8CndZSqLlFUrHyZSIM3QyrJ7
7z8dmiI9r0pD4vbRkMLtsbcMLPOq5qnbeGmn1UAnfGSIdWbpwhQmGHaRgn5K7otj
99VBOU/kSIL8jGu3vyHp2ixVAo0B9QZgJaGLlltb2do0+IkSnvhjDFBv+C0MVTJB
EdF202TipHzStsCRT72No6vjkCq2Boq0AA/lLGmvF6424yQwhMFlf5Z0gjTHr50I
1lsVSij1qSQjG9PLb4bCl0Typqfslxtye9AlFPdqLkQ2UKgigQfG1HsfMDPBx6dR
pwc6U2IiJXjc/EcvK2TanToQod0VXmTo+VgcjJA/EOaEyg9qejNRtjVZsMCArQ9v
mBFKUl9kTV3o3OmC80AqOKxIBmFUUgwQKyKBO8Dg7db3VTZ6YHofGKRQtzFuQ8GI
IfdXbZOf7h6DJqlgjaYoNgTnON8GRqeLZa9pNZYwJ6nDQTzyLtPXBs0FmarkMV8=',
        ],
        [
            'encryption' => true,
            'signing' => false,
            'type' => 'X509Certificate',
            'X509Certificate' => 'MIID6zCCAlOgAwIBAgIJAN/uWXign+DOMA0GCSqGSIb3DQEBCwUAMBcxFTATBgNV
BAMTDDc5ZTViNWYzZDcxOTAeFw0yMTA3MDgxNDQ4NDBaFw0zMTA3MDYxNDQ4NDBa
MBcxFTATBgNVBAMTDDc5ZTViNWYzZDcxOTCCAaIwDQYJKoZIhvcNAQEBBQADggGP
ADCCAYoCggGBAJmo+1OXCJ4WPSIXZHgMVynaX5ERPE8qaT6xqqwh6qloWJy/7Fwd
eAtShZHR6Vj2JcKoqvc2Cbg31e19JYSnMalytzlQ1WdIXCxzjp9yCy4P7lPhjwmn
l1gv/eSL55RUf7via0g7ltQT070fvzp235PATOh+cmu08ZImvF+ZgcY0kOPqXa23
he6dd27mtipW9id0zeiBroPp/6y4rzJssp2rOV9sIxmXj6OWmuOYbaVfbICWLgd4
BozGsI9gcgle0iptGJqyaxLIdhZyx1oADv9vvBYvxqSxr4nZZr7O/i4v4PvjFCSy
OH2Vm8cc4sC2JyHyDOlwpNpvMr1cYXfM9SSkP5+7vgxlvSWUtaPt0Yj/d04GNMmZ
RtGwy1HlUMZizBmSg7PIzuDuY3OnP1VHzu7R5XKw16RX/m6foczeuCcXues2TQ++
ezHIClJG3SMP5UywrOZ70pZFPMRhYsXk4+lvnxTVRiUOpvYh/cVu0yyUuNuPlyTU
fNA9QOb8E+LbBwIDAQABozowODAXBgNVHREEEDAOggw3OWU1YjVmM2Q3MTkwHQYD
VR0OBBYEFHqBOHuClw8LD/RJymWoh5ccRgruMA0GCSqGSIb3DQEBCwUAA4IBgQAf
w+Elpi86anaqdMCEj0e8ocqBdsrMj3Ht0VhbJg3dy1scUKXoPJ9jjlrIAjQ2Dy2V
hBdeT0m2Is1lpajTiUk2uEOj578cCvgB8kWNlisF+Smgshf00vykAtSNhFiYY7Yl
kfnoHfNLrg06PGnWlk0nc87fnzy5YQrFoxsCMF7fpl9S1FOubD6pZueXbTXSOFeH
dbmjX9NbzN6F66PDiKKYPwoTq1AcCqQ0ji+kP7Yb4xq8LOO5+GqLYBF27HtHYZc0
lh/um74JP5ZMxO/P8ms6Nnk+YMBClLWb4peZuVhpNMgqa1RL7ptdXP82sUtfwg+f
i08osSHyxXvtQnSbUPUuMyJRknaxipdTw5kuU0WDjjmDaNExjhrkaXVLXKIR2T3j
Fwu+xLcilR0EN1StXBvGCITBT1Jx3UUwOcCSwaUM8Zk0Yqp301ZoQ7FvpEpIeh+J
UQnAb1rZ0FjE1iZXrgaiQGPvA5nj3EfIMfyMpAwmFo7edXTkd++eP8BHNooTbHY=',
        ],
    ],
    'validate.authnrequest' => true,
    'validate.logout' => true,
    'sign.logout' => true,
    'redirect.sign' => true,
    'redirect.validate' => true,
];
