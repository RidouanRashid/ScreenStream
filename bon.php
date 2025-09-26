<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['last_ticket_id'])) {
    exit("Geen ticket gevonden. Ga terug naar <a href='ticket.php'>Tickets</a>.");
}

$ticketId = (int)$_SESSION['last_ticket_id'];

// --- Haal ticket + klant + film + betaalwijze ---
$sql = "SELECT t.*, g.voornaam, g.achternaam, g.email, b.methode AS betaalmethode, f.titel
        FROM tickets t
        JOIN gegevens g   ON t.klant_id = g.id
        JOIN betaalwijze b ON t.betaal_id = b.id
        JOIN film f       ON t.film_id = f.id
        WHERE t.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$ticketId]);
$data = $stmt->fetch();

// --- Haal stoelen ---
$stoelenStmt = $pdo->prepare("SELECT rij_nr, stoel_nr FROM stoel WHERE ticket_id = ?");
$stoelenStmt->execute([$ticketId]);
$stoelen = $stoelenStmt->fetchAll();
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
    <h2>Film: <?= htmlspecialchars($data['titel']) ?></h2>
    <ul>
        <li>Normaal: <?= (int)$data['normaal'] ?></li>
        <li>Kind: <?= (int)$data['kind'] ?></li>
        <li>Senior: <?= (int)$data['senior'] ?></li>
        <li><strong>Totaal: €<?= number_format($data['totaal'], 2, ',', '.') ?></strong></li>
    </ul>

    <h2>Stoelen</h2>
    <?php if ($stoelen): ?>
        <ul>
        <?php foreach ($stoelen as $s): ?>
            <li>Rij <?= htmlspecialchars($s['rij_nr']) ?> – Stoel <?= htmlspecialchars($s['stoel_nr']) ?></li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Geen stoelen geselecteerd.</p>
    <?php endif; ?>

    <h2>Klant</h2>
    <p><?= htmlspecialchars($data['voornaam'].' '.$data['achternaam']) ?><br>
       <?= htmlspecialchars($data['email']) ?></p>

    <h2>Betaalwijze</h2>
    <p><?= htmlspecialchars($data['betaalmethode']) ?></p>
</div>
</body>
</html>
