@extends('layouts.admin')
@section('title', 'Search Results')
@section('content')
<div class="container">
    <h1>Search Results</h1>
    @if($trains->isEmpty())
        <div class="text-center">
            <img src="{{ asset('images/train.png') }}" class="img-fluid" alt="Promotional Image">
            <p class="mt-3">No trains found for the given Route.</p>
        </div>
    @else
        <ul class="list-group">
            @foreach($trains as $train)
                <li class="list-group-item">
                    <h5>{{ $train }}</h5>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection