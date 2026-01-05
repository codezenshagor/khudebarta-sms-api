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
