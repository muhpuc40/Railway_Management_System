@extends('layouts.user')

@section('title', 'BD Railway E-Ticketing')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">

@section('content')
<div class="container mt-5">
    <!-- Alert Boxes -->
    <div class="alert alert-success" role="alert">
        <strong>Important Notice:</strong> Co-passengers' names (as given on their NID/photo ID) are mandatory to complete the ticket purchase process. All passengers MUST carry their NID/photo ID document while traveling.
    </div>
    <div class="alert alert-success" role="alert">
        Please complete the passenger details, review and continue to the payment page within 5 minutes, or the selected seat(s) will be released and you will have to re-initiate the booking process.
    </div>

    <div class="container mt-5">
        <div class="row">
            <!-- Left Side - Passenger Details and Contact Information -->
            <div class="col-md-8">
                <!-- Passenger 1 Card -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Passenger 1 Details</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="passenger1" class="form-label">Name</label>
                                <input type="text" class="form-control" id="passenger1" value="Tanbir Ahamed">
                            </div>
                            <div class="mb-3">
                                <label for="passengerType1" class="form-label">Passenger Type</label>
                                <select id="passengerType1" class="form-control">
                                    <option selected>Adult</option>
                                    <option>Child</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Passenger 2 Card -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Passenger 2 Details</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="passenger2" class="form-label">Name</label>
                                <input type="text" class="form-control" id="passenger2" placeholder="Enter Full Name">
                            </div>
                            <div class="mb-3">
                                <label for="passengerType2" class="form-label">Passenger Type</label>
                                <select id="passengerType2" class="form-control">
                                    <option selected>Adult</option>
                                    <option>Child</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Information Card -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile*</label>
                                <input type="text" class="form-control" id="mobile" placeholder="Enter Mobile Number">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side - Journey Details (without card) -->
            <div class="col-md-4 ml-auto">
                <div class="mt-4 journey-details">                    
                    <div class="journey-box">
                         <h5>JOURNEY DETAILS</h5>
                         <div class="line"></div>
                        <p><strong>Train:</strong> CHATTALA EXPRESS (801) [SNIGDHA]</p>
                        <p><strong>From:</strong> Chattogram - Dhaka</p>
                        <p>Departure: Wed, 11 Sep 2024, 06:00 AM</p>
                        <div class="line"></div>
                        <p><strong>Coach:</strong> UMA</p>
                        <p><strong>Seat Type:</strong> SNIGDHA</p>
                        <p><strong>Seats:</strong> UMA-6, UMA-7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/user.js') }}"></script>

@endsection
