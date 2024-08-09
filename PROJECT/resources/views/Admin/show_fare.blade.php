@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-center">Cart of all train fares</h2>
            <a href="{{ route('download_fare_pdf') }}" class="btn btn-primary">Download PDF</a>
        </div>
        
        <div class="row">
            <div class="col-md-12 mb-3">
                <table class="table table-striped" id="datatablesSimple">
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
            </div>
        </div>
    </div>
@endsection
