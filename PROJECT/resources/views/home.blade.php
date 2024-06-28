@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">           
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            
            <!-- Form and Image Section -->
            <div class="row">
                <!-- Left Column for Form -->
                <div class="col-md-8">
                    <form method="POST" action="{{ url('/search-trains') }}">
                        @csrf
                        <div class="row">
                            <!-- Left Column for From and To fields -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <b><label for="fromStation">{{ __('From') }}</label></b>
                                    <input type="text" class="form-control" id="fromStation" name="fromStation" placeholder="From Station" required>
                                </div>
                                <div class="form-group mt-3">
                                    <b><label for="dateOfJourney">{{ __('Date of Journey') }}</label></b>
                                    <input type="date" class="form-control" id="dateOfJourney" name="dateOfJourney" required>
                                </div>
                                
                            </div>

                            <!-- Right Column for Date and Class fields -->
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <b><label for="toStation">{{ __('To') }}</label></b>
                                    <input type="text" class="form-control" id="toStation" name="toStation" placeholder="To Station" required>
                                </div>
                                <div class="form-group mt-3">
                                   <b><label for="class">{{ __('Choose Class') }}</label></b> 
                                    <select class="form-control" id="class" name="class" required>
                                        <option value="">{{ __('Choose a Class') }}</option>
                                        <option value="1">{{ __('First Class') }}</option>
                                        <option value="2">{{ __('Second Class') }}</option>
                                        <option value="3">{{ __('Sleeper Class') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-3">                         
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Search Trains') }}</button>                         
                        </div>
                    </form>
                </div>
                <!-- End of Form Column -->

                <!-- Right Column for Image -->
                <div class="col-md-4">
                    <img src="{{ asset('images/01.jpg') }}" class="img-fluid" alt="Promotional Image">
                </div>

                <!-- End of Image Column -->
            </div>
            <!-- End of Form and Image Section -->

               
           
    </div>
</div>
@endsection
