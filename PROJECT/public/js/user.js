
    console.log('Page Loaded');

    // Handle train details toggling
    const chevrons = document.querySelectorAll('.fa-chevron-down');
    chevrons.forEach(function (chevron) {
        chevron.addEventListener('click', function (event) {
            event.stopPropagation();
            const trainCard = this.closest('.card');
            const details = trainCard.querySelector('.train-details');

            details.style.display = details.style.display === 'none' || details.style.display === '' ? 'block' : 'none';
            this.classList.toggle('rotated');
        });
    });

    // Handle "Book Now" button click
    const bookNowButtons = document.querySelectorAll('.ticket-type .btn-success');
    bookNowButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const isAuthenticated = button.getAttribute('data-bs-target') !== '#loginModal';
            const trainCard = this.closest('.card');
            const seatSelection = trainCard.querySelector('.seat-selection');

            if (isAuthenticated && seatSelection) {
                seatSelection.style.display = seatSelection.style.display === 'none' || seatSelection.style.display === '' ? 'block' : 'none';
            } else {
                const modal = new bootstrap.Modal(document.getElementById('loginModal'));
                modal.show();
            }
        });
    });

    // Handle booking class and coach selection
    document.querySelectorAll('.book-now-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const selectedClass = this.getAttribute('data-class');
            const coaches = JSON.parse(this.getAttribute('data-coaches'));

            const coachSelect = this.closest('.train-details').querySelector('.coach-select');
            coachSelect.innerHTML = '';

            // Filter coaches for the selected class
            const filteredCoaches = coaches.filter(function (coach) {
                return coach.coach_class === selectedClass;
            });

            const seatMapContainer = this.closest('.train-details').querySelector('.seat-map');
            seatMapContainer.innerHTML = ''; // Clear previous seat data

            filteredCoaches.forEach(function (coach) {
                const option = document.createElement('option');
                option.value = coach.coach;
                option.textContent = `${coach.coach} - ${coach.seats} Seat(s)`;
                coachSelect.appendChild(option);
            });

            // No coaches available for the selected class
            if (!filteredCoaches.length) {
                coachSelect.innerHTML = '<option value="">No coaches available</option>';
            }

            // Automatically trigger a coach change event to load seats for the first coach
            const event = new Event('change');
            coachSelect.dispatchEvent(event);
        });
    });

    // Handle coach selection and seat map population based on capacity
    document.addEventListener('change', function (event) {
        if (event.target.classList.contains('class-select')) {
            // Clear coach dropdown when class changes
            const coachSelect = document.querySelector('.coach-select');
            coachSelect.innerHTML = ''; // Reset coach options

            const selectedClass = event.target.value;
            const bookNowBtn = event.target.closest('.train-details').querySelector('.book-now-btn');
            const coaches = JSON.parse(bookNowBtn.getAttribute('data-coaches')); // Get coaches data

            // Filter the coaches based on the selected class
            const filteredCoaches = coaches.filter(coach => coach.class === selectedClass);

            // Populate the coach dropdown with filtered coaches
            filteredCoaches.forEach(coach => {
                const option = document.createElement('option');
                option.value = coach.coach;
                option.textContent = `${coach.coach} - ${coach.seats} Seat(s)`; // Show coach and seat count
                coachSelect.appendChild(option);
            });

            // Reset the seat map
            const seatMapContainer = document.querySelector('.seat-map');
            seatMapContainer.innerHTML = '<p>Please select a coach to see available seats.</p>';
        }

        if (event.target.classList.contains('coach-select')) {
            const selectedCoach = event.target.value;
            const bookNowBtn = event.target.closest('.train-details').querySelector('.book-now-btn');
            const coaches = JSON.parse(bookNowBtn.getAttribute('data-coaches'));

            const seatMapContainer = event.target.closest('.seat-selection').querySelector('.seat-map');
            seatMapContainer.innerHTML = ''; // Clear previous seats

            // Find the data for the selected coach
            const selectedCoachData = coaches.find(coach => coach.coach === selectedCoach);

            if (selectedCoachData) {
                for (let i = 1; i <= selectedCoachData.seats; i++) {
                    const seatDiv = document.createElement('div');
                    seatDiv.classList.add('seat');
                    seatDiv.textContent = `${selectedCoachData.coach}-${i}`; // Display seat number

                    // Placeholder for booked seats check (you can update this with actual booking data)
                    const isBooked = false; // Assuming no seats are booked initially

                    // Change style if the seat is booked
                    if (isBooked) {
                        seatDiv.classList.add('booked');
                    }

                    seatMapContainer.appendChild(seatDiv); // Add each seat to the seat map
                }
            } else {
                seatMapContainer.innerHTML = '<p>No seats available for the selected coach.</p>';
            }
        }
    });

// Seat click event to handle selection
// Global object to store selected seats by class and coach
let selectedSeats = {};

// Document event listener for seat selection
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('seat')) {
        const seatDiv = event.target;
        const selectedSeat = seatDiv.textContent; // Get the seat number (e.g., THA-31)

        // Ensure the seat class and fare are retrieved from the selected coach
        const trainDetails = seatDiv.closest('.train-details');
        const selectedCoachElement = trainDetails.querySelector('.coach-select');

        if (!selectedCoachElement) {
            console.error('Coach selection dropdown not found');
            return;
        }

        const selectedCoach = selectedCoachElement.value;
        const bookNowBtn = trainDetails.querySelector('.book-now-btn');
        const coaches = JSON.parse(bookNowBtn.getAttribute('data-coaches'));

        const selectedCoachData = coaches.find(coach => coach.coach === selectedCoach);

        if (!selectedCoachData) {
            console.error('Selected coach data not found');
            return;
        }

        const seatClass = selectedCoachData.coach_class;
        const seatFare = selectedCoachData.fare;
        const classCoachKey = `${seatClass}-${selectedCoach}`; // Create key for class-coach combination

        // Calculate total selected seats across all classes and coaches
        const totalSelectedSeats = Object.values(selectedSeats).reduce((acc, seats) => acc + seats.length, 0);

        // Toggle the selected state (color change)
        if (seatDiv.classList.contains('selected')) {
            // Deselect the seat
            seatDiv.classList.remove('selected');
            seatDiv.style.backgroundColor = '';

            // Remove the seat from selectedSeats
            if (selectedSeats[classCoachKey]) {
                selectedSeats[classCoachKey] = selectedSeats[classCoachKey].filter(seat => seat !== selectedSeat);
            }

            removeSeatFromDetails(selectedSeat); // Call to remove seat details
        } else {
            if (totalSelectedSeats < 4) {
                // Select the seat
                seatDiv.classList.add('selected');
                seatDiv.style.backgroundColor = '#007bff';

                // Add the seat to selectedSeats
                if (!selectedSeats[classCoachKey]) {
                    selectedSeats[classCoachKey] = [];
                }
                selectedSeats[classCoachKey].push(selectedSeat);

                addSeatToDetails(seatClass, selectedSeat, seatFare); // Call to add seat details
            } else {
                alert('You can only select up to 4 seats across all classes and coaches.');
            }
        }

        updateTotalFare(); // Update the total fare after selecting/deselecting
    }
});

// Function to add seat details to the seat details table
function addSeatToDetails(seatClass, seatNumber, seatFare) {
    console.log(`Adding seat to details: ${seatClass} ${seatNumber} ${seatFare}`);

    const tbody = $('.seat-details-body'); // Using jQuery to select the table body
    if (!tbody.length) {
        console.error('Seat details table body not found');
        return;
    }

    // Ensure seatFare is a number
    const fare = parseFloat(seatFare);
    if (isNaN(fare)) {
        console.error(`Invalid seat fare: ${seatFare}`);
        return;
    }

    // Check if the seat is already added
    const existingRow = tbody.find(`tr[data-seat="${seatNumber}"]`);
    if (existingRow.length) {
        console.warn(`Seat ${seatNumber} is already added to the table.`);
        return;
    }

    // Dynamically create a new row for the seat
    const newRow = $(`<tr data-seat="${seatNumber}">
        <td>${seatClass}</td>
        <td>${seatNumber}</td>
        <td>৳${fare.toFixed(2)}</td>
    </tr>`);

    // Append the new row to the table body
    tbody.append(newRow);

    console.log('Row added:', newRow.prop('outerHTML'));

    // Update the total fare after adding the seat
    updateTotalFare();
}

// Function to remove seat details from the table
function removeSeatFromDetails(seatNumber) {
    const tbody = $('.seat-details-body'); // Using jQuery to select the table body
    const seatRow = tbody.find(`tr[data-seat="${seatNumber}"]`);

    if (seatRow.length) {
        seatRow.remove();
        console.log(`Seat ${seatNumber} removed from details.`);
        updateTotalFare();
    } else {
        console.warn(`Seat ${seatNumber} not found in table.`);
    }
}

// Function to update the total fare in the seat details
function updateTotalFare() {
    let total = 0;
    $('.seat-details-body tr').each(function () {
        const fare = parseFloat($(this).find('td:nth-child(3)').text().replace('৳', ''));
        if (!isNaN(fare)) total += fare;
    });

    const totalCell = $('.total td:last-child');
    if (totalCell.length) {
        totalCell.text(`৳${total.toFixed(2)}`);
    }

    console.log('Total fare updated:', total);
}

// Seat map population based on selected coach
document.addEventListener('change', function (event) {
    if (event.target.classList.contains('coach-select')) {
        const selectedCoach = event.target.value;
        const bookNowBtn = event.target.closest('.train-details').querySelector('.book-now-btn');
        const coaches = JSON.parse(bookNowBtn.getAttribute('data-coaches'));

        const seatMapContainer = event.target.closest('.seat-selection').querySelector('.seat-map');
        seatMapContainer.innerHTML = ''; // Clear previous seats

        // Find the data for the selected coach
        const selectedCoachData = coaches.find(coach => coach.coach === selectedCoach);

        if (selectedCoachData) {
            const classCoachKey = `${selectedCoachData.coach_class}-${selectedCoachData.coach}`; // Key for selected class-coach

            for (let i = 1; i <= selectedCoachData.seats; i++) {
                const seatDiv = document.createElement('div');
                seatDiv.classList.add('seat');
                seatDiv.textContent = `${selectedCoachData.coach}-${i}`; // Display seat number

                // Restore previously selected seats for this class and coach
                if (selectedSeats[classCoachKey] && selectedSeats[classCoachKey].includes(seatDiv.textContent)) {
                    seatDiv.classList.add('selected');
                    seatDiv.style.backgroundColor = '#007bff';
                }

                seatMapContainer.appendChild(seatDiv); // Add each seat to the seat map
            }
        } else {
            seatMapContainer.innerHTML = '<p>No seats available for the selected coach.</p>';
        }
    }
});




       

