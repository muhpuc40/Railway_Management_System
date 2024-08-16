<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bangladesh Railway E-Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .container {
            width: 186mm;
            margin: 5px auto;
            padding: 7px;
            background-color: #ffffff;
            border: 3px solid #28a745;
            box-sizing: border-box; 
            position: relative;
            left: -3mm; /* Adjust this value to move further left */
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            margin-bottom: 10px;
            position: relative;
        }
        .header h1 {
            color: #0073e6;
            font-size: 32px;
            margin: 0;
            margin-top: 15px; /* Adjusted to push it down slightly */
        }
        .qr-code {
            position: absolute;
            top: 16px; /* Adjusted to move it just below the margin line */
            right: 18px;
            width: 80px;
            height: 40px;
            border: 1px solid #ddd;
            text-align: center;
            line-height: 80px;
            font-size: 12px;
            color: #aaa;
        }
        .logo-left {
            position: absolute;
            top: 10px;
            left: 5px;
            width: 50px; /* Reduced width */
            height: 50px; /* Reduced height */
        }

        .journey-info, .passenger-info {
            margin-bottom: 15px;
            clear: both;
        }
        .section-title {
            background-color: #28a745;
            color: #ffffff;
            padding: 5px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }
        .info-table td {
            padding: 4px;
            border: 1px solid #ddd;
        }
        .info-table td:first-child {
            font-weight: bold;
            background-color: #f9f9f9;
            width: 40%;
        }
        .footer {
            font-size: 10px;
            color: #888888;
            text-align: left;
            margin-top: 10px;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
        .footer strong {
            color: #000000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('images/logo.png') }}" class="logo-left">
            <h1>BANGLADESH RAILWAY</h1>
            
            <div class="qr-code"><img src="data:image/png;base64,{{ $qrcode }}"></div>
        </div>
        <div style="position: relative;">
            <p>Dear {{ $passenger_name }},</p>
            <p style=" max-width: 80%;float: left; font-size: 16px;margin-top: -5px;">
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

            <p>Wishing you a pleasant and safe journey— <strong>Bangladesh Railway</strong> </p>
        </div>
    </div>
    <p align="center">Download time : {{$time}}</p>
</body>
</html>
