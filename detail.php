<?php 
include 'includes/header.php';
include 'includes/navbar.php';



$url = "https://u240066.gluwebsite.nl/api/movie/" . $_GET['id'];

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

$filmData = $movieData['data']; // jouw API geeft hier al films terug

curl_close($ch);
?>

<?php
$movie = $filmData['movie'];
$film = $filmData['cinema'];
?>
<div class="detail-titlebar">
    <h1 class="detail-titlebar-title"><?= htmlspecialchars($movie['title']) ?></h1>
</div>
<div class="movie-detail">
    <div class="detail-flex-row">
        <div class="detail-poster-col">
            <img class="detail-poster" src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($movie['poster_path']) ?>" alt="Poster van <?= htmlspecialchars($movie['title']) ?>">
        </div>
        <div class="detail-info-col info-block detail-info-large">
            <?php if (!empty($movie['vote_average'])): ?>
                <div class="detail-stars">
                    <?php
                    $stars = round($movie['vote_average'] / 2);
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $stars ? '★' : '☆';
                    }
                    ?>
                </div>
            <?php endif; ?>
            <p class="detail-release"><strong>Release:</strong> <?= htmlspecialchars($movie['release_date']) ?></p>
            <p class="detail-description"><?= htmlspecialchars($movie['overview']) ?></p>
            <div class="detail-meta">
                <p><strong>Genre:</strong> <?= htmlspecialchars(implode(', ', array_map(fn($genre) => $genre['name'], $movie['genres']))) ?></p>
                <p><strong>Filmlengte:</strong> <?= htmlspecialchars($movie['runtime']) ?> minuten</p>
                <p><strong>land:</strong> <?= htmlspecialchars(implode(', ', array_map(fn($country) => $country['name'], $movie['production_countries']))) ?></p>
                <p><strong>Imbd-score:</strong> <?= htmlspecialchars($movie['vote_average']) ?></a></p>
                <p><strong>Regisseur:</strong> <?= htmlspecialchars(implode(', ', array_map(fn($director) => $director['name'], $movie['directors']))) ?></p>
                <p><strong>Acteurs:</strong></p>
                <div class="detail-actors-row">
                <?php foreach (array_slice($movie['actors'], 0, 4) as $actor): ?>
                    <div class="detail-actor">
                        <?php if (!empty($actor['profile_path'])): ?>
                            <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($actor['profile_path']) ?>" alt="<?= htmlspecialchars($actor['name']) ?>">
                        <?php endif; ?>
                        <span><?= htmlspecialchars($actor['name']) ?></span>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="detail-ticketbar">
    <a href="tickets.php?id=<?= urlencode($film['movie_screening_id']) ?>" class="detail-ticket-btn">Koop je tickets</a>
</div>
<?php   
    include 'includes/footer.php';
?>