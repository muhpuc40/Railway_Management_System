@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Train: {{ $train->name }} ~ 
        @if($stopages->isNotEmpty())
            Route: {{ $stopages->first()->source_station }} to {{ $stopages->last()->source_station }}
        @endif
    </h2>

    <div class="row">
        {{-- First row for train details, working days, and stoppages --}}
        <div class="col-md-12 mb-3">
            <div class="row">
                {{-- Card for train details --}}
                <div class="col-md-5 mb-3">
                    <div class="card">
                        <div class="card-header">
                            Train Details
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($details as $detail)
                                    <li class="list-group-item">
                                        Coach: {{ $detail->coach }}
                                        Class: {{ $detail->class }}
                                        Capacity: {{ $detail->capacity }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                @if($days)
                {{-- Card for working days --}}
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            Working Days
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @if ($days->saturday) <li class="list-group-item">Saturday</li> @endif
                                @if ($days->sunday) <li class="list-group-item">Sunday</li> @endif
                                @if ($days->monday) <li class="list-group-item">Monday</li> @endif
                                @if ($days->tuesday) <li class="list-group-item">Tuesday</li> @endif
                                @if ($days->wednesday) <li class="list-group-item">Wednesday</li> @endif
                                @if ($days->thursday) <li class="list-group-item">Thursday</li> @endif
                                @if ($days->friday) <li class="list-group-item">Friday</li> @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                @if($stopages->isNotEmpty())
                {{-- Card for stoppages --}}
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-header">
                            Stopages
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($stopages as $stopage)
                                    <li class="list-group-item">
                                        {{ $stopage->sequence }}.
                                        Station: {{ $stopage->source_station }}
                                        Time: {{ $stopage->time }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($fares->isNotEmpty())
        {{-- Second row for fare display --}}
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    Fare Rates
                </div>
                <div class="card-body">
                    <table class="table responsive-table-input-matrix">
                        <thead>
                            <tr>
                                <th>From - To</th>
                                @foreach ($trainDetails as $class)
                                    <th>{{ strtoupper($class) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainRoutes as $route)
                                <tr>
                                    <td>{{ $route->source_station1 }} TO {{ $route->source_station2 }}</td>
                                    @foreach ($trainDetails as $class)
                                        <td>
                                            @php
                                                $fare = $fares[$route->id1][$route->id2][$class]->first()->fare ?? 'N/A';
                                            @endphp
                                            {{ $fare }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
