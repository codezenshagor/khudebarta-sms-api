<?php
require_once 'KhudebartaSMS.php';

// Khudebarta API Configuration
$apiKey = "YOUR_KHUDEBARTA_API_KEY"; 
$secretKey = "YOUR_KHUDEBARTA_SECRET_KEY";

// Initialize the Khudebarta Object
$sms = new KhudebartaSMS($apiKey, $secretKey);

echo "<h1>Khudebarta SMS API Test</h1>";

// 1. Send Single SMS
echo "<h3>Sending Single SMS...</h3>";
$response = $sms->sendSingle("8801847XXXXXX", "017XXXXXXXX", "Test SMS from Khudebarta API");
echo "<pre>" . $response . "</pre>";

// 2. Send Bulk SMS
echo "<h3>Sending Bulk SMS...</h3>";
$bulkMessages = [
    ["callerID" => "8801847XXXXXX", "toUser" => "017XXXXXXXX", "messageContent" => "Bulk MSG 1"],
    ["callerID" => "8801847XXXXXX", "toUser" => "019XXXXXXXX", "messageContent" => "Bulk MSG 2"]
];
$responseBulk = $sms->sendBulk($bulkMessages);
echo "<pre>" . $responseBulk . "</pre>";

?>