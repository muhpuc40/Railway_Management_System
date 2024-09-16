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
            <input type="tel" name="mobile" id="mobile" class="input">
          </div>
          <div class="form-group">
            <label for="email" class="label">Email*</label>
            <input type="email" name="email" id="email" class="input">
          </div>
        </div>
      </div>
      <!-- Card for Payment Details (New Card) -->
      
      <!-- Journey Details Section -->
      <div class="details-section">
        <div class="timer">
          <div class="timer-value">5:00</div>
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
            <div class="payment-methods justify-content-center">
                
                <div class="proceed-button-container">
                <button class="btn btn-primary btn-block" id="sslczPayBtn"
                        token="if you have any token validation"
                        postdata="your javascript arrays or objects which requires in backend"
                        order="If you already have the transaction generated for current order"
                        endpoint="{{ url('/pay-via-ajax') }}"> Pay Now
                </button>
                </div>
          </div>
<script src="{{ asset('js/user.js') }}"></script>
@endsection

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
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

    var obj = {};
obj.cus_name = $('#customer_name').val();
obj.cus_phone = $('#mobile').val();
obj.cus_email = $('#email').val();
obj.cus_addr1 = $('#address').val();
obj.amount = $('#total-amount').text().replace('৳', '').trim();  // Get the text without the currency symbol


// Set the button postdata to the collected data
$('#sslczPayBtn').prop('postdata', obj);

// Log the object for debugging purposes
console.log(obj);

// Add SSLCommerz script
(function (window, document) {
    var loader = function () {
        var script = document.createElement("script"),
            tag = document.getElementsByTagName("script")[0];
        // Use this for live: script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
        script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // Use this for sandbox
        tag.parentNode.insertBefore(script, tag);
    };
    window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
})(window, document);

</script>
