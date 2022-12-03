@extends('admin.layouts.backend')

@section('content')

<section class="profile-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                     <div class="profile-about-box">  
                        <div class="profile-content">
                         @if(session('success'))
                            <div class="alert alert-success" role="alert">
                            {{session('success')}}
                            </div>
                         @endif
                    <form action="{{ route('admin.delivery-boys.store') }}" method="post" class="join-now-form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                          <div class="col-md-12 padd-10">
                                <label for="name">Name</label>
                                <input type="name" class="form-control" placeholder="Enter Name" id="name" name ='name' value="">
                                @error('name')
                                    <div class="alert alert-danger alert-danger_margin">{{ $message }}</div>
                                @enderror
                          </div>
                          
                          <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" placeholder="Enter Email" id="email" name ='email' value="">
                                @error('email')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                          </div>
                          <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" placeholder="Enter Mobile" id="mobile" name ='mobile' value="">
                                @error('mobile')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                          </div>
                          <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="password">Password </label>
                                <input type="password" class="form-control" placeholder="Enter Password" name="password">
                            </div>
                                @error('password')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                          </div>
                         
                          <div class="col-md-12 padd-10">
                                <div class="joun-button">
                                    <button class="custom-button btn btn-primary">Submit</button>
                                    <a href="{{ route('admin.delivery-boys.index') }}" class="btn btn-primary">Cancel</a>
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