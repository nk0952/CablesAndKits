<?php
require_once 'config/settings.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $recipient_key = $_POST["recipient_key"];
        $user = readMessage($recipient_key);
        if( !empty( $user ) ) {
            $message = $user['message'];
            $recipient = $user['recipient'];

            $decryptedMessage = decryptMessage($message, $recipient_key);
            echo "Your details related to $recipient_key are as follows: <br/>Message: <strong>$decryptedMessage</strong><br/>Email ID: <strong>$recipient</strong>";
        } else {
            echo "I have tried really hard to find, but I failed. :(";
        }
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}


function readMessage($key) {
    $userData = [];
    if( empty( $key ) ) {
        echo 'Please enter secret key to read message.';
        return false;
    }
    else {
        $created = date('Y-m-d H:i:s');
        try {
            require_once('config/db.php');
            $sql = "SELECT recipient, message FROM messages WHERE message_key = ?;";
            $stmt = $conn->prepare($sql); 
            if (!$stmt) {
                throw new Exception("Error in prepare statement: " . $conn->error);
            }

            $stmt->bind_param("s", $key);
            
            if (!$stmt->execute()) {
                throw new Exception("Error in execute statement: " . $stmt->error);
            }

            $result = $stmt->get_result(); 
            $user = $result->fetch_assoc(); 

            if( !empty( $user ) ) {
                $userData = $user;
            }
            $stmt->close();
            $conn->close();
        } catch(Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    return $userData;
}


function decryptMessage($encryptedMessage, $key) {
    $ciphertext = base64_decode( $encryptedMessage );
    
    $ivLength = openssl_cipher_iv_length( OPEN_SSL_KEY );
    
    $iv = substr( $ciphertext, 0, $ivLength );
    
    $encryptedText = substr($ciphertext, $ivLength);
    
    $decrypted = openssl_decrypt($encryptedText, OPEN_SSL_KEY, $key, 0, $iv);
    
    return $decrypted;
}

