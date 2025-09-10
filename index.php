<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>
    <div class=title-container>
        <h1>TICKETS BESTELLEN</h1>
    </div>
    <div class="form-container">
        <label for="film"></label>
        <select id="film" name="film">
            <option value="jurassic-world">Jurassic World</option>
            <option value="oppenheimer">Oppenheimer</option>
            <option value="barbie">Barbie</option>
        </select>

        <label for="date"></label>
        <select id="date" name="date" placeholder="Datum">
            <option value="Datum">Datum</option>
            <option value="2025-09-10">10 september </option>
            <option value="2025-09-11">11 september </option>
        </select>

        <label for="time"></label>
        <select id="time" name="time" placeholder="Tijdstip">
            <option value="Tijdstip">Tijdstip</option>
            <option value="19:00">19:00</option>
            <option value="21:30">21:30</option>
        </select>
    </div>
    <div class="ticket-container">
        <div class="stap-1">
            <table class="ticket-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Prijs</th>
                        <th>Aantal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Normaal</td>
                        <td>€12,00</td>
                        <td><input type="number" min="0" value="0"></td>
                    </tr>
                    <tr>
                        <td>Kind t/m 11 jaar</td>
                        <td>€9,50</td>
                        <td><input type="number" min="0" value="0"></td>
                    </tr>
                    <tr>
                        <td>65+</td>
                        <td>€8,50</td>
                        <td><input type="number" min="0" value="0"></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</body>

</html>