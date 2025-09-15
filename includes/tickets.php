<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>ScreenStream - Tickets</title>
</head>
<body>
    <div class="title-container">
        <h1>TICKETS BESTELLEN</h1>
    </div>
    <div class="form-container">
        <select id="film" name="film">
            <option value="">Film</option>
            <option value="jurassic-world">Jurassic World</option>
            <option value="oppenheimer">Oppenheimer</option>
            <option value="barbie">Barbie</option>
        </select>

        <select id="date" name="date">
            <option value="">Datum</option>
            <option value="2025-09-10">10 september</option>
            <option value="2025-09-11">11 september</option>
        </select>

        <select id="time" name="time">
            <option value="">Tijdstip</option>
            <option value="19:00">19:00</option>
            <option value="21:30">21:30</option>
        </select>
    </div>

    <!-- Stap 1 -->
    <div class="ticket-container">
        <h2>STAP 1: KIES JE TICKET</h2>
        <div class="ticket-section">
            <div class="ticket-header">
                <span>TYPE</span>
                <span class="text-right">PRIJS</span>
                <span class="text-right">AANTAL</span>
            </div>
            <hr>
            <div class="ticket-row">
                <span>Normaal</span>
                <span class="text-right">€9,00</span>
                <div class="aantal-select">
                    <select name="normaal" id="normaal">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>
            <div class="ticket-row">
                <span>Kind t/m 11 jaar</span>
                <span class="text-right">€5,00</span>
                <div class="aantal-select">
                    <select name="kind" id="kind">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>
            <div class="ticket-row">
                <span>65+</span>
                <span class="text-right">€7,00</span>
                <div class="aantal-select">
                    <select name="senior" id="senior">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="voucher-row">
                <span>VOUCHERCODE</span>
                <div class="voucher-input">
                    <input type="text" placeholder="Code">
                </div>
                <button class="toevoegen-btn">TOEVOEGEN</button>
            </div>
        </div>
    </div>

    <!-- Stap 2 -->
    <div class="ticket-container">
        <h2>STAP 2: KIES JE STOELEN</h2>
        <div class="seat-section">
            <div class="screen">FILMSCHERM</div>
            <div class="seats-grid">
                <!-- This will be populated with seats -->
            </div>
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
    </div>

    <!-- Stap 3 -->
    <div class="ticket-container">
        <h2>STAP 3: CONTROLEER JE BESTELLING</h2>
        <div class="order-section">
            <div class="movie-info">
                <img src="../img/jurassic-world.jpg" alt="Movie Poster" class="movie-poster">
                <div class="movie-details">
                    <h3>JURASSIC WORLD: FALLEN KINGDOM</h3>
                    <div class="movie-meta">
                        <span>Datum: 10 september</span>
                        <span>Tijd: 19:00</span>
                        <span>Zaal: 1</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Stap 5 -->
    <div class="ticket-container">
        <h2>STAP 5: KIES JE BETAALWIJZE</h2>
        <div class="payment-section">
            <div class="payment-methods">
                <div class="payment-method">
                    <img src="../img/ideal.png" alt="iDEAL">
                    <span>iDEAL</span>
                </div>
                <div class="payment-method">
                    <img src="../img/creditcard.png" alt="Credit Card">
                    <span>Credit Card</span>
                </div>
                <div class="payment-method">
                    <img src="../img/paypal.png" alt="PayPal">
                    <span>PayPal</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Afrekenen Button -->
    <div class="checkout-container">
        <button class="afrekenen-btn">AFREKENEN</button>
    </div>
</body>
</html>