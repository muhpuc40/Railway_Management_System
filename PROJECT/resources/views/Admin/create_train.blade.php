@extends('layouts/admin')

@section('content')
<div class="container">
    <div class="row">
        {{-- card 1 --}}
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="holder.js/100x180/" alt="">
                <div class="card-body">
                <h1>Create Train</h1>
                <form action="{{ route('Create_Train') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="capacity">Capacity</label>
                        <input type="text" name="capacity" id="capacity" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="route">Route</label>
                        <select name="route" id="route" class="form-control">
                            <option value="">Select Route</option>
                            @foreach($routes as $route)
                                <option value="{{ $route->id }}">{{ $route->source }} to {{ $route->destination }}</option>
                            @endforeach
                        </select>
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
