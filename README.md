=======================================================
FILE 1: Save this as 'SmsLibrary.php'
=======================================================
<?php
/**
 * SMS Gateway Integration Library
 * Author: Md Shagor Ali
 * Description: A simple PHP library to send Single and Bulk SMS via API.
 */

// Configuration
define('SMS_API_KEY', 'f197de7991238db4'); // Your API Key
define('SMS_SECRET_KEY', '5c04f07b');      // Your Secret Key
define('SMS_BASE_URL', 'http://118.67.213.114:3775');

/**
 * Send Single SMS
 */
function sendSingleSMS($senderID, $mobileNumber, $message) {
    $url = SMS_BASE_URL . "/sendtext";
    
    $params = [
        'apikey'         => SMS_API_KEY,
        'secretkey'      => SMS_SECRET_KEY,
        'callerID'       => $senderID,
        'toUser'         => $mobileNumber,
        'messageContent' => $message
    ];

    return makeCurlRequest($url, $params);
}

/**
 * Send Bulk SMS
 */
function sendBulkSMS($messagesArray) {
    $url = SMS_BASE_URL . "/send";
    
    // Create JSON Data
    $jsonContent = json_encode($messagesArray);

    $params = [
        'apikey'    => SMS_API_KEY,
        'secretkey' => SMS_SECRET_KEY,
        'content'   => $jsonContent
    ];

    return makeCurlRequest($url, $params);
}

/**
 * Helper Function: cURL Request Handler
 */
function makeCurlRequest($url, $params) {
    $fullUrl = $url . '?' . http_build_query($params);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    
    $response = curl_exec($ch);
    
    if(curl_errno($ch)) {
        return 'Request Error:' . curl_error($ch);
    }
    
    curl_close($ch);
    return $response;
}
?>


=======================================================
FILE 2: Save this as 'index.php'
=======================================================
<?php
// Include the library
require_once 'SmsLibrary.php';

// Configuration
$mySenderID = "YOUR_SENDER_ID"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SMS Sending Status</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .box { background: #f4f4f4; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #ddd; }
        h3 { margin-top: 0; }
        pre { background: #333; color: #fff; padding: 10px; overflow-x: auto; }
    </style>
</head>
<body>

    <h1>SMS Gateway API Test</h1>

    <div class="box">
        <h3>1. Single SMS Test</h3>
        <?php
            // Uncomment to test single SMS
            // $singleResponse = sendSingleSMS($mySenderID, "88017XXXXXXXX", "Hello Shagor, single test.");
            
            if(isset($singleResponse)) {
                echo "<strong>Status:</strong> <pre>" . htmlspecialchars($singleResponse) . "</pre>";
            } else {
                echo "<p>Single SMS disabled. Uncomment code in index.php to send.</p>";
            }
        ?>
    </div>

    <div class="box">
        <h3>2. Bulk SMS Test</h3>
        <?php
            // Prepare Data
            $bulkData = [
                [
                    "callerID" => $mySenderID,
                    "toUser" => "8801773179639", 
                    "messageContent" => "Message for User 1 - Testing Bulk"
                ],
                [
                    "callerID" => $mySenderID,
                    "toUser" => "8801341721136", 
                    "messageContent" => "Message for User 2 - Testing Bulk"
                ]
            ];

            // Send Request
            $bulkResponse = sendBulkSMS($bulkData);
            
            echo "<strong>Status:</strong> <pre>" . htmlspecialchars($bulkResponse) . "</pre>";
        ?>
    </div>

</body>
</html>


=======================================================
FILE 3: Save this as 'README.md'
=======================================================
# PHP SMS Gateway Integration

A lightweight and modular PHP library designed to integrate SMS Gateway APIs easily. This project allows developers to send single and bulk SMS messages using a structured and reusable function-based approach.

## Project Overview

This script simplifies the process of sending SMS via cURL requests. It is designed to be:
- Modular: Core logic is separated from the execution file.
- Secure: Configuration constants are used for API credentials.
- Efficient: Supports both single messages and bulk JSON-based messaging.

## Prerequisites

Before using this library, ensure your server meets the following requirements:
- PHP 7.4 or higher
- cURL extension enabled in php.ini

## File Structure

- SmsLibrary.php: Contains the core configuration and functions.
- index.php: The main execution file where you trigger the SMS sending functions.
- README.md: Documentation for the project.

## Installation and Configuration

1. Download or clone this repository to your project directory.
2. Open the "SmsLibrary.php" file.
3. Update the configuration section with your provided API credentials:

define('SMS_API_KEY', 'YOUR_API_KEY_HERE');
define('SMS_SECRET_KEY', 'YOUR_SECRET_KEY_HERE');
define('SMS_BASE_URL', 'http://118.67.213.114:3775');

## Usage Guide

To use the library, include the SmsLibrary.php file in your project.

### 1. Sending a Single SMS

Use the sendSingleSMS function to send a message to one user.

$response = sendSingleSMS("SENDER_ID", "88017XXXXXXXX", "Message Content");

### 2. Sending Bulk SMS

Use the sendBulkSMS function to send messages to multiple users at once.

$messages = [
    [
        "callerID" => "SENDER_ID",
        "toUser" => "88017XXXXXXXX", 
        "messageContent" => "Message 1"
    ],
    [
        "callerID" => "SENDER_ID",
        "toUser" => "88018XXXXXXXX", 
        "messageContent" => "Message 2"
    ]
];

$response = sendBulkSMS($messages);

## License

This project is open-source and free to use for personal or commercial projects.

Author: Md Shagor Ali
