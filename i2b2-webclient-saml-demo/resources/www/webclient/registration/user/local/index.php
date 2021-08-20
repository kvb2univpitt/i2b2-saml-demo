<?php

session_start();

require_once('../i2b2.php');

date_default_timezone_set('America/New_York');

$postData = file_get_contents("php://input");
if (!empty($postData)) {
    $hostname = trim(filter_input(INPUT_POST, 'hostName', FILTER_SANITIZE_STRING));
    $firstName = trim(filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING));
    $lastName = trim(filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

    $full_name = "$firstName $lastName";

    $user_exists = userExists($username, getUser($username));
    if ($user_exists) {
        $_SESSION['error_msg'] = "You have already registered.";
    } else {
        $result_status_error = hasErrorStatus(setUser($username, $full_name, $email, 'A', $password));
        if ($result_status_error) {
            $_SESSION['error_msg'] = "Sorry.  We are unable to sign you up at this time.  Please contact the admin.";
        } else {
            $param_value = strtoupper(trim(getAuthenticationMethod($hostname)));
            if (!empty($param_value)) {
                $param_type = 'T';
                $param_status = 'A';
                $param_name = 'authentication_method';

                setUserParam($username, $param_type, $param_status, $param_name, $param_value);
            }

            $_SESSION['success_msg'] = "Thank you for signing up!  We will contact you after your registration has been reviewed.";
        }
    }
}

$hostname = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING);
$url = "https://${hostname}/webclient/";
header("Location: ${url}");
