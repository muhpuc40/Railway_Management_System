@extends('layouts.user')

@section('title', 'BD Railway E-Ticketing')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">

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
        <div class="fare-details">
          <h4 class="fare-title">FARE DETAILS</h4>
          <p class="fare-text">Ticket Price: <span id="ticket-price">1350</span></p>
          <p class="fare-text">VAT: <span id="vat">204</span></p>
          <p class="fare-text">Service Charge: <span id="service-charge">40</span></p>
          <p class="fare-total">**Total: <span id="total">৳1594</span></p>
          <p class="fare-note">Please note that service charge is non-refundable. <br>**Total includes ৳50 Bedding Charges per seat for AC_B and F_BERTH seat classes.</p>
        </div>
      </div>
  </div>
<script src="{{ asset('js/user.js') }}"></script>
@endsection

<script>
    const isAuthenticated = @json(auth()->check());  // Converts true/false into JSON format
    const authUserName = @json(auth()->user()->name ?? '');  // Converts username into JSON format
</script>
