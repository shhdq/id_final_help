<?php
$servername = "localhost";
$usr = "root";
$pass = "";
$dbname = "id_help_final";

// Create connection
$db = new mysqli($servername, $usr, $pass, $dbname);
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
