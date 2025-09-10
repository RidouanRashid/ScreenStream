<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2 class="agenda-title">Bioscoop Overzicht</h2>
    <div class="film-grid">
        <?php
        // Dummy data, vervang dit morgen door data uit de API
        $films = [
            [
                'titel' => 'Inception',
                'beschrijving' => 'Een dief die dromen steelt krijgt een laatste kans op verlossing.',
                'tijd' => '19:30',
                'afbeelding' => 'https://m.media-amazon.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_FMjpg_UX1000_.jpg',
            ],
            [
                'titel' => 'The Lion King',
                'beschrijving' => 'Het verhaal van Simba, de leeuwenkoning.',
                'tijd' => '17:00',
                'afbeelding' => 'https://play-lh.googleusercontent.com/E4YJiRnNiYlM-PbjVrE2Zdr2d73SWbBTzarMIurgNNdr6c_Bh9IX05-ba6vdNR822EyG',
            ],
            [
                'titel' => 'Avengers: Endgame',
                'beschrijving' => 'De Avengers nemen het op tegen Thanos in een episch slotstuk.',
                'tijd' => '21:00',
                'afbeelding' => 'https://m.media-amazon.com/images/I/81ExhpBEbHL._AC_SY679_.jpg',
            ],
        ];
        ?>
        <?php foreach ($films as $film): ?>
            <div class="film-card">
                <img src="<?= htmlspecialchars($film['afbeelding']) ?>" alt="Poster van <?= htmlspecialchars($film['titel']) ?>">
                <div class="film-info">
                    <h3><?= htmlspecialchars($film['titel']) ?></h3>
                    <p><?= htmlspecialchars($film['beschrijving']) ?></p>
                    <p><strong>Tijd:</strong> <?= htmlspecialchars($film['tijd']) ?></p>
                    <a href="#" class="btn">Tickets</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>