@extends('layouts.admin')

@section('content')
<div class="container">

        <h2> Create Train</h2>
        <form action="{{ url('department/store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for=""> Name </label>
                <input class="form-control" type="text" name="name" id="">
            </div>
            <div class="form-group">
                <label for="">Capacity</label>
                <input class="form-control" type="text" name="shortName" id="">
            </div>
            <div class="form-group">
                <label for="">Route id</label>
                <input class="form-control" type="date" name="estAt" id="">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>

@endsection
