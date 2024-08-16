<!DOCTYPE html>
<html>
<head>
    <title>Train Fares</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .header {
            position: relative;
            margin-bottom: 10px;
            padding-top: -10px;
        }
        .header img {
            width: 60px;
            height: 60px;
        }

        
        h1 {
            margin: 0;
            padding: 0;
            font-size: 24px;
            color: blue; /* Setting the text color to blue */
        }
        h2 {
            margin-bottom: 20px;
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .footer {
            font-size: 10px;
            color: #888888;
            text-align: center;

        }
    </style>
</head>
<body>
    <div class="header">

        <h1>BANGLADESH RAILWAY</h1>

    </div>
    <h2>Cart of all train fares</h2>
    
    <table>
        <thead>
            <tr>
                <th>Train Name</th>
                <th>Stopage</th>
                @foreach($classes as $class)
                    <th>{{ $class }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($groupedFares as $trainName => $stopages)
                @foreach($stopages as $stopage => $classFares)
                    <tr>
                        <td>{{ $trainName }}</td>
                        <td>{{ $stopage }}</td>
                        @foreach($classes as $class)
                            <td>{{ $classFares[$class] ?? 'N/A' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <div class="footer">
Pdf generate by minhaj || Download time : {{$time}}
        </div>
</body>
</html>
