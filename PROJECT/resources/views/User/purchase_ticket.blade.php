@extends('layouts.user')

@section('title', 'BD Railway E-Ticketing')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')

    <h2 class="section-title">Purchase Ticket</h2>

    <div class="alert" id="alrt">  
      <p class="alert-text">Please Note: Co-passengers' names (as given on their NID / photo ID) are mandatory to complete the ticket purchase process. All passengers MUST carry their NID / photo ID document while traveling.</p>
    </div>

    <div class="alert" id="alrt">
      <p class="alert-text">Please complete the passenger details, review and continue to the payment page within 6 minutes, or the selected seat(s) will be released and you will have to re-initiate the booking process.</p>
    </div>

    <div class="content">
      <div class="form-section">
      <h3 class="form-title" id="pass_title">PASSENGER DETAILS</h3>
      <!-- Container for Dynamic Passenger Cards -->
      <div id="passenger-cards-container"></div>


        <h3 class="form-title" id="con_info">CONTACT INFORMATION</h3>
        <!-- Card for Contact Information -->
        <div class="card" id="pass_card">         
          <div class="form-group">
            <label for="mobile" class="label">Mobile*</label>
            <input type="tel" id="mobile" class="input">
          </div>
          <div class="form-group">
            <label for="email" class="label">Email*</label>
            <input type="email" id="email" class="input">
          </div>
        </div>
      </div>
      <!-- Card for Payment Details (New Card) -->
      
      <!-- Journey Details Section -->
      <div class="details-section">
        <div class="timer">
          <div class="timer-value">4:24</div>
          <p class="timer-text">Remaining to initiate your payment process</p>
        </div>
        <div class="journey-details">
            <h3 class="details-title">JOURNEY DETAILS</h3>
            <h4 class="details-subtitle">Train: <span id="train-name">{{ $journeyDetails['trainName'] ?? 'N/A' }}</span></h4>
            <p class="details-text">
                Route: 
                <span id="train-route">
                    {{ isset($journeyDetails['departureStation']) && isset($journeyDetails['arrivalStation']) 
                        ? $journeyDetails['departureStation'] . ' - ' . $journeyDetails['arrivalStation'] 
                        : 'N/A' 
                    }}
                </span>
            </p>
            <p class="details-text">Departure: <span id="departure-time">{{ $journeyDetails['departureTime'] ?? 'N/A' }}</span></p>
            <p class="details-text">Coach: 
            <span id="coach">
                @if(isset($journeyDetails['coach']) && is_array($journeyDetails['coach']))
                    {{ implode(', ', $journeyDetails['coach']) }}
                @else
                    {{ $journeyDetails['coach'] ?? 'N/A' }}
                @endif
            </span>
        </p>

            <p class="details-text">Seat Type: 
              <span id="class-name">
                  {{ isset($journeyDetails['className']) && is_array($journeyDetails['className']) 
                      ? implode(', ', $journeyDetails['className']) 
                      : $journeyDetails['className'] ?? 'N/A' 
                  }}
              </span>
          </p>
            <p class="details-text">Seats: 
                <span id="seats">
                    {{-- Handle seats safely using json_decode --}}
                    {{ isset($journeyDetails['selectedSeats']) ? implode(', ', json_decode($journeyDetails['selectedSeats'], true)) : 'N/A' }}
                </span>
            </p>
        </div>
      </div>
    </div>
    <h3 class="form-title" id="pay_det">PAYMENT DETAILS</h3>
    <div class="card" id="payment_card">     
      <div class="total-amount">
        <h4 class="amount-title">Total Amount Payable: <span id="total-amount" class="amount-value">৳1594</span></h4>
       </div>
        <div class="train_img">
            <img src="{{ asset('images/BDRAILWAY_TICK.jpg') }}?" alt="Train ticket information in Bengali" />
        </div>
        <div class="fare-details">     
          <div id="paymentAcknowledgment">
            <p>By clicking on the "PROCEED TO PAYMENT" button below, you acknowledge that you have read and agreed to the </p>
            <p><a href="#" class="text-green-600">Terms & Conditions</a></p>
              </div>
              <div id="paymentTimeLimit">
                  <p>Please complete your payment within 15 minutes, otherwise your seat(s) will be cancelled.</p>
              </div>

              <div id="ticketRefundPolicy">
                  <p>Provision for cases in which tickets have been issued for trains not having room available for additional passengers:</p>
                  <ul>
                      <li>Fares shall be deemed to be accepted, and tickets to be issued, subject to the condition of there being room available in the train for which the tickets are issued.</li>
                      <li>A person to whom a ticket has been issued and for whom there is not room available in the train for which the ticket was issued shall on returning the ticket within three hours after the departure of the train be entitled to have his fare at once refunded.</li>
                      <li>A person for whom there is not room available for the class for which he has purchased a ticket and who is obliged to travel in a carriage of a lower class shall be entitled on delivering up his ticket to a refund of the difference between the fare paid by him and the fare payable for the class of carriage in which he traveled.</li>
                  </ul>
              </div>
          </div>
          <div class="payment-selection-container">
            <div class="tab-header">
                <button class="tab-button active">Mobile Banking</button>
                <button class="tab-button active">Credit or Debit Card</button>
            </div>
            <div class="payment-methods">
            <p id="pls_selct">Please select your payment method</p>
                <button class="payment-method"><img src="{{ asset('images/bkash_logo.png') }}" alt="Bkash"></button>
                <button class="payment-method"><img src="{{ asset('images/nagad.png') }}" alt="Nagad"></button>
                <button class="payment-method"><img src="{{ asset('images/rocket-logo.svg') }}" alt="Rocket"></button>
                <button class="payment-method"><img src="{{ asset('images/upay.svg') }}" alt="Upay"></button>
                <div class="proceed-button-container">
                    <button class="proceed-button" id="proceed-button">PROCEED TO PAYMENT</button>
                </div>
          </div>
<script src="{{ asset('js/user.js') }}"></script>
@endsection
<script>
    const isAuthenticated = {!! json_encode(auth()->check()) !!};  // Converts true/false into JSON format
    const authUserName = {!! json_encode(auth()->user()->name ?? '') !!};  // Converts username into JSON format

    $(document).ready(function() {
        updateTotalFare();  // Call the function on page load
    });

    // Optionally, trigger update when something changes in the seat details
    $(document).on('change', '.seat-details-body', function() {
        updateTotalFare();  // Recalculate and update when seat details change
    });
</script>
