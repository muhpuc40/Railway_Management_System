@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">All Train Schedules</h2>
    
    <div class="row">
        <div class="col-md-12 mb-3">
            <table class="table" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Train Name</th>
                        <th>Working Days</th>
                        <th>Stoppages with Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td >{{ $schedule['train']->name }}</td>
                            <td>
                                @if ($schedule['days'])
                                    <ul class="list-group list-group-flush">
                                        @if ($schedule['days']->saturday) <li class="list-group-item">Saturday</li> @endif
                                        @if ($schedule['days']->sunday) <li class="list-group-item">Sunday</li> @endif
                                        @if ($schedule['days']->monday) <li class="list-group-item">Monday</li> @endif
                                        @if ($schedule['days']->tuesday) <li class="list-group-item">Tuesday</li> @endif
                                        @if ($schedule['days']->wednesday) <li class="list-group-item">Wednesday</li> @endif
                                        @if ($schedule['days']->thursday) <li class="list-group-item">Thursday</li> @endif
                                        @if ($schedule['days']->friday) <li class="list-group-item">Friday</li> @endif
                                    </ul>
                                @else
                                    <span>Not added</span>
                                @endif
                            </td>
                            <td>
                                @if (!$schedule['stopages']->isEmpty())
                                    <ul class="list-group list-group-flush">
                                        @foreach ($schedule['stopages'] as $stopage)
                                            <li class="list-group-item">
                                                {{ $stopage->sequence }}. Station: {{ $stopage->source_station }} Time: {{ $stopage->time }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>Not added</span>
                                @endif
                            </td>
                            <td> <a href="{{ route('create_schedule', ['train_id' => $schedule['train']->id]) }}" class="btn btn-danger">Update</a></td>
                        </tr>
                    @endforeach
                    @if(empty($schedules))
                        <tr>
                            <td colspan="3" class="text-center">No schedules available.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
