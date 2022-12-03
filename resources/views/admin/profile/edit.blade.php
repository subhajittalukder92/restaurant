@extends('admin.layouts.backend')

@section('content')

<section class="profile-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                     <div class="profile-about-box">  
                        <div class="profile-content">
                        @if(session('success'))
                        <div class="alert alert-success" role="alert">
                        {{session('success')}}
                        </div>
                        @endif
                        <form action="{{route('admin.profile.update')}}" method="post" class="join-now-form">
                        @csrf
                        <div class="row">
                        <div class="col-md-12 padd-10">
                        <div class="form-group">
                            <label for="first_name">Name</label>
                            <input type="name" class="form-control" placeholder="Enter Full Name" id="name" name ='name' value="{{$user->name}}">
                            @error('name')
                                <div class="alert alert-danger alert-danger_margin">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                        <div class="col-md-12 padd-10">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" placeholder="Enter email" id="email" name="email" value="{{$user->email}}">
                            @error('email')
                                <div class="alert alert-danger alert-danger_margin">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                        <div class="col-md-12 padd-10">
                        <div class="form-group">
                            <label for="plan">Password </label>
                            <input type="password" class="form-control" placeholder="Enter Password" name="password">
                        </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="joun-button">
                                <button class="custom-button btn btn-primary">Update Profile</button>
                            </div>
                        </div>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection