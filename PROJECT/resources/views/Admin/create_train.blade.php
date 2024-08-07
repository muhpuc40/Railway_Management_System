@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        {{-- card 1 --}}
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h1>Create Train</h1>
                    <form action="{{ route('Store_Train') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Train Name" required>
                        </div>

                        <div><br></div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Coach & Class & Capacity:</label>
                                        <div class="col-sm-9">
                                            <button type="button" class="btn btn-success" onclick="addClass()">Add More</button>
                                            <table class="table-responsive" id="classTable">
                                                <tbody>
                                                    <tr>
                                                        <td><input type="text" class="form-control" placeholder="Coach name" name="coaches[]" required></td>
                                                        <td><input type="text" class="form-control" placeholder="Class name" name="classes[]" required></td>
                                                        <td><input type="text" class="form-control" placeholder="Capacity" name="capacities[]" required></td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function addClass() {
        var table = document.getElementById("classTable");
        var row = table.insertRow(-1);
        var cell0 = row.insertCell(0);
        var cell1 = row.insertCell(1);
        var cell2 = row.insertCell(2);
        var cell3 = row.insertCell(3);

        cell0.innerHTML = '<input type="text" class="form-control" placeholder="Coach name" name="coaches[]" required>';
        cell1.innerHTML = '<input type="text" class="form-control" placeholder="Class name" name="classes[]" required>';
        cell2.innerHTML = '<input type="text" class="form-control" placeholder="Capacity" name="capacities[]" required>';
        cell3.innerHTML = '<button class="btn btn-danger" onclick="removeRow(this)">X</button>';
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>
@endsection
