
console.log('Page Loaded');

// Handle train details toggling
const chevrons = document.querySelectorAll('.fa-chevron-down');
chevrons.forEach(function (chevron) {
    chevron.addEventListener('click', function (event) {
        event.stopPropagation();
        const trainCard = this.closest('.card');
        const details = trainCard.querySelector('.train-details');

        // Toggle display of the train details
        details.style.display = details.style.display === 'none' || details.style.display === '' ? 'block' : 'none';
        this.classList.toggle('rotated');

        // Declare a variable to store train details
        const trainName = trainCard.querySelector('.card-body span').textContent.trim();
        const departureTime = details.querySelector('#departure-time strong').textContent.trim();
        const departureStation = details.querySelector('#departure-station').textContent.trim();
        const arrivalTime = details.querySelector('#arrival-time strong').textContent.trim();
        const arrivalStation = details.querySelector('#arrival-station').textContent.trim();
           
        // Log or store the variables for further use
        console.log({
            trainName: trainName,
            departureTime: departureTime,
            departureStation: departureStation,
            arrivalTime: arrivalTime,
            arrivalStation: arrivalStation
        });

        // You can store these values in a variable for further use or manipulation
        const trainDetails = {
            trainName: trainName,
            departureTime: departureTime,
            departureStation: departureStation,
            arrivalTime: arrivalTime,
            arrivalStation: arrivalStation
        };

        // Example: Use trainDetails object in some functionality
        // ...
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
// Handle booking class and coach selection
document.querySelectorAll('.book-now-btn').forEach(function (button) {
    button.addEventListener('click', function () {
        const selectedClass = this.getAttribute('data-class');
        const coaches = JSON.parse(this.getAttribute('data-coaches'));

        const coachSelect = this.closest('.train-details').querySelector('.coach-select');
        coachSelect.innerHTML = ''; // Clear previous options

        // Filter coaches for the selected class
        const filteredCoaches = coaches.filter(function (coach) {
            return coach.coach_class === selectedClass;
        });

        const seatMapContainer = this.closest('.train-details').querySelector('.seat-map');
        seatMapContainer.innerHTML = ''; // Clear previous seat data

        // Populate the dropdown with filtered coaches
        filteredCoaches.forEach(function (coach) {
            const option = document.createElement('option');
            option.value = coach.coach;
            option.textContent = `${coach.coach} - ${coach.seats} Seat(s)`;
            coachSelect.appendChild(option);
        });

        // No coaches available for the selected class
        if (!filteredCoaches.length) {
            coachSelect.innerHTML = '<option value="">No coaches available</option>';
            seatMapContainer.innerHTML = '<p>No seats available for the selected class.</p>';
        } else {
            // Select the first coach automatically
            coachSelect.selectedIndex = 0;
            
            // Trigger seat loading for the first coach
            loadSeatsForCoach(coachSelect.value, coaches, seatMapContainer);
        }
    });
});

// Handle coach selection and seat map population based on capacity
document.addEventListener('change', function (event) {
    if (event.target.classList.contains('coach-select')) {
        const selectedCoach = event.target.value;
        const bookNowBtn = event.target.closest('.train-details').querySelector('.book-now-btn');
        const coaches = JSON.parse(bookNowBtn.getAttribute('data-coaches'));

        const seatMapContainer = event.target.closest('.train-details').querySelector('.seat-map');
        seatMapContainer.innerHTML = ''; // Clear previous seats

        loadSeatsForCoach(selectedCoach, coaches, seatMapContainer);
    }
});

// Function to load seats for the selected coach
function loadSeatsForCoach(selectedCoach, coaches, seatMapContainer) {
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


// Seat click event to handle selection
// Global object to store selected seats by class and coach
let selectedSeats = {};

// Variable to store the coach for each selected seat
let seatToCoachMap = {};

// Variable to store all selected coaches
let selectedCoaches = new Set(); // Using a Set to avoid duplicates

// Event listener for seat selection
document.addEventListener('click', function (event) {
if (event.target.classList.contains('seat')) {
    const seatDiv = event.target;
    const selectedSeat = seatDiv.textContent.trim(); // Get the seat number (e.g., THA-31)

    // Ensure the seat class and fare are retrieved from the selected coach
    const trainDetails = seatDiv.closest('.train-details');
    const selectedCoachElement = trainDetails.querySelector('.coach-select');

    if (!selectedCoachElement) {
        console.error('Coach selection dropdown not found');
        return;
    }

    const selectedCoach = selectedCoachElement.value;

    // Add console log for selected coach
    console.log('Selected Coach:', selectedCoach); // Log the coach value here

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

        // Remove seat from the seatToCoachMap
        delete seatToCoachMap[selectedSeat];

        // If no more seats are selected in this coach, remove the coach from selectedCoaches
        if (selectedSeats[classCoachKey].length === 0) {
            selectedCoaches.delete(selectedCoach);
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

            // Map the seat to its coach
            seatToCoachMap[selectedSeat] = selectedCoach;

            // Add the selected coach to the selectedCoaches set
            selectedCoaches.add(selectedCoach);

            addSeatToDetails(seatClass, selectedSeat, seatFare); // Call to add seat details
        } else {
            alert('You can only select 4 seats.');
        }
    }

    // Log the current selected coaches
    console.log('Selected Coaches:', Array.from(selectedCoaches));

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
let total = localStorage.getItem('total') ? parseInt(localStorage.getItem('total')) : 0;
// Function to update the total fare in the seat details
function updateTotalFare() {
   
    $('.seat-details-body tr').each(function () {
        const fare = parseFloat($(this).find('td:nth-child(3)').text().replace('৳', ''));
        if (!isNaN(fare)) total += fare;
    });

    const totalCell = $('.total td:last-child');
    if (totalCell.length) {
        totalCell.text(`৳${total.toFixed(2)}`);
    }

    localStorage.setItem('total', total);

    $('#total-amount').text(`৳${total.toFixed(2)}`);
    
    console.log('Total fare updated:', total);    
}
console.log('Total fare updated outside :', total);

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

// Declare a global variable to store selected seat count
let selectedSeatCount = localStorage.getItem('selectedSeatCount') ? parseInt(localStorage.getItem('selectedSeatCount')) : 0; // Retrieve selectedSeatCount from localStorage, or set to 0 if not available

document.querySelectorAll('.seat-selection .btn-success').forEach(function (button) {
    button.addEventListener('click', function () {
        const trainCard = this.closest('.card');
        const trainDetails = trainCard.querySelector('.train-details');
        
        if (!trainDetails) {
            console.error('Train details not found');
            return;
        }

        // Get journey details from the seat details table
        const seatDetailsTable = document.querySelector('#seatDetailsTable tbody.seat-details-body');
        const selectedSeats = [];
        const seatClassSet = new Set(); // To store all selected seat classes
        
        if (seatDetailsTable) {
            seatDetailsTable.querySelectorAll('tr').forEach(function (row) {
                const seatClass = row.querySelector('td:nth-child(1)').textContent.trim();
                const seatNumber = row.querySelector('td:nth-child(2)').textContent.trim();
        
                selectedSeats.push({
                    seatClass: seatClass,
                    seatNumber: seatNumber
                });
        
                // Add the seat class to the Set to store all unique seat classes
                seatClassSet.add(seatClass);
            });
        
            // Convert the Set to an array to display or use all selected seat classes
            const allSelectedSeatClasses = Array.from(seatClassSet);
        
            // Update the global seat count variable
            selectedSeatCount = selectedSeats.length;
            localStorage.setItem('selectedSeatCount', selectedSeatCount); // Store the selectedSeatCount in localStorage

            // Log or use the array of all selected seat classes
            console.log('All selected seat classes:', allSelectedSeatClasses);
            console.log('Selected seat count:', selectedSeatCount); // Log seat count for debugging
        
            // You can now display or use all the seat classes      
        } else {
            console.error('Seat details table not found');
        }
        
        // Use all selected seat classes instead of only the first one
        const coachType = selectedSeats.length > 0 ? Array.from(seatClassSet).join(', ') : 'N/A';
        const selectedSeatNumbers = selectedSeats.map(seat => seat.seatNumber);
        
        const selectedCoachesArray = Array.from(selectedCoaches);
        const encodedCoaches = encodeURIComponent(selectedCoachesArray.join(','));
        // Fetch journey details directly from the train-details section using IDs (like in the chevron logic)
        const trainName = trainCard.querySelector('.card-body span').textContent.trim();
        const departureTime = trainDetails.querySelector('#departure-time strong').textContent.trim();
        const departureStation = trainDetails.querySelector('#departure-station').textContent.trim();
        const arrivalTime = trainDetails.querySelector('#arrival-time strong').textContent.trim();
        const arrivalStation = trainDetails.querySelector('#arrival-station').textContent.trim();

        // Log the values after fetching them
        console.log('Train Name:', trainName);
        console.log('Departure Time:', departureTime);
        console.log('Departure Station:', departureStation);
        console.log('Arrival Time:', arrivalTime);
        console.log('Arrival Station:', arrivalStation);
        console.log('Coach Type:', coachType); // Now fetched from all selected seat classes
        console.log('Selected Seats:', selectedSeatNumbers);
        console.log('Selected Coaches:', Array.from(selectedCoaches));
        
        // Validate all required details
        if (!trainName || !departureTime || !departureStation || !arrivalTime || !arrivalStation || !coachType || !selectedSeatNumbers.length || !Array.from(selectedCoaches)) {
            console.error('Some journey details are missing.');
            alert('Please fill out all required details before proceeding.');
            return;
        }
        // Construct the URL with query parameters using journey details
        const purchaseTicketUrl = `/purchase-ticket?trainName=${encodeURIComponent(trainName)}&departureTime=${encodeURIComponent(departureTime)}&departureStation=${encodeURIComponent(departureStation)}&arrivalTime=${encodeURIComponent(arrivalTime)}&arrivalStation=${encodeURIComponent(arrivalStation)}&selectedSeats=${encodeURIComponent(JSON.stringify(selectedSeatNumbers))}&className=${encodeURIComponent(coachType)}&coach=${encodedCoaches}`;

        console.log(purchaseTicketUrl);

        // Redirect to the purchase page with the details in the URL
        window.location.href = purchaseTicketUrl;
    });
});

document.addEventListener('DOMContentLoaded', () => {
    // Function to generate passenger card HTML
    function createPassengerCard(passengerNumber, isAuthenticated, authUserName) {
        return `
            <div class="card" id="pass_card">
                <div class="passenger">
                    <h4 class="passenger-title">Passenger ${passengerNumber}</h4>
                    <div class="form-group">
                        <label for="name${passengerNumber}" class="label">Name ${passengerNumber}${!isAuthenticated ? ' *' : ''}</label>
                        <input type="text" id="name${passengerNumber}" class="input" 
                            ${isAuthenticated && passengerNumber === 1 ? `value="${authUserName}"` : 'placeholder="Enter Full Name"'}/>
                    </div>
                    <div class="form-group">
                        <label for="type${passengerNumber}" class="label">Passenger Type</label>
                        <select id="type${passengerNumber}" class="input">
                            <option>Adult</option>
                        </select>
                    </div>
                </div>
            </div>
        `;
    }

    // Get the selected seat count from localStorage
    let selectedSeatCount = localStorage.getItem('selectedSeatCount') ? parseInt(localStorage.getItem('selectedSeatCount')) : 0;
    // Container to add passenger cards
    const container = document.getElementById('passenger-cards-container');

    // Ensure at least 1 passenger card is generated, even if seat count is 0
    const passengerCount = selectedSeatCount > 0 ? selectedSeatCount : 1;

    // Create and append passenger cards based on the selected seat count
    for (let i = 1; i <= passengerCount; i++) {
        container.insertAdjacentHTML('beforeend', createPassengerCard(i, isAuthenticated, authUserName));
    }
    
    // Log the selectedSeatCount for debugging purposes
    console.log('Selected Seat Count:', selectedSeatCount);
});





















   
