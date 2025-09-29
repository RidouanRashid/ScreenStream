<?php
session_start();

// Controleer of er ticketgegevens zijn in de sessie
if (!isset($_SESSION['tickets']) || !isset($_SESSION['gekozen_film_id'])) {
    exit("Geen ticketgegevens gevonden. Ga terug naar <a href='ticket.php'>Tickets</a>.");
}

// ---------------------
// 1. Filmdata via API
// ---------------------
$filmId = $_SESSION['gekozen_film_id'];
$url    = "https://u240066.gluwebsite.nl/api/movie/" . urlencode($filmId);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-API-KEY: nWF4eXPsUzVkBA8PvhzsW9jmh4niQGs9jZZMeC6F",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    exit("Er is een fout opgetreden met de API.");
}
curl_close($ch);

$movieData = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE || empty($movieData['data'])) {
    exit("Geen geldige filmgegevens ontvangen van de API.");
}

// De API retourneert 1 filmobject in 'data'
$filmdata = $movieData['data'];
$filmTitle = $filmdata['title'] ?? $filmdata['name'] ?? 'Onbekende film';
$basePrice = $filmdata['price'] ?? ($_SESSION['tickets']['prijs'] ?? 0);

// ---------------------
// 2. Sessie- en POST-gegevens
// ---------------------
$tickets = $_SESSION['tickets'];
$stoelen = $_SESSION['selected_seats'] ?? [];
$klant = [
    'voornaam'  => $_POST['firstname'] ?? 'Onbekend',
    'achternaam'=> $_POST['surname']   ?? 'Onbekend',
    'email'     => $_POST['email']     ?? 'Onbekend'
];
$betaalwijze = $_POST['payment'] ?? 'Onbekend';

// Bereken totaalprijs op basis van actuele API-prijs
$totalTickets = (int)$tickets['normaal'] + (int)$tickets['kind'] + (int)$tickets['senior'];
$totalPrijs   = $basePrice * $totalTickets;
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title>Bon</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="ticket-container">
    <h1>Uw Bon</h1>

    <h2>Film: <?= htmlspecialchars($filmTitle) ?></h2>
    <ul>
        <li>Normaal: <?= (int)$tickets['normaal'] ?></li>
        <li>Kind: <?= (int)$tickets['kind'] ?></li>
        <li>Senior: <?= (int)$tickets['senior'] ?></li>
        <li><strong>Totaal: €<?= number_format($totalPrijs, 2, ',', '.') ?></strong></li>
    </ul>

    <h2>Stoelen</h2>
    <?php if ($stoelen): ?>
        <ul>
            <?php foreach ($stoelen as $s): ?>
                <li>Rij <?= htmlspecialchars($s['row']) ?> - Stoel <?= htmlspecialchars($s['seat']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Geen stoelen geselecteerd.</p>
    <?php endif; ?>

    <h2>Klant</h2>
    <p><?= htmlspecialchars($klant['voornaam'].' '.$klant['achternaam']) ?><br>
       <?= htmlspecialchars($klant['email']) ?></p>

    <h2>Betaalwijze</h2>
    <p><?= htmlspecialchars($betaalwijze) ?></p>
</div>
</body>
</html>
