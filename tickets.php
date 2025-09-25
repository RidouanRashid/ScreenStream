<?php
session_start();

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

$filmdata = $movieData['data']; // jouw API geeft hier al films terug


curl_close($ch);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="functions/script.js" defer></script>
    <title>ScreenStream - Tickets</title>
</head>

<body>
    <?php
    include 'includes/header.php';

    // Helper function to safely get movie information
    function getMovieInfo($movie, $key)
    {
        $possibleKeys = [
            'title' => ['title', 'name', 'movie_name'],
            'id' => ['id', 'movie_id'],
            'price' => ['price', 'ticket_price', 'base_price'],
            'poster' => ['poster', 'poster_url', 'image'],
            'theater' => ['theater', 'room', 'zaal'],
        ];

        if (!isset($possibleKeys[$key])) {
            return null;
        }

        foreach ($possibleKeys[$key] as $possibleKey) {
            if (isset($movie[$possibleKey])) {
                return $movie[$possibleKey];
            }
        }

        return null;
    }

    ?>

    <?php
    $selectedId = isset($_GET['id']) ? $_GET['id'] : '';

    // Debug: Check API response structure
    // echo '<pre>'; print_r($films); echo '</pre>';
    ?>
    <div class="title-container">
        <h1>TICKETS BESTELLEN</h1>
        <?php if ($selectedId && isset($filmdata) && is_array($filmdata)): ?>
            <?php
            $selectedMovie = null;
            foreach ($filmdata as $film) {
                if (isset($film['id']) && $film['id'] == $selectedId) {
                    $selectedMovie = $film;
                    break;
                }
            }
            if ($selectedMovie):
            ?>
                <h2 class="selected-movie">
                    <?php
                    $movieTitle = '';
                    if (isset($selectedMovie['name'])) {
                        $movieTitle = $selectedMovie['name'];
                    } elseif (isset($selectedMovie['title'])) {
                        $movieTitle = $selectedMovie['title'];
                    } elseif (isset($selectedMovie['movie_name'])) {
                        $movieTitle = $selectedMovie['movie_name'];
                    }
                    echo htmlspecialchars($movieTitle);
                    ?>
                </h2>
            <?php endif; ?>
        <?php endif; ?>
    </div>


    <div class="form-container">
        <select id="film" name="film" required>
            <option value="">Selecteer een film</option>
            <?php
            if (isset($filmdata) && is_array($filmdata)):
                foreach ($filmdata as $film):
                    $filmId = isset($film['id']) ? $film['id'] : '';
                    $filmTitle = '';
                    if (isset($film['name'])) {
                        $filmTitle = $film['name'];
                    } elseif (isset($film['title'])) {
                        $filmTitle = $film['title'];
                    } elseif (isset($film['movie_name'])) {
                        $filmTitle = $film['movie_name'];
                    }
                    if ($filmId && $filmTitle):
            ?>
                        <option value="<?php echo htmlspecialchars($filmId); ?>"
                            <?php echo ($selectedId == $filmId) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($filmTitle); ?>
                        </option>
            <?php
                    endif;
                endforeach;
            endif;
            ?>
        </select>

        <select id="date" name="date" required>
            <option value="">Selecteer een datum</option>
            <?php
            // Generate dates for the next 7 days
            for ($i = 0; $i < 7; $i++) {
                $date = date('Y-m-d', strtotime("+$i days"));
                $displayDate = date('j F', strtotime("+$i days"));
                echo "<option value=\"$date\">$displayDate</option>";
            }
            ?>
        </select>

        <select id="time" name="time" required>
            <option value="">Selecteer een tijd</option>
            <?php
            $times = ['14:00', '16:30', '19:00', '21:30'];
            foreach ($times as $time) {
                echo "<option value=\"$time\">$time</option>";
            }
            ?>
        </select>
    </div>

    <!-- Stap 1 -->
    <div class="ticket-container">
        <h2>STAP 1: KIES JE TICKET</h2>
        <form method="post" style="margin-bottom:0;">
            <div class="ticket-section">
                <div class="ticket-header">
                    <span>TYPE</span>
                    <span class="text-right">PRIJS</span>
                    <span class="text-right">AANTAL</span>
                </div>
                <hr>
                <?php
                $selectedMovie = null;
                if ($selectedId && isset($filmdata) && is_array($filmdata)) {
                    foreach ($filmdata as $film) {
                        if (isset($film['id']) && $film['id'] == $selectedId) {
                            $selectedMovie = $film;
                            break;
                        }
                    }
                }
                $basePrice = $selectedMovie ? (getMovieInfo($selectedMovie, 'price') ?? 9.00) : 9.00;

                $ticketTypes = [
                    'normaal' => [
                        'name'  => 'Normaal',
                        'price' => $basePrice
                    ],
                    'kind' => [
                        'name'  => 'Kind t/m 11 jaar',
                        'price' => $basePrice * 0.6
                    ],
                    'senior' => [
                        'name'  => '65+',
                        'price' => $basePrice * 0.8
                    ]
                ];

                $ticketCounts = [
                    'normaal' => (int)($_POST['normaal'] ?? 0),
                    'kind'    => (int)($_POST['kind'] ?? 0),
                    'senior'  => (int)($_POST['senior'] ?? 0)
                ];

                foreach ($ticketTypes as $type => $info):
                ?>
                    <div class="ticket-row">
                        <span><?php echo htmlspecialchars($info['name']); ?></span>
                        <span class="text-right">€<?php echo number_format($info['price'], 2, ',', '.'); ?></span>
                        <div class="aantal-select">
                            <select name="<?php echo $type; ?>" id="<?php echo $type; ?>" data-price="<?php echo $info['price']; ?>">
                                <?php for ($i = 0; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div id="total-section" class="total-section">
                    <div class="ticket-row">
                        <span><strong>TOTAAL</strong></span>
                        <span></span>
                        <span class="text-right"><strong id="total-price">€0,00</strong></span>
                    </div>
                </div>
                <hr>
                <button type="submit" name="saveTickets" class="bevestigen-btn">Tickets opslaan</button>
            </div>
        </form>
        <script>
            document.querySelectorAll('.aantal-select select').forEach(select => {
                select.addEventListener('change', function() {
                    let total = 0;
                    document.querySelectorAll('.aantal-select select').forEach(sel => {
                        const price = parseFloat(sel.dataset.price);
                        const quantity = parseInt(sel.value);
                        total += price * quantity;
                    });
                    document.getElementById('total-price').textContent = '€' + total.toFixed(2).replace('.', ',');
                });
            });
        </script>
        <?php
        // Stap 1: Tickets opslaan in session
        if (isset($_POST['saveTickets'])) {
            $_SESSION['tickets'] = [
                'normaal' => isset($_POST['normaal']) ? (int)$_POST['normaal'] : 0,
                'kind' => isset($_POST['kind']) ? (int)$_POST['kind'] : 0,
                'senior' => isset($_POST['senior']) ? (int)$_POST['senior'] : 0,
                'prijs' => $basePrice
            ];
            // Sla gekozen film ID op in sessie
            if (!empty($selectedId)) {
                $_SESSION['gekozen_film_id'] = $selectedId;
            }
        }
        ?>

        <div class="step-divider"></div>
        <!-- Stap 2 -->
        <div class="ticket-container">
            <h2>STAP 2: KIES JE STOELEN</h2>
            <form method="post" style="margin-bottom:0;">
                <div class="seat-section">
                    <div class="screen">FILMSCHERM</div>
                    <div class="seats-grid">
                        <?php
                        $rows = 10;
                        $seatsPerRow = 11;
                        for ($i = 0; $i < $rows; $i++) {
                            for ($j = 0; $j < $seatsPerRow; $j++) {
                                $isAvailable = 1;
                                $seatClass = $isAvailable ? 'available' : 'unavailable';
                                $isHandicap = ($i === $rows - 1 && $j < 2);
                                $seatValue = ($i + 1) . '-' . ($j + 1);
                                echo "<label class='seat $seatClass" . ($isHandicap ? ' handicap' : '') . "'>";
                                echo "<input type='checkbox' name='seats[]' value='$seatValue'>";
                                if ($isHandicap) {
                                    echo "<img src='img/handicap-pictogram.png' alt='Handicap toegankelijk' class='handicap-icon'>";
                                } else {
                                    echo ($j + 1);
                                }
                                echo "</label>";
                            }
                            echo "<br>";
                        }
                        ?>
                    </div>
                    <button type="submit" name="saveSeats" class="bevestigen-btn">Stoelen opslaan</button>
                    <div class="seat-legend">
                        <div class="legend-item">
                            <div class="seat available"></div>
                            <span>Beschikbaar</span>
                        </div>
                        <div class="legend-item">
                            <div class="seat selected"></div>
                            <span>Geselecteerd</span>
                        </div>
                        <div class="legend-item">
                            <div class="seat unavailable"></div>
                            <span>Niet beschikbaar</span>
                        </div>
                    </div>
                </div>
            </form>
            <?php
            // Stap 2: Stoelen opslaan in session
            if (isset($_POST['saveSeats']) && isset($_POST['seats'])) {
                $_SESSION['selected_seats'] = [];
                foreach ($_POST['seats'] as $seat) {
                    list($row, $seatNum) = explode('-', $seat);
                    $_SESSION['selected_seats'][] = [
                        'row' => $row,
                        'seat' => $seatNum
                    ];
                }
            }
            ?>

            <div class="step-divider"></div>
            <!-- Stap 3 -->
            <?php
            $movie =  $filmdata['movie'];
            $film = $filmdata['cinema'];
            ?>
            <div class="ticket-container">
                <h2>STAP 3: CONTROLEER JE BESTELLING</h2>
                <?php if ($film): ?>
                <?php else: ?>
                    <p>Geen film geselecteerd.</p>
                <?php endif; ?>
                <div class="order-review">
                    <div class="stap-3-poster">
                        <img class="detail-poster-stap-3" src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($movie['poster_path']) ?>" alt="Poster van <?= htmlspecialchars($movie['title']) ?>">
                    </div>
                    <?php if (isset($_SESSION['tickets'])): ?>
                        <ul class="ticket-summary">
    <li><?php echo $filmdata['movie']['title']; ?></li>
    <li>Zaal: <?php echo $filmdata['cinema']['auditorium_number']; ?></li>
    <li>Wanneer: <?php echo $filmdata['cinema']['start_time']; ?> </li>

    <?php foreach ($_SESSION['selected_seats'] as $seat): ?>
        <?php if (!empty($seat['row']) && !empty($seat['seat'])): ?>
            <li>Stoel: Rij <?php echo htmlspecialchars($seat['row']); ?>, Stoel <?php echo htmlspecialchars($seat['seat']); ?></li>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php
        // totaal en aantallen per type BUITEN de foreach
        $totalTickets = array_sum([
            $_SESSION['tickets']['normaal'],
            $_SESSION['tickets']['kind'],
            $_SESSION['tickets']['senior']
        ]);
    ?>
    <li><strong>Totaal aantal tickets: <?php echo $totalTickets; ?></strong></li>
    <li>Normaal: <?php echo $_SESSION['tickets']['normaal']; ?></li>
    <li>Kind: <?php echo $_SESSION['tickets']['kind']; ?></li>
    <li>Senior: <?php echo $_SESSION['tickets']['senior']; ?></li>

    <li>Totaalprijs:
        €<?php echo number_format($_SESSION['tickets']['prijs'] * $totalTickets, 2, ',', '.'); ?>
    </li>
</ul>

                    <?php endif; ?>
                    <?php if (isset($_SESSION['selected_seats']) && !empty($_SESSION['selected_seats'])): ?>

                        <ul>

                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <div class="step-divider"></div>
            <!-- Stap 4 -->
            <div class="ticket-container">
                <h2>STAP 4: VUL JE GEGEVENS IN</h2>
                <div class="form-section">
                    <form class="contact-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Voornaam</label>
                                <input type="text" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="surname">Achternaam</label>
                                <input type="text" id="surname" name="surname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mailadres</label>
                            <input type="email" id="email" name="email">
                        </div>
                    </form>
                </div>
            </div>

            <div class="step-divider"></div>
            <!-- Stap 5 -->
            <div class="ticket-container">
                <h2>STAP 5: KIES JE BETAALWIJZE</h2>
                <div class="payment-section">
                    <div class="payment-methods">
                        <div class="payment-method">
                            <img src="img/ideal.png" alt="iDEAL">
                            <span>iDEAL</span>
                        </div>
                        <div class="payment-method">
                            <img src="img/creditcard.png" alt="Credit Card">
                            <span>Credit Card</span>
                        </div>
                        <div class="payment-method">
                            <img src="img/maestro.png" alt="Maestro">
                            <span>Maestro</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Afrekenen Button -->
            <div class="checkout-container">
                <button class="afrekenen-btn" onclick="location.href='bon.php'">AFREKENEN</button>
            </div>

            <?php include 'includes/footer.php'; ?>
</body>

</html>