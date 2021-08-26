<?php

session_start();

require_once('../i2b2.php');

date_default_timezone_set('America/New_York');

$username = filter_input(INPUT_SERVER, 'AJP_eduPersonPrincipalName', FILTER_SANITIZE_STRING);
if ($username) {
    $username = strtolower(trim($username));
    $first_name = filter_input(INPUT_SERVER, 'AJP_givenName', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_SERVER, 'AJP_sn', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_SERVER, 'AJP_mail', FILTER_SANITIZE_STRING);

    // create full name from first and last name
    $full_name = trim($first_name . ' ' . $last_name);

    // set full name to username if first name and last name don't exists
    if (strlen($full_name) == 0) {
        $full_name = $username;
    }

    $user_exists = userExists($username, getUser($username));
    if ($user_exists) {
        $_SESSION['error_msg'] = "You have already registered.";
    } else {
        $result_status_error = hasErrorStatus(setUser($username, $full_name, $email));
        if ($result_status_error) {
            $_SESSION['error_msg'] = "Sorry.  We are unable to sign you up at this time.  Please contact the admin.";
        } else {
            setUserAuthenticationToSAML($username);

            $_SESSION['success_msg'] = "Thank you for signing up!  We will contact you after your registration has been reviewed.";
        }
    }

    $hostname = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING);
    $url = "https://${hostname}/webclient/logout.php";
    header("Location: ${url}");
} else {
    $hostname = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING);
    $shib_handler = filter_input(INPUT_SERVER, 'AJP_Shib-Handler', FILTER_SANITIZE_STRING);
    $url = "${shib_handler}/Login?target=https://${hostname}/webclient/registration/user/federated";
    header("Location: ${url}");
}
