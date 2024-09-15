@extends('layouts.user')

@section('title', 'BD Railway E-Ticketing')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">

@section('content')
<section class="bg-body-tertiary py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h3>{{ $fromStation }} - {{ $toStation }}</h3>
            <div>
                <button class="btn btn-outline-secondary">PREV. DAY</button>
                <button class="btn btn-outline-secondary">NEXT DAY</button>
            </div>
        </div>
        <p class="text-muted mt-2">{{ \Carbon\Carbon::parse($dateOfJourney)->format('d-F-Y') }}</p>

        <div class="card mb-3 p-3 bg text-center">
            <span>Please Note: Other users may be in the process of purchasing tickets at this moment. But in case of payment failure, those tickets may become available time-to-time.</span>
        </div>

        <div class="row">
        @foreach($trains as $train)
        <div class="p-1.5">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <span>{{ $train['name'] }} ({{ $train['code'] }})</span>
                    <i class="fa fa-chevron-down"></i>
                </div>
                <!-- Train Details Section -->
                <div class="train-details" style="display:none;">
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <p id="departure-time"><strong>{{ $train['departure_time'] }}</strong></p>
                        <p id="departure-station">{{ $train['departure_station'] }}</p>
                    </div>
                    <div>
                        <p id="arrival-time"><strong>{{ $train['arrival_time'] }}</strong></p>
                        <p id="arrival-station">{{ $train['arrival_station'] }}</p>
                    </div>
                </div>
                    <div class="ticket-section d-flex justify-content-left">
                    @foreach($train['tickets'] as $ticket)
                        <div class="ticket-type">
                            <p class="ticket-class">{{ $ticket['class'] }}</p>
                            <p class="ticket-price">৳{{ $ticket['fare'] }}</p>                            
                            <p class="ticket-availability">Available Tickets</p>
                            <p class="ticket-available">{{ $ticket['available'] }}</p>
                            @auth
                                <a class="btn btn-success book-now-btn" 
                                data-class="{{ $ticket['class'] }}" data-coaches="{{ json_encode($ticket['coaches']) }}">BOOK NOW</a>
                            @else
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">BOOK NOW</button>
                            @endauth
                        </div>
                    @endforeach
                    </div>
                    <!-- Add seat selection section (this will be toggled by clicking "BOOK NOW") -->
                    
                    <div class="mt-4 seat-selection">
                        <h5>Choose your seat(s)** Maximum 4 seats can be booked at a time.</h5>
                        <p>To know seat number(s), rest the cursor on your desired seat(s). Click on it to select or deselect.</p>
                    
                        <label>Select Coach</label>
                        <select class="form-control coach-select" id="sl">
                            <!-- Options will be dynamically added based on selected class -->
                        </select>
                        <div class="seat-selection-container">
                        <div id="seat-map" class="seat-map">
                            <!-- Dynamically generated seats will appear here -->
                        </div>                     
                            <div class="seat-details">
                                <h5>Seat Details</h5>
                                <table id="seatDetailsTable">
                                    <thead>
                                        <tr>
                                            <th>Class</th>
                                            <th>Seat Number</th>
                                            <th>Fare</th>
                                        </tr>
                                    </thead>
                                    <tbody class="seat-details-body">
                                        <!-- Rows will be dynamically added here -->
                                    </tbody>
                                    <tfoot>
                                        <tr class="total">
                                            <td colspan="2">Total</td>
                                            <td>৳0.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                 
                                <label>Boarding Station *</label>
                                <select class="form-control">
                                    <option value="Kamalapur Station">{{ $train['departure_station'] }}</option>
                                </select>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-success">CONTINUE PURCHASE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    </div>
</section>
<!-- Login Modal -->
<div id="loginModal" class="modal fade" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title mx-auto text-success fw-bold" id="loginModalLabel">{{ __('LOGIN') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="row gy-2" action="{{ url('login') }}" method="post">
                @csrf
                <input type="hidden" name="redirect_to" value="/train-availability">
                <div class="col-12">
                    <input type="email" class="form-control p-2" id="emailInp1" name="email" value="{{ old('email') }}" placeholder="Enter Email" autocomplete="email" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-12">
                    <input type="password" class="form-control p-2 mb-3" id="passwordInp1" name="password" placeholder="********" autocomplete="current-password" required>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-12">
                    <button class="btn btn-success w-100 p-1 fw-bold" id="login-btn" type="submit">{{ __('LOGIN') }}</button>
                </div>
            </form>

            </div>
            <div class="modal-footer d-flex justify-content-between border-0">
                <a href="{{ url('register') }}" class="text-decoration-none">{{ __('Register') }}</a>
                <a href="{{ url('password/reset') }}" class="text-decoration-none">{{ __('Forgot Password?') }}</a>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/user.js') }}"></script>

@endsection
<script>
    const purchaseTicketUrl = "{{ route('user.purchase_ticket') }}";
</script>
