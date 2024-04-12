<?php
require_once 'config/settings.php';
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $text = $_POST["messageText"];
        $recipient = $_POST["recipient"];
        
        $uniqueKey = bin2hex(random_bytes(8));
        
        $encryptedMessage = encryptMessage($text, $uniqueKey);
        
        saveMessage($encryptedMessage, $uniqueKey, $recipient);

        sendMail( $recipient, $uniqueKey );
        
        echo 'Message created successfully! Here is the key to read the message. Please click the following link to copy and save it somewhere safe: <a href="javascript:copyToClipboard(\'' . $uniqueKey . '\')">' . $uniqueKey . '</a>';
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function encryptMessage($text, $uniqueKey) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc') );

    $encrypted = openssl_encrypt($text, OPEN_SSL_KEY, $uniqueKey, 0, $iv);

    $ciphertext = base64_encode($iv . $encrypted);

    return $ciphertext;
}

function saveMessage($encryptedMessage, $key, $recipient) {
    
    if( empty( $encryptedMessage ) ) {
        echo 'Please enter secret message.';
        return false;
    }
    else if( empty( $recipient ) ) {
        echo 'Please enter recipient.';
        return false;
    }
    else {
        $created = date('Y-m-d H:i:s');
        try {
            require_once('config/db.php');
            $sql = "INSERT INTO messages (recipient, message, message_key, created, modified) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error in prepare statement: " . $conn->error);
            }
            $stmt->bind_param("sssss", $recipient, $encryptedMessage, $key, $created, $created);
            if (!$stmt->execute()) {
                throw new Exception("Error in execute statement: " . $stmt->error);
            }

            $stmt->close();
            $conn->close();
        } catch(Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
}


function sendMail( $recipient, $uniqueKey ) {
    $subject = "Secret Message ";
    $message = "Hey $recipient! <br/>You have received a secret message.<br/>";
    $message .= "To read the message, use the following key: " . $uniqueKey;
    
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port = SMTP_PORT; 

        //Recipients
        $mail->setFrom(SMTP_FROMEMAIL, SMTP_FROM);
        $mail->addAddress($recipient, $recipient);     // Add a recipient

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

}