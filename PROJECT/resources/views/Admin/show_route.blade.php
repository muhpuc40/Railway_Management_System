@extends('layouts/admin')
@section('content')
    <div class="container">
        <h2 style="text-align: center;">Routes Information</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Distance</th>
                    <th>Action</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($routes as $route)
                <tr>
                    <td>{{ $route->id }}</td>
                    <td>{{ $route->source }}</td>
                    <td>{{ $route->destination }}</td>
                    <td>{{ $route->distance }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
