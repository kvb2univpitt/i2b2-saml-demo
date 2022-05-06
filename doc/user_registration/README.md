# i2b2 User Registration Guide

A guide on how to do the following:

- enable/disable user self-registration in i2b2 webclient
- self-register new user
- assign project and roles to new user

Whenever a new user is added (registered) into the system, no project is assigned to the user.  Therefore, the new user cannot sign into the i2b2 application immediately after self registering.  The administrator has to the following first before the new user can sign in:

1. add the new user to a project
2. add the project roles to the new user

## Enabling or Disabling User Self-Registration

The i2b2 webclient has two ways to self-register, local self-registration and federation self-registration.

### Enabling Local User Self-Registration

Modify the file ***i2b2_config_data.json*** located in the directory **/var/www/html/webclient/**.  Set the value of the attribute **showRegistration** to ***true*** and set the value of the attribute **registrationMethod** empty.

For an example:

```json
{
    "domain": "i2b2demo",
    "name": "HarvardDemo",
    "allowAnalysis": true,
    "urlCellPM": "http:\/\/127.0.0.1\/i2b2\/services\/PMService\/",
    "registrationMethod": "",
    "loginType": "local",
    "showRegistration": true,
    "debug": true
}
```

Refresh the webpage and you should see the option to register user (circled in red):

![local login](local_login.png)

### Enabling Federation User Self-Registration

Modify the file ***i2b2_config_data.json*** located in the directory **/var/www/html/webclient/**.  Set the value of the attribute **showRegistration** to ***true*** and set the value of the attribute **registrationMethod** to ***saml**.

For an example:

```json
{
    "domain": "i2b2demo",
    "name": "HarvardDemo",
    "allowAnalysis": true,
    "urlCellPM": "http:\/\/127.0.0.1\/i2b2\/services\/PMService\/",
    "registrationMethod": "saml",
    "loginType": "local",
    "showRegistration": true,
    "debug": true
}
```

Refresh the webpage and you should see the option to register user (circled in red):

![federated login](federated_login.png)

### Disabling User Self-Registration

To disable user self-registration for either local registration or federation registration, set the value of the attribute **showRegistration** to ***true*** in the file file ***i2b2_config_data.json*** located in the directory **/var/www/html/webclient/**.

##  Self-Registering New User

###  Local Self-Registering New User

Click on the "***Sign Up!***" link on the bottom of the **i2b2 Login** dialog.  A "**Sign Up**" modal will pop up containing a form for self-registering.  Fill out the user information on the left of the form.  Carefully read the terms-and-conditions, click on the checkbox "***I accept the Terms & Conditions***", and click on the button "***Sign Up***" to register on the right side of the form.

For an example:

![local registration](local_signup.png)

Once registered, the sign-up modal will disappeared and a confirmation alert will pop up at the main (login) page:

![registration confirmation](registration_confirm.png)

> Note that the new user cannot sign in immediately after self-registering.  An administrator has to add the new user to a project and add the project roles to the new user.

###  Federation Self-Registering New User

Click on the "***Sign Up!***" link on the bottom of the **i2b2 Login** dialog.  A "**Sign Up**" modal will pop up containing a button to redirect you to your Identity Provider (IdP) for logging in:

![federation registration](federation_signup.png)

Click the button to redirect to your IdP and sign in to your IdP:

For an example:

![IdP sign in](idp_login.png)

Once you are logged in, you will be redirected back to the i2b2 user registration page containing the terms-and-conditions.  Carefully read the terms-and-conditions, click on the checkbox "***I accept the Terms & Conditions***", and click on the button "***Sign Up***" to register.

![federation terms and conditions](federation_terms.png)

Once registered, the page will redirected back to the main (login) page with a confirmation alert:

![registration confirmation](registration_confirm.png)
