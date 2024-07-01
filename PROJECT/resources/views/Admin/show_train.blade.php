@extends('layouts/admin')
@section('content')
    <div class="container">
        <h2 style="text-align: center;">Trains Information</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Capacity</th>
                    <th>Route</th>
                    <th>Action</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trains as $train)
                <tr>
                    <td>{{ $train->id }}</td>
                    <td>{{ $train->name }}</td>
                    <td>{{ $train->capacity }}</td>
                    <td>{{ $train->route_id }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
