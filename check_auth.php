<?php
session_start();
header('Content-Type: text/plain');

echo "Session ID: " . session_id() . "\n";
echo "Session data:\n";
print_r($_SESSION);
?> 