@extends('layouts.app')
@section('title', 'Register')
@section('content')

<section class="bg-body-tertiary">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm py-3 px-4">
                       
                          
                                <img src="{{ asset('images/verify.svg') }}" class="img-fluid" alt="Promotional Image" style="max-height: 40px;">  
                                <p class="mb-0 text-uppercase fw-bold text-secondary" style="font-size: 16px; text-align: center;">
                                   Create new account
                                </p>   
                            
                        
                        <form class="row gy-2" action="{{url('register')}}" method="post">
                            @csrf
                            <div class="col-12">
                                <label for="nameInp" class="form-label" style="font-size: 14px;">Name</label>
                                <input type="text" class="form-control" id="nameInp" name="name" value="{{old('name')}}" style="padding: 8px;">
                                @error('name')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                            <div class="col-12">
                                <label for="emailInp" class="form-label" style="font-size: 14px;">Email Address</label>
                                <input type="email" class="form-control" id="emailInp" name="email" value="{{old('email')}}" style="padding: 8px;">
                                @error('email')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                            <div class="col-12">
                                <label for="dobInp" class="form-label" style="font-size: 14px;">Date of Birth</label>
                                <input type="date" class="form-control" id="dobInp" name="date_of_birth" value="{{old('date_of_birth')}}" style="padding: 8px;">
                                @error('date_of_birth')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                            <div class="col-12">
                                <label for="passInp" class="form-label" style="font-size: 14px;">Password</label>
                                <input type="password" class="form-control" id="passInp" name="password" style="padding: 8px;">
                                @error('password')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                            <div class="col-12">
                                <label for="confirmPassInp" class="form-label" style="font-size: 14px;">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassInp" name="password_confirmation" style="padding: 8px;">
                                @error('password_confirmation')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit" style="padding: 10px;">Register</button>
                            </div>
                        </form>
                        <div class="mt-2 text-center">
                            <p class="mb-0" style="font-size: 14px;">
                                Already have an account?
                                <a class="fw-medium" href="{{url('login')}}">
                                    Login
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
