<?php
// লাইব্রেরি ফাইলটি সংযুক্ত করা হলো
require_once 'SmsLibrary.php';

// ==========================================
// ব্যবহার করার নিয়ম (Usage Examples)
// ==========================================

// আপনার Sender ID এখানে সেট করুন
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
            // টেস্টিং এর জন্য নিচে কমেন্ট আউট তুলে দিন
             $singleResponse = sendSingleSMS($mySenderID, "8801773179639", "Hello Shagor, this is a single test message.");
            
            // রেসপন্স দেখানো
            if(isset($singleResponse)) {
                echo "<strong>Status:</strong> <pre>" . htmlspecialchars($singleResponse) . "</pre>";
            } else {
                echo "<p>Single SMS disabled. Uncomment code to send.</p>";
            }
        ?>
    </div>

    <div class="box">
        <h3>2. Bulk SMS Test</h3>
        <?php
            // ডেটা সাজানো
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

            // ফাংশন কল করা
            $bulkResponse = sendBulkSMS($bulkData);
            
            // রেসপন্স দেখানো
            echo "<strong>Status:</strong> <pre>" . htmlspecialchars($bulkResponse) . "</pre>";
        ?>
    </div>

</body>
</html>