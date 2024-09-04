document.addEventListener('DOMContentLoaded', function () {
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

            // Reset seat map if class is changed
            const seatMapContainer = this.closest('.train-details').querySelector('.seat-map');
            seatMapContainer.innerHTML = ''; // Clear seat map to avoid previous seat data
            
            // Add coach options
            filteredCoaches.forEach(function (coach) {
                const option = document.createElement('option');
                option.value = coach.coach;
                option.textContent = `${coach.coach} - ${coach.seats} Seat(s)`;
                coachSelect.appendChild(option);
            });

            // No coaches available
            if (!filteredCoaches.length) {
                coachSelect.innerHTML = '<option value="">No coaches available</option>';
            }

            // Automatically trigger a coach change event to load seats for the first coach
            const event = new Event('change');
            coachSelect.dispatchEvent(event);
        });
    });

    // Handle coach selection and seat map population
    document.addEventListener('change', function (event) {
        if (event.target.classList.contains('coach-select')) {
            const selectedCoach = event.target.value;
            const bookNowBtn = event.target.closest('.train-details').querySelector('.book-now-btn');
            const coaches = JSON.parse(bookNowBtn.getAttribute('data-coaches'));

            const seatMapContainer = event.target.closest('.seat-selection').querySelector('.seat-map');
            seatMapContainer.innerHTML = '';

            // Find data for the selected coach
            const selectedCoachData = coaches.find(coach => coach.coach === selectedCoach);

            if (selectedCoachData) {
                const bookedSeats = selectedCoachData.bookedSeats || [];
                for (let i = 1; i <= selectedCoachData.seats; i++) {
                    const seatDiv = document.createElement('div');
                    seatDiv.classList.add('seat');
                    seatDiv.textContent = `${selectedCoachData.coach}-${i}`;
                    
                    if (bookedSeats.includes(i)) {
                        seatDiv.classList.add('booked');
                    }

                    seatMapContainer.appendChild(seatDiv);
                }
            } else {
                seatMapContainer.innerHTML = '<p>No seats available for the selected coach.</p>';
            }
        }
    });
});
