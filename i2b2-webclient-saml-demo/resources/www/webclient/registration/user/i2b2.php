<?php

require_once('config.php');

function getRequestTemplate() {
    return <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<i2b2:request xmlns:i2b2="http://www.i2b2.org/xsd/hive/msg/1.1/" xmlns:pm="http://www.i2b2.org/xsd/cell/pm/1.1/">
    <message_header>
        <proxy>
            <redirect_url>I2B2_PM_URI</redirect_url>
        </proxy>
        <i2b2_version_compatible>1.1</i2b2_version_compatible>
        <hl7_version_compatible>2.4</hl7_version_compatible>
        <sending_application>
            <application_name>i2b2 Project Management</application_name>
            <application_version>1.1</application_version>
        </sending_application>
        <sending_facility>
            <facility_name>i2b2 Hive</facility_name>
        </sending_facility>
        <receiving_application>
            <application_name>Project Management Cell</application_name>
            <application_version>1.1</application_version>
        </receiving_application>
        <receiving_facility>
            <facility_name>i2b2 Hive</facility_name>
        </receiving_facility>
        <datetime_of_message>2007-04-09T15:19:18.906-04:00</datetime_of_message>
        <security>
            <domain>I2B2_DOMAIN</domain>
            <username>I2B2_SERVICE_ACCOUNT_ID</username>
            <password>I2B2_SERVICE_ACCOUNT_PW</password>
        </security>
        <message_control_id>
            <message_num>2pNloq58C28eP511z8nkB</message_num>
            <instance_num>0</instance_num>
        </message_control_id>
        <processing_id>
            <processing_id>P</processing_id>
            <processing_mode>I</processing_mode>
        </processing_id>
        <accept_acknowledgement_type>AL</accept_acknowledgement_type>
        <application_acknowledgement_type>AL</application_acknowledgement_type>
        <country_code>US</country_code>
        <project_id>I2B2_PROJECT</project_id>
    </message_header>
    <request_header>
        <result_waittime_ms>180000</result_waittime_ms>
    </request_header>
    <message_body>
        I2B2_XML_REQUEST_MESSAGE
    </message_body>
</i2b2:request>
XML;
}

function getRequestXML($request_body) {
    global $config_pm_uri, $config_domain, $config_service_account_id, $config_service_account_pw, $config_project_id;

    $xml = getRequestTemplate();
    $xml = str_replace("I2B2_PM_URI", $config_pm_uri, $xml);
    $xml = str_replace("I2B2_DOMAIN", $config_domain, $xml);
    $xml = str_replace("I2B2_SERVICE_ACCOUNT_ID", $config_service_account_id, $xml);
    $xml = str_replace("I2B2_SERVICE_ACCOUNT_PW", $config_service_account_pw, $xml);
    $xml = str_replace("I2B2_PROJECT", $config_project_id, $xml);
    $xml = str_replace("I2B2_XML_REQUEST_MESSAGE", $request_body, $xml);

    return $xml;
}

function getAllUserParams() {
    global $config_pm_uri;

    $request_body = '<pm:get_all_user_param></pm:get_all_user_param>';
    $request_xml = getRequestXML($request_body);

    $ch = curl_init($config_pm_uri);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_xml);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);

    return $data;
}

function setUser($username, $full_name, $email, $status = 'A', $password = 'demouser') {
    global $config_pm_uri;

    $request_body = <<<XML
<pm:set_user>
            <user_name>I2B2_USER_NAME</user_name>
            <full_name>I2B2_FULL_NAME</full_name>
            <email>I2B2_EMAIL</email>
            <status_cd>I2B2_STATUS_CD</status_cd>
            <password>I2B2_PASSWORD</password>
        </pm:set_user>
XML;

    $request_body = str_replace("I2B2_USER_NAME", $username, $request_body);
    $request_body = str_replace("I2B2_FULL_NAME", $full_name, $request_body);
    $request_body = str_replace("I2B2_EMAIL", $email, $request_body);
    $request_body = str_replace("I2B2_STATUS_CD", $status, $request_body);
    $request_body = str_replace("I2B2_PASSWORD", $password, $request_body);

    $request_xml = getRequestXML($request_body);

    $ch = curl_init($config_pm_uri);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_xml);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);

    return $data;
}

function setUserParam($username, $param_type, $param_status, $param_name, $param_value) {
    global $config_pm_uri;

    $request_body = <<<XML
<pm:set_user_param>
            <user_name>I2B2_USER_NAME</user_name>
            <param name="I2B2_PARAM_NAME" datatype="I2B2_PARAM_TYPE" status="I2B2_STATUS">I2B2_PARAM_VALUE</param>
        </pm:set_user_param>
XML;

    $request_body = str_replace("I2B2_USER_NAME", $username, $request_body);
    $request_body = str_replace("I2B2_PARAM_TYPE", $param_type, $request_body);
    $request_body = str_replace("I2B2_STATUS", $param_status, $request_body);
    $request_body = str_replace("I2B2_PARAM_NAME", $param_name, $request_body);
    $request_body = str_replace("I2B2_PARAM_VALUE", $param_value, $request_body);

    $request_xml = getRequestXML($request_body);

    $ch = curl_init($config_pm_uri);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$request_xml");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);

    return $data;
}

function getUser($username) {
    global $config_pm_uri;

    $request_body = "<pm:get_user>$username</pm:get_user>";

    $request_xml = getRequestXML($request_body);

    $ch = curl_init($config_pm_uri);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$request_xml");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);

    return $data;
}

function paramUserExists($username, $xml_response) {
    return preg_match('/<param name="eppn" (.*)>' . $username . '<\/param>/', $xml_response);
}

function userExists($username, $xml_response) {
    return preg_match("/<user_name>${username}<\/user_name>/", $xml_response);
}

function hasErrorStatus($xml_response) {
    return preg_match("/<status type=\"ERROR\">/i", $xml_response);
}
