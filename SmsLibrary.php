<?php
/**
 * SMS Gateway Integration Library
 * Author: Md Shagor Ali
 * Description: A simple PHP library to send Single and Bulk SMS via API.
 */

// ==========================================
// ১. কনফিগারেশন (Configuration)
// ==========================================
// আপনার API ক্রেডেনশিয়াল এখানে সেট করুন
define('SMS_API_KEY', ''); // আপনার API Key
define('SMS_SECRET_KEY', '');      // আপনার Secret Key
define('SMS_BASE_URL', 'http://118.67.213.114:3775');

/**
 * Send Single SMS
 *
 * @param string $senderID - The Sender ID/Caller ID
 * @param string $mobileNumber - Receiver's Mobile Number (e.g., 88017XXXXXXXX)
 * @param string $message - The message content
 * @return string - API Response
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
 *
 * @param array $messagesArray - Array of messages containing callerID, toUser, messageContent
 * @return string - API Response
 */
function sendBulkSMS($messagesArray) {
    $url = SMS_BASE_URL . "/send";
    
    // JSON Data তৈরি
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
 * * @param string $url - Target URL
 * @param array $params - Query Parameters
 * @return string - Response from API
 */
function makeCurlRequest($url, $params) {
    $fullUrl = $url . '?' . http_build_query($params);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20); // টাইমআউট সেট করা হলো
    
    $response = curl_exec($ch);
    
    // Error Handling
    if(curl_errno($ch)) {
        return 'Request Error:' . curl_error($ch);
    }
    
    curl_close($ch);
    return $response;
}
?>