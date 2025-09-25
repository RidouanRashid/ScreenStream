document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded");

    const seats = document.querySelectorAll('.seat');
    const bevestigenBtn = document.querySelector('.bevestigen-btn');
    
    console.log("Found", seats.length, "seats");

    seats.forEach(seat => {
        if (!seat.classList.contains('available') && 
            !seat.classList.contains('selected') && 
            !seat.classList.contains('unavailable')) {
            seat.classList.add('available');
        }

        seat.addEventListener('click', function() {
            if (!this.classList.contains('confirmed')) {
                console.log("Seat clicked:", this.dataset.row, this.dataset.seat);
                
                if (this.classList.contains('available')) {
                    this.classList.remove('available');
                    this.classList.add('selected');
                } else if (this.classList.contains('selected')) {
                    this.classList.remove('selected');
                    this.classList.add('available');
                }
            }
        });
    });

    bevestigenBtn.addEventListener('click', function() {
        const selectedSeats = document.querySelectorAll('.seat.selected');
        const seatData = [];

        selectedSeats.forEach(seat => {
            seatData.push({
                row: seat.dataset.row,
<<<<<<< Updated upstream
                seat: seat.dataset.seat
            });
            seat.classList.remove('selected');
            seat.classList.add('confirmed');
            console.log("Confirmed seat:", seat.dataset.row, seat.dataset.seat);
        });

        if (selectedSeats.length > 0) {
            // Save seat data using AJAX
=======
                seat: seat.dataset.seat,
                isHandicap: seat.classList.contains('handicap')
            });
        });

        if (selectedSeats.length > 0) {
>>>>>>> Stashed changes
            fetch('save_seats.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ seats: seatData })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
<<<<<<< Updated upstream
                    alert('Stoelen zijn bevestigd');
                } else {
                    alert('Er is een fout opgetreden bij het opslaan van de stoelen');
=======
                    // Mark seats as confirmed only after successful save
                    selectedSeats.forEach(seat => {
                        seat.classList.remove('selected');
                        seat.classList.add('confirmed');
                        seat.style.pointerEvents = 'none'; // Prevent further selection
                    });
                    alert('Stoelen zijn succesvol bevestigd');
                } else {
                    alert(data.message || 'Er is een fout opgetreden bij het opslaan van de stoelen');
>>>>>>> Stashed changes
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Er is een fout opgetreden bij het opslaan van de stoelen');
            });
        } else {
            alert('Selecteer eerst stoelen om te bevestigen.');
        }
    });
<<<<<<< Updated upstream
});

=======
});
>>>>>>> Stashed changes
