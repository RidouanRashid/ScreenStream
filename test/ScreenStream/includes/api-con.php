<?php
$url = "https://u240066.gluwebsite.nl/api/movies";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-API-KEY: nWF4eXPsUzVkBA8PvhzsW9jmh4niQGs9jZZMeC6F",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    exit("Er is een fout opgetreden met de api.");
}

$movieData = json_decode($response, true);

if ($movieData['status'] !== 'success') {
    exit("Er is een fout opgetreden met de api.");
}

$films = $movieData['data']; // jouw API geeft hier al films terug

curl_close($ch);
?>