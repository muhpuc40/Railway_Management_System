@extends('layouts.admin')
@section('content')
<div>
    <h2 class="" align="center">Admin Dashboard</h2><br>
</div>
<div class="card">
    <div class="card-header" align="center"><b>Today Report</b></div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-header" align="center">
                        <h6>Ticket Sales</h6>
                    </div>
                    <div class="card-body " align="center">
                        <h3>543</h3>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-header" align="center">
                        <h6>Cancelled Tickets</h6>
                    </div>
                    <div class="card-body " align="center">
                        <h3>63</h3>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-header" align="center">
                        <h6>Total Revenue</h6>
                    </div>
                    <div class="card-body " align="center">
                        <h3>4493</h3>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-header" align="center">
                        <h6>Passenger compliance</h6>
                    </div>
                    <div class="card-body " align="center">
                        <h3>1</h3>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection