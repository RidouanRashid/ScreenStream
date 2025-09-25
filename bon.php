<?php
session_start();

include 'includes/header.php';
include 'includes/navbar.php';
?>
<div class="title-container">
    <h1>JOUW BESTELLING</h1>
</div>
<div class="order-container">
    <?php if (isset($_SESSION['selected_seats']) && is_array($_SESSION['selected_seats']) && !empty($_SESSION['selected_seats'])): ?>
        <h2>Geselecteerde Stoelen:</h2>
        <ul>
            <?php foreach ($_SESSION['selected_seats'] as $seat): ?>
                <?php if (isset($seat['row']) && isset($seat['seat'])): ?>
                    <li>
                        Rij: <?php echo htmlspecialchars($seat['row']); ?>, 
                        Stoel: <?php echo htmlspecialchars($seat['seat']); ?>
                        <?php if (isset($seat['isHandicap']) && $seat['isHandicap']): ?>
                            (Rolstoel)
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Geen stoelen geselecteerd.</p>
    <?php endif; ?>
</div>