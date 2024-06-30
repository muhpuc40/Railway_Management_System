@extends('layouts.admin')

@section('content')
<div class="container">

        <h2> Create Route</h2>
        <form action="{{ url('department/store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for=""> Source </label>
                <input class="form-control" type="text" name="name" id="">
            </div>
            <div class="form-group">
                <label for="">Destination</label>
                <input class="form-control" type="text" name="shortName" id="">
            </div>
            <div class="form-group">
                <label for="">Distance</label>
                <input class="form-control" type="text" name="shortName" id="">
            </div>
            <div class="form-group">
                <label for="">duration</label>
                <input class="form-control" type="text" name="estAt" id="">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>

@endsection
