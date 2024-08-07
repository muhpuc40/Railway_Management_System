@extends('layouts.admin')

@section('content')
<div class="container">

    <h2 class="text-center mb-4">{{ $fares->isNotEmpty() ? 'Running' : 'Create' }} Fare Rates for Train: 
        <a href="{{ route('train_details', $train->id) }}" > {{ $train->name }}</h2></a>

    @if($fares->isEmpty())
        <form action="{{ route('store_fare') }}" method="post">
            @csrf
            <input type="hidden" name="train_id" value="{{ $train_id }}">
            <table class="table responsive-table-input-matrix">
                <thead>
                    <tr>
                        <th></th>
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
                                    <input type="number" name="fares[{{ $route->id1 }}_{{ $route->id2 }}][{{ $class }}]"
                                        class="form-control" placeholder="Enter fare">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Save Fares</button>
        </form>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Route</th>
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
        <a type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#editModal{{ $train->id }}">Update</a>

        <!-- Update Modal -->
        <div class="modal fade" id="editModal{{ $train->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $train->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Update Fare Rates for Train: {{ $train->name }}</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateFareForm" action="{{ route('update_fare', ['train_id' => $train_id]) }}"
                            method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="train_id" value="{{ $train_id }}">
                            <table class="table responsive-table-input-matrix">
                                <thead>
                                    <tr>
                                        <th></th>
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
                                                        $fare = $fares[$route->id1][$route->id2][$class]->first()->fare ?? null;
                                                    @endphp
                                                    <input required type="number"
                                                        name="fares[{{ $route->id1 }}_{{ $route->id2 }}][{{ $class }}]"
                                                        class="form-control" value="{{ $fare }}">
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection