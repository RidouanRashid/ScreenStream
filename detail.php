<?php 
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/api-con.php';
?>

<?php

$filmsAssoc = [];
foreach ($films as $film) {
    $filmsAssoc[$film['id']] = $film;
}
$films = $filmsAssoc;


if (isset($_GET['id']) && isset($films[$_GET['id']])) {
    $film = $films[$_GET['id']];
    $movie = $film['movie'];
    ?>
    <div class="movie-detail">
        <h1 class='title'><?= htmlspecialchars($movie['title']) ?></h1>
        <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($movie['poster_path']) ?>" alt="Poster van <?= htmlspecialchars($movie['title']) ?>" style="max-width:663px;margin-right:24px;">
        <p><strong>Release:</strong> <?= htmlspecialchars($movie['release_date']) ?></p>
        <p><strong>Duur:</strong> <?= htmlspecialchars($movie['runtime']) ?> minuten</p>
        <p><strong>Beschrijving:</strong> <?= htmlspecialchars($movie['overview']) ?></p>
        <p><strong>Taal:</strong> <?= htmlspecialchars($film['spoken_language']) ?> | <strong>Ondertiteling:</strong> <?= htmlspecialchars($film['subtitle_language']) ?></p>
    
        <a href="tickets.php?id=<?= urlencode($film['id']) ?>" class="ticket-btn">Tickets bestellen</a>
    </div>
    <?php
} else {
    echo '<p>Film niet gevonden!</p>';
}
?>
<?php   
    include 'includes/footer.php';
?>