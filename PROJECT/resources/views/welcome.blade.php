@extends('layouts.user')

@section('title', 'BD Railway E-Ticketing')

@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="row">
            <!-- Left Column for Form -->
            <div class="col-md-8">
                <form id="searchForm" method="GET" action="{{ route('train-availability.show') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <b><label for="fromStation">{{ __('From') }}</label></b>
                                <select class="form-control" id="fromStation" name="fromStation" autocomplete="off" required>
                                    <option value="">{{ __('Select From Station') }}</option>
                                    @foreach($routes as $route)
                                        <option value="{{ $route->route_name }}">{{ $route->route_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <b><label for="dateOfJourney">{{ __('Date of Journey') }}</label></b>
                                <input type="date" class="form-control" id="dateOfJourney" name="dateOfJourney" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <b><label for="toStation">{{ __('To') }}</label></b>
                                <select class="form-control" id="toStation" name="toStation" autocomplete="off" required>
                                    <option value="">{{ __('Select To Station') }}</option>
                                    @foreach($routes as $route)
                                        <option value="{{ $route->route_name }}">{{ $route->route_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <b><label for="class">{{ __('Choose Class') }}</label></b>
                                <select class="form-control" id="class" name="class" autocomplete="off" required>
                                    <option value="">{{ __('Choose a Class') }}</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class }}">{{ $class }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 row justify-content-center mt-3">
                        <button type="submit" class=" btn btn-primary btn-block">{{ __('Search Trains') }}</button>
                    </div>
                </form>
            </div>

            <!-- Right Column for Image -->
            <div class="image-container">
                <img src="{{ asset('images/01.jpg') }}" class="img-fluid" alt="Promotional Image">
            </div>
        </div>
    </div>   
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
@endsection

