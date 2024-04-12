Secret Message Task Application

The Secret Message Task Application is a web-based application that allows users to send secret messages securely using PHPMailer for email delivery and OpenSSL for encryption and decryption.
Prerequisites

Before running the application, ensure that the following software is installed on your system:

    Apache HTTP Server
    PHP
    MySQL

Installation

    Clone the repository to your local machine:

    bash

git clone <repository_url>

Navigate to the project directory:

bash

    cd secret-message-task

    Ensure that the Apache server is configured to serve the project directory.

    Start the Apache server and navigate to http://localhost/secret-message-task in your web browser.

Configuration

All configuration settings for the Secret Message Task Application are managed in the config/settings.php file. Before running the application, make sure to update this file with the appropriate settings for your environment. Here's an example of what the settings.php file may look like:

php

<?php

// Database settings
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'your_db_username');
define('DB_PASSWORD', 'your_db_password');
define('DB_NAME', 'secret_message_task');

// PHPMailer settings
define('SMTP_HOST', 'smtp.example.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your_smtp_username');
define('SMTP_PASSWORD', 'your_smtp_password');
define('SMTP_ENCRYPTION', 'tls');

// OpenSSL cipher key
define('OPENSSL_CIPHER_KEY', 'your_open_ssl_cipher_key');

Ensure that you have already created the settings.php file with the necessary settings before running the application.
Usage

    Sending a Secret Message:
        Navigate to the application in your web browser.
        Enter the recipient's email address and the message you want to send.
        Click the "Send Message" button.

    Reading a Secret Message:
        The recipient will receive an email containing a link to the secret message.
        Click the link in the email to access the secret message.
        Enter the passphrase provided by the sender to decrypt and view the message.

Contributing

Contributions are welcome! If you have any suggestions, feature requests, or bug reports, please open an issue or submit a pull request.
License

This project is licensed under the MIT License.