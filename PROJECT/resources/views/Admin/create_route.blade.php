@extends('layouts/admin')

@section('content')
<div class="container">
    <div class="row">
        {{-- card 1 --}}
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="holder.js/100x180/" alt="">
                <div class="card-body">
                <h1>Create Route</h1>
                <form action="{{ route('Create_Route') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="source">Source</label>
                        <input type="text" name="source" id="source" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="destination">Destination</label>
                        <input type="text" name="destination" id="destination" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="distance">Distance</label>
                        <input type="text" name="distance" id="distance" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <input type="text" name="duration" id="duration" class="form-control" autocomplete="off">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
