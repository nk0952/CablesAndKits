<?php
require_once 'settings.php';
try 
{
    $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) 
    {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} 
catch (Exception $e) 
{
    echo "Connection failed: " . $e->getMessage();
}