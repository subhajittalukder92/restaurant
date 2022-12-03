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
                        <form action="" method="POST" class="join-now-form">
                            <div class="row">
                              <div class="col-md-12 padd-10">
                                <div class="form-group">
                                <label for="name">Name</label>
                                    <input type="name" class="form-control" placeholder="Enter Name" id="name" name ='name' value="{{ $deliveryBoy->name }}" readonly>
                                </div>
                             </div>

                            <div class="col-md-12 padd-10">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" placeholder="Enter Email" id="email" name ='email' value="{{ $deliveryBoy->email }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12 padd-10">
                                <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" placeholder="Enter Mobile" id="mobile" name ='mobile' value="{{ $deliveryBoy->mobile }}" readonly>
                            </div>
                          </div>
                          <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="password">Password </label>
                                <input type="password" class="form-control" placeholder="Enter Password" name="password" readonly>
                            </div>
                          </div> 

                                <div class="col-md-12 padd-10">
                                    <div class="joun-button">
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