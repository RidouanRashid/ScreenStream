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


<?php
$needed = 12;
$count = count($films);

$displayFilms = [];
if($count > 0){
    for ($i = 0; $i < $needed; $i++) {
        $displayFilms[] = $films[$i % $count];
    }
}
?>

    <div class="film-grid">
        <?php foreach ($displayFilms as $film): ?>
            <div class="film-card">
                <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($film['movie']['poster_path']) ?>" alt="Poster van <?= htmlspecialchars($film['movie']['title']) ?>">
                <div class="film-info">
                    <h3><?= htmlspecialchars($film['movie']['title']) ?></h3>
                    <div class="stars">
                        <?php 
                        $rating = isset($film['movie']['vote_average']) ? round($film['movie']['vote_average'] / 2) : 0;
                        for ($i = 0; $i < 5; $i++) {
                            echo $i < $rating ? '★' : '☆';
                        }
                        ?>
                    </div>
                    <p><strong>Release:</strong> <?= isset($film['movie']['release_date']) ? htmlspecialchars(date('d-m-Y', strtotime($film['movie']['release_date']))) : '-' ?></p>
                    <p><?= htmlspecialchars($film['movie']['overview']) ?></p>
                    <div class="tijd-en-tickets">
                        <span><strong>Tijd:</strong> <?= htmlspecialchars($film['movie']['runtime']) ?> minuten</span>
                        <a href="#" class="btn">Meer info & Tickets</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
