@extends('layouts.user')
@section('title', 'Purchased Ticket')
<link rel="stylesheet" href="{{ asset('css/ticket.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
<a href="{{ route('generate-ticket', ['download' => true]) }}" class="btn btn-success">Download Ticket as PDF</a>
<div class="container">
    
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" class="logo-left">
        <h1>BANGLADESH RAILWAY</h1>
        <div class="qr-code"><img src="data:image/png;base64,{{ $qrcode }}"></div>
    </div>
    <div style="position: relative;">
        <p>Dear {{ $passenger_name }},</p>
        <p style="max-width: 80%; float: left; font-size: 16px; margin-top: -5px;">
            Your request to book an e-ticket for your journey with Bangladesh Railway was successful.
            The details of your e-ticket are as below:
        </p>
    </div>
    <div class="journey-info">
        <div class="section-title">Journey Information</div>
        <table class="info-table">
            <tr><td>Issue Date & Time:</td><td>{{ $issue_date }}</td></tr>
            <tr><td>Journey Date & Time:</td><td>{{ $journey_date }}</td></tr>
            <tr><td>Train Name & Number:</td><td>{{ $train_name }}</td></tr>
            <tr><td>From Station:</td><td>{{ $from_station }}</td></tr>
            <tr><td>To Station:</td><td>{{ $to_station }}</td></tr>
            <tr><td>Class Name:</td><td>{{ $class_name }}</td></tr>
            <tr><td>Coach Name / Seat(s):</td><td>{{ $coach_seat }}</td></tr>
            <tr><td>No. of Seats:</td><td>{{ $num_seats }}</td></tr>
            <tr><td>No. of Adult Passenger(s):</td><td>{{ $num_adult }}</td></tr>
            <tr><td>No. of Child Passenger(s):</td><td>{{ $num_child }}</td></tr>
            <tr><td>Fare:</td><td>{{ $fare }}</td></tr>
            <tr><td>VAT:</td><td>{{ $vat }}</td></tr>
            <tr><td>Service Charge:</td><td>{{ $service_charge }}</td></tr>
            <tr><td>Total Fare:</td><td>{{ $total_fare }}</td></tr>
        </table>
    </div>

    <div class="passenger-info">
        <div class="section-title">Passenger Information</div>
        <table class="info-table">
            <tr><td>Passenger Name:</td><td>{{ $passenger_name }}</td></tr>
            <tr><td>Identification Type:</td><td>{{ $id_type }}</td></tr>
            <tr><td>Identification Number:</td><td>{{ $id_number }}</td></tr>
            <tr><td>Mobile Number:</td><td>{{ $mobile_number }}</td></tr>
            <tr><td>PNR Number:</td><td>{{ $pnr_number }}</td></tr>
        </table>
    </div>

    <div class="footer">
        <p><strong>Please Note:</strong></p>
        <ul>
            <li>Carrying NID or Photo ID while travelling is mandatory for each passenger.</li>
            <li>You can carry either a soft copy or printed copy of your e-ticket while travelling.</li>
            <li>No need to print the e-ticket from the counter.</li>
        </ul>

        <p>Wishing you a pleasant and safe journey— <strong>Bangladesh Railway</strong></p>
    </div>
</div>
<p align="center">Purchased time: {{ $time }}</p>

@endsection
