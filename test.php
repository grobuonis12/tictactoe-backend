<?php
$connection = mysqli_connect(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'), env('DB_PORT'));

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";
