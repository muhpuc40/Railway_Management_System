@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h1>{{ $stopages->isNotEmpty() ? 'Running' : 'Create' }} Schedule for Train: 
                            <a href="{{ route('train_details', $train->id) }}" > {{ $train->name }}</h1></a>
                        <form action="{{ route('store_schedule') }}" method="post">
                            @csrf
                            <input type="hidden" name="train_id" value="{{ $train->id }}">
                            <div class="row">
                                <div class="col-md-8">
                                    @if($stopages->isEmpty())
                                        <button type="button" class="btn btn-success" onclick="addClass('classTable')">Add More</button>
                                    @endif
                                    <table class="table-responsive" id="classTable">
                                        <tbody><br>
                                            @if($stopages->isNotEmpty())
                                                @foreach ($stopages as $index => $stopage)
                                                    <tr>
                                                        <td>{{ $stopage->sequence }}. Station: <strong> {{ $stopage->source_station }}</strong></td>
                                                        <td>Time: <strong>{{ $stopage->time }}</strong> </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td><input required type="text" class="form-control" placeholder="Source station" name="stopages[0][source_station]"></td>
                                                    <td><input required type="text" class="form-control" placeholder="Time" name="stopages[0][time]"></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4"><br>
                                    @foreach(['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                        <div>
                                            <label>
                                                <input type="checkbox" name="days[]" value="{{ $day }}" {{ ($days && $days->$day) ? 'checked' : '' }} {{ $stopages->isNotEmpty() ? 'disabled' : '' }}> 
                                                {{ ucfirst($day) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <br>
                            @if($stopages->isEmpty())
                                <button type="submit" class="btn btn-primary">Save</button>
                            @else
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $train->id }}">Update</button>

                            

                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-- Modal for Updating Schedule -->
<div class="modal fade" id="editModal{{ $train->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $train->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Update Schedule for Train: {{ $train->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateScheduleForm" action="{{ route('update_schedule', ['train_id' => $train->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="train_id" value="{{ $train->id }}">
                    <div class="row">
                        <div class="col-md-8">
                            <button type="button" class="btn btn-success btn-sm" onclick="addClass('updateClassTable')">Add More</button>
                            <table class="table-responsive" id="updateClassTable">
                                <tbody>
                                    @foreach ($stopages as $index => $stopage)
                                        <tr>
                                            <td><input required type="text" class="form-control" placeholder="Source station" name="stopages[{{ $index }}][source_station]" value="{{ $stopage->source_station }}"></td>
                                            <td><input required type="text" class="form-control" placeholder="Time" name="stopages[{{ $index }}][time]" value="{{ $stopage->time }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            @foreach(['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                <div>
                                    <label>
                                        <input type="checkbox" name="days[]" value="{{ $day }}" {{ ($days && $days->$day) ? 'checked' : '' }}> 
                                        {{ ucfirst($day) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>



    <script>
        function addClass(tableId) {
            var table = document.getElementById(tableId);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            var cell0 = row.insertCell(0);
            var cell1 = row.insertCell(1);
            var cell2 = row.insertCell(2);

            cell0.innerHTML = `<input type="text" class="form-control" placeholder="Source station" name="stopages[${rowCount}][source_station]">`;
            cell1.innerHTML = `<input type="text" class="form-control" placeholder="Time" name="stopages[${rowCount}][time]">`;
            cell2.innerHTML = '<button class="btn btn-danger" onclick="removeRow(this)">X</button>';
        }

        function removeRow(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>
@endsection
