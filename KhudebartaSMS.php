<?php

/**
 * Khudebarta SMS Gateway API Integration Library
 * * A simple PHP class to send Single and Bulk SMS using the Khudebarta Portal API.
 * This script handles API authentication and response parsing for Khudebarta.
 * * @package KhudebartaSMS
 * @author Md Shagor Ali
 * @link https://portal.khudebarta.com
 * @version 1.0.0
 */
class KhudebartaSMS {
    private $apiKey;
    private $secretKey;
    // Khudebarta API Base URL
    private $baseUrl = "http://118.67.213.114:3775";

    /**
     * Initialize Khudebarta SMS Gateway
     * * @param string $apiKey    Your Khudebarta API Key
     * @param string $secretKey Your Khudebarta Secret Key
     */
    public function __construct($apiKey, $secretKey) {
        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
    }

    /**
     * Send Single SMS via Khudebarta
     * * @param string $callerID Sender ID provided by Khudebarta
     * @param string $toUser   Receiver mobile number
     * @param string $message  Text message content
     * @return string JSON response from API
     */
    public function sendSingle($callerID, $toUser, $message) {
        $endpoint = "/sendtext";
        
        $params = [
            'apikey' => $this->apiKey,
            'secretkey' => $this->secretKey,
            'callerID' => $callerID,
            'toUser' => $toUser,
            'messageContent' => $message
        ];

        return $this->makeRequest($endpoint, $params, false);
    }

    /**
     * Send Bulk SMS (JSON) via Khudebarta
     * * @param array $smsData Array structure: [['callerID'=>'..', 'toUser'=>'..', 'messageContent'=>'..']]
     * @return string JSON response from API
     */
    public function sendBulk($smsData) {
        $endpoint = "/send";
        $jsonContent = json_encode($smsData);

        $params = [
            'apikey' => $this->apiKey,
            'secretkey' => $this->secretKey,
            'content' => $jsonContent
        ];

        // Using POST for Bulk/JSON content
        return $this->makeRequest($endpoint, $params, true);
    }

    /**
     * Check SMS Delivery Status on Khudebarta
     * * @param string $messageId The ID received after sending SMS
     * @return string JSON response
     */
    public function checkStatus($messageId) {
        $endpoint = "/getstatus";
        $params = [
            'apikey' => $this->apiKey,
            'secretkey' => $this->secretKey,
            'messageid' => $messageId
        ];
        return $this->makeRequest($endpoint, $params, false);
    }

    /**
     * Internal cURL Request Handler
     */
    private function makeRequest($endpoint, $params, $isPost = false) {
        $url = $this->baseUrl . $endpoint;
        $ch = curl_init();
        
        if ($isPost) {
            $authQuery = http_build_query([
                'apikey' => $this->apiKey, 
                'secretkey' => $this->secretKey
            ]);
            curl_setopt($ch, CURLOPT_URL, $url . "?" . $authQuery);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['content' => $params['content']]));
        } else {
            $query = http_build_query($params);
            curl_setopt($ch, CURLOPT_URL, $url . "?" . $query);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return json_encode(['Status' => 'Error', 'Text' => $error]);
        }
        return $response;
    }
}
?>