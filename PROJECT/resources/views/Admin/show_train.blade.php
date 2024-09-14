@extends('layouts.admin')
@php
    use Carbon\Carbon;
@endphp

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">All Trains Information</h2>
    <div class="row">
        @foreach ($trains as $train)
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-train me-2"></i> <!-- Font Awesome icon for train -->
                            <h5 class="card-title mb-0">{{ $train->name }}</h5>
                        </div>
                        <a href="{{ route('train_details', $train->id) }}" class="btn btn-outline-info btn-sm">Details</a>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <small class="text-muted">
                                Created at: {{ Carbon::parse($train->created_at)->format('d-m-Y') }}<br>
                                Updated at: {{ Carbon::parse($train->updated_at)->format('d-m-Y') }}
                            </small>
                        </p>
                        <p class="card-text"><small class="text">Total Capacity: {{ $train->capacity }}</small></p>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('create_schedule', ['train_id' => $train->id]) }}"
                                class="btn btn-success btn-sm"
                                onclick="return confirm('Are you sure you want to see schedule?')">Schedule</a>
                            <a href="{{ route('create_fare', ['train_id' => $train->id]) }}" class="btn btn-primary btn-sm"
                                onclick="return confirm('Are you sure you want see fare?')">Fare</a>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    id="actionDropdown{{ $train->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $train->id }}">
                                    <li><a class="dropdown-item text-warning" href="#" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $train->id }}">Edit</a></li>
                                    <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $train->id }}">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $train->id }}" tabindex="-1"
                aria-labelledby="editModalLabel{{ $train->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('update_train', $train->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $train->id }}">Edit Train</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $train->name }}"
                                        required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal{{ $train->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel{{ $train->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $train->id }}">Delete Train</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete <b>{{ $train->name }}</b> train?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- Trigger for the second modal -->
                            <button class="btn btn-danger" data-bs-target="#passwordModal{{ $train->id }}"
                                data-bs-toggle="modal">Confirm Deletion</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Confirmation Modal -->
            <div class="modal fade" id="passwordModal{{ $train->id }}" tabindex="-1"
                aria-labelledby="passwordModalLabel{{ $train->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('delete_train', $train->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-header">
                                <h5 class="modal-title" id="passwordModalLabel{{ $train->id }}">Enter Admin Password</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
</div>
@endsection