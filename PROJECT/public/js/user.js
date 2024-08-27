// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function () {
    console.log('Page Loaded');

    // Handle form submission (if there's a form on the page)
    const bookingForm = document.querySelector('.booking-form form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Form submitted!');
            // Add further functionality as needed
        });
    }

    const chevrons = document.querySelectorAll('.fa-chevron-down');
    
    chevrons.forEach(function (chevron) {
        chevron.addEventListener('click', function (event) {
            event.stopPropagation(); // Stop event from bubbling up

            const trainCard = this.closest('.card');
            const details = trainCard.querySelector('.train-details');

            // Toggle visibility
            if (details.style.display === 'none' || details.style.display === '') {
                details.style.display = 'block';
            } else {
                details.style.display = 'none';
            }

            // Rotate the icon
            this.classList.toggle('rotated');
        });
    });

    const bookNowButtons = document.querySelectorAll('.ticket-type .btn-success');
    bookNowButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            // Prevent the modal from immediately triggering JS execution
            event.preventDefault();
    
            // Check if the user is authenticated (assuming the modal is triggered for unauthenticated users)
            const isAuthenticated = button.getAttribute('data-bs-target') !== '#loginModal';
    
            // Find the seat selection section within the current train card
            const trainCard = this.closest('.card');
            const seatSelection = trainCard.querySelector('.seat-selection');
    
            // Toggle visibility of seat selection if authenticated
            if (isAuthenticated && seatSelection) {
                if (seatSelection.style.display === 'none' || seatSelection.style.display === '') {
                    seatSelection.style.display = 'block';
                } else {
                    seatSelection.style.display = 'none';
                }
            } else {
                // Trigger the modal if not authenticated
                const modal = new bootstrap.Modal(document.getElementById('loginModal'));
                modal.show();
            }
        });
    });
    
});
